@extends('layouts.app-exams')

@section('title', 'EPT - exam')

@section('extra-css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{asset('assets/plugins/exam-wizard/css/style.css')}}">
<style type="text/css">
    .tablenya td, .tablenya th{
        padding: 1px 10px 1px 10px;
    }
    .filled {
        background-color: #2596be;
        color: #ffff;
    }
    .ptd-6 {
        padding-right: 6px;
        padding-left: 6px;
    }
    p.indent { text-indent: 3.5em; }
    .answer-text {
        font-weight: normal;
    }

    .btn.btn-success.disabled {
        background-color: #c0c0c0;
        border-color: #c0c0c0;
    }

    /*.btn.btn-primary.disabled {
        background-color: #c0c0c0;
        border-color: #c0c0c0;
    }

    .btn.btn-danger.disabled {
        background-color: #c0c0c0;
        border-color: #c0c0c0;
    }*/
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0"> &nbsp;</h1>
            </div>
            <div class="col-sm-6 text-right">
                <h3 id="quiz-time-left">Time Lefts @{{ timeleft }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            
            <!-- /.col-md-12 -->
            <div class="col-lg-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">{{ $section->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Main Paper Exam -->
                            <div class="col-lg-12">
                                <form id="examwizard-question" action="{{ route('exam.store') }}" method="post">
                                    <input type="hidden" name="idsection" value="{{ $idsection }}">
                                    <input type="hidden" name="idmonitoring" value="{{ $idmonitoring }}">
                                    <!-- Loop -->
                                    <?php 
                                        $total = 0;
                                        $j = 1; //part iterator
                                        $i = 1; //question iterator
                                        $a = 0; //all iterator
                                        $first = 0; 
                                    ?>
                                    @foreach($section->part as $part)
                                        <?php 
                                        $a++;
                                        if ($j == 1) {
                                            $first = $j;
                                            $hiddenPart = "";
                                        } else {
                                            $hiddenPart = "hidden";
                                        }
                                        ?>
                                        <div class="question {{$hiddenPart}}" data-question="{{ $a }}">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    {!! $part->direction !!}
                                                </div>
                                            </div>
                                        </div>


                                        @foreach($part->question as $question)
                                            <?php 
                                                $a++;
                                                $total += 1; 
                                            ?>
                                            <div class="question hidden" data-question="{{ $a }}">
                                                @if ($idsection == '3')
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            {!! $question->story !!}
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row" style="padding-top: 10px;padding-bottom: 5px;border-top: dotted 1px;border-bottom: dotted 1px;margin-bottom: 5px">
                                                    <div class="col-xs-12">
                                                        <h5>No . {{ $i }}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12" style="text-align: left;">
                                                        {!! $question->question !!}
                                                    </div>
                                                </div>
                                                <div class="row mt-30">
                                                    <div class="col-xs-12">
                                                        <div class="alert alert-danger hidden"></div>
                                                        <div class="green-radio color-green">
                                                            <ul class="no-bullets">
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio" 
                                                                    v-model="answer.{{'q'.$question->id}}"
                                                                    data-alternatetype="radio" 
                                                                    name="fieldAnswer[{{$question->id}}]" 
                                                                    data-alternateName="answer[{{$i - 1}}]" data-alternateValue="A" 
                                                                    value="A" 
                                                                    id="answer-{{$question->id}}-1"/>
                                                                    &nbsp;
                                                                    <label class="answer-text" for="answer-{{$question->id}}-1">A.&nbsp;<span style="font-weight: normal;">{{ $question->choice_a }}</span></label>
                                                                </li>
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio"
                                                                    v-model="answer.{{'q'.$question->id}}" 
                                                                    data-alternatetype="radio" 
                                                                    name="fieldAnswer[{{$question->id}}]" 
                                                                    data-alternateName="answer[{{$i - 1}}]" data-alternateValue="B" 
                                                                    value="B" 
                                                                    id="answer-{{$question->id}}-2"/>
                                                                    &nbsp;
                                                                    <label for="answer-{{$question->id}}-2" class="answer-text">B.&nbsp;<span style="font-weight: normal;">{{ $question->choice_b }}</span></label>
                                                                </li>
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio"
                                                                    v-model="answer.{{'q'.$question->id}}" 
                                                                    data-alternatetype="radio" 
                                                                    name="fieldAnswer[{{$question->id}}]" 
                                                                    data-alternateName="answer[{{$i - 1}}]" data-alternateValue="C" 
                                                                    value="C" id="answer-{{$question->id}}-3"/>
                                                                    &nbsp;
                                                                    <label for="answer-{{$question->id}}-3" class="answer-text">C.&nbsp;<span style="font-weight: normal;">{{ $question->choice_c }}</span></label>
                                                                </li>
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio"
                                                                    v-model="answer.{{'q'.$question->id}}" 
                                                                    data-alternatetype="radio" 
                                                                    name="fieldAnswer[{{$question->id}}]" 
                                                                    data-alternateName="answer[{{$i - 1}}]" data-alternateValue="D" 
                                                                    value="D" 
                                                                    id="answer-{{$question->id}}-4"/>
                                                                    &nbsp;
                                                                    <label for="answer-{{$question->id}}-4" class="answer-text">D.&nbsp;<span style="font-weight: normal;">{{ $question->choice_d }}</span></label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                        @endforeach

                                        <?php $j++; ?>
                                    @endforeach
                                    <!-- end:Loop -->

                                    <input type="hidden" value="{{$first}}" id="currentQuestionNumber" name="currentQuestionNumber" />
                                    <input type="hidden" value="{{$a}}" id="totalOfQuestion" name="totalOfQuestion" />
                                    <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                                </form>
                            </div>
                            <!-- /.Main Paper Exam -->
                        </div>
                        
                        <!-- Exmas Footer - Multi Step Pages Footer -->
                        <div class="row mt-2">
                            <div class="col-lg-12 exams-footer">
                                <div class="row">
                                    <!-- <div class="col-lg-2 col-sm-1 back-to-prev-question-wrapper text-left">
                                        Previous
                                    </div> -->
                                    <div class="col-lg-11 footer-question-number-wrapper text-center">
                                        <?php /*
                                        <div>
                                            <span id="current-question-number-label">1</span>
                                            <span>Of <b>{{ $total }}</b></span>
                                        </div>
                                        <div>
                                            Question Number
                                        </div>
                                        */?>
                                       <a href="javascript:void(0);" id="back-to-prev-question" style="width:6em;" class="btn btn-danger disabled">
                                            Previous
                                        </a>
                                        &nbsp;&nbsp;&nbsp;
                                       <a href="javascript:void(0);" id="go-to-next-question" style="width:6em;" class="btn btn-primary">
                                            Next
                                        </a>
                                    </div>
                                    <!-- <div class="col-lg-2 go-to-next-question-wrapper text-right">
                                        next
                                    </div> -->
                                    <div class="col-lg-1 footer-finish-question-wrapper text-right">
                                        <a href="javascript:void(0);" id="finishExams" @click="onSubmit" class="btn btn-success disabled" style="width:5em;">
                                            <b>Finish</b>
                                        </a>
                                    </div>                              
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-info card-outline">
                    <div class="card-body">
                        @foreach($all_section as $section)
                            @if ($section->id == $idsection)
                                <?php $i = 1; ?>
                                @foreach($section->part as $part)
                                    <div class="row">
                                        <div class="col-lg-12" style="text-align: left;">
                                            <table class="tablenya" width="100%" style="margin-bottom: 2px;">
                                                <tr>
                                                    <td width="30%">
                                                        <b>{{ $part->title }}</b>
                                                    </td>
                                                    <td>
                                                        <table border="1">
                                                            <tr>
                                                                @foreach($part->question as $question)
                                                                    <td v-if="answer.q{{$question->id}}" class="ptd-6 filled"> {{ $i }} </td>
                                                                    <td v-else class="ptd-6">{{ $i }}</td>
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </tr>    
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>  
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

@endsection

@section('extra-js')
<script src="{{asset('assets/plugins/exam-wizard/js/examwizard.min.js')}}"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    function initialState (){
        return {
            data: {
                idsection: "{{ $idsection }}",
                idmonitoring: "{{ $idmonitoring }}"
            },
            timer: {
                timerItem: "{{ 'section'.$idsection.'_timer' }}",
                total_seconds: "{{$timer}}",
                minutes: 0,
                seconds: 0
            },
            timeleft: "{{ '00:00' }}",
            answer: {!! json_encode($qsheet) !!},
            imgloading: "{{asset('/assets/img/hex-loader.gif')}}",
            errors: []
        }
    }

    let app = new Vue({
        el: "#vue-app",
        data: function (){
            return initialState();
        },
        mounted: function() {
            let vm = this
            
            $.fn.examWizard({
                finishOption: {
                    enableModal: true,
                }
            });
            // localStorage.removeItem(vm.timer.timerItem);

            if(localStorage.getItem(vm.timer.timerItem)){
                vm.timer.total_seconds = localStorage.getItem(vm.timer.timerItem);
                console.log(vm.timer.total_seconds);
            } else {
                console.log('bbb');
            }

            vm.timer.minutes = parseInt(vm.timer.total_seconds/60);
            vm.timer.seconds = parseInt(vm.timer.total_seconds%60);

            setTimeout(() => {
                vm.countDownTimer()
            }, 1000);
        },
        methods: {
            submitData: function() {
                let vm = this
                axios.post(
                    "{{ route('exam.store') }}", {
                        idsection: vm.data.idsection,
                        idmonitoring: vm.data.idmonitoring,
                        answers: vm.answer
                })
                .then(resp => {
                    // console.log(resp.data)
                    if (resp.data.status == "success") {
                        console.log(resp.redirect);
                        window.location.href = resp.data.redirect;
                    }
                })
                .catch(err => {
                    // 
                })
            },
            onSubmit: function(e) {
                e.preventDefault();
                
                this.submitData()
            },
            countDownTimer() {
                let vm = this
       
                if(vm.timer.seconds < 10){
                    vm.timer.seconds= "0"+ vm.timer.seconds ;
                }if(vm.timer.minutes < 10){
                    vm.timer.minutes= "0"+ vm.timer.minutes ;
                }
                
                this.timeleft = vm.timer.minutes+":"+vm.timer.seconds

                if(vm.timer.total_seconds <= 0){
                    // localStorage.removeItem(vm.timer.timerItem);
                    console.log("test")
                    setTimeout(vm.submitData(), 1);
                } else {
                    vm.timer.total_seconds = vm.timer.total_seconds -1 ;
                    vm.timer.minutes = parseInt(vm.timer.total_seconds / 60);
                    vm.timer.seconds = parseInt(vm.timer.total_seconds % 60);

                    localStorage.setItem(vm.timer.timerItem, vm.timer.total_seconds)

                    setTimeout(() => {
                        vm.countDownTimer()
                    }, 1000);
                }
            }
        },

    });
</script>
<script>
    
</script>
@endsection