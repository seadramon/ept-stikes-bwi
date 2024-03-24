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

    form {
        background: #ffff;
    }
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <!-- <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0"> EPT</h1>
            </div>
        </div> -->
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
                                <div v-show="speakerImg">
                                    <img src="{{ asset('assets/img/speaker.webp') }}" width="50" height="50">
                                </div>
                                <form id="examwizard-question" action="{{ route('exam.store') }}" method="post">
                                    <input type="hidden" name="idsection" value="{{ $idsection }}">
                                    <input type="hidden" name="idmonitoring" value="{{ $idmonitoring }}">
                                    <!-- Loop -->
                                    <?php 
                                        $total = 0;
                                        $i = 1;
                                        $first = 0; 
                                    ?>
                                    @foreach($section->part as $part)
                                        <div class="question" v-show="question.{{ 'p'.$part->id }}.show">
                                            <center><h4>{{ $part->title }}</h4></center>
                                            {!! $part->direction !!}
                                        </div>
                                        @foreach($part->question as $question)
                                            <?php 
                                                $total += 1; 
                                                if ($i == 1) {
                                                    $first = $i;
                                                    $hidden = "";
                                                } else {
                                                    $hidden = "hidden";
                                                }
                                            ?>
                                            <div class="question" v-show="question.{{ 'q'.$question->id }}.show" data-question="{{ $i }}">
                                                <div class="row" style="padding-top: 10px;padding-bottom: 5px;border-top: dotted 1px;border-bottom: dotted 1px;margin-bottom: 5px">
                                                    <div class="col-xs-12">
                                                        <h5>No . {{ $i }}</h5>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mt-50">
                                                    <div class="col-xs-1">
                                                        <h5 class="question-title color-green">{{ $question->question }}</h5>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <div class="alert alert-danger hidden"></div>
                                                        <div class="green-radio color-green">
                                                            <ul class="no-bullets">
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio" 
                                                                    v-model="answer.{{'q'.$question->id}}"
                                                                    name="fieldAnswer[{{$question->id}}]" 
                                                                    value="A" 
                                                                    id="answer-{{$question->id}}-1"/>
                                                                    &nbsp;
                                                                    <label class="answer-text" for="answer-{{$question->id}}-1">A.&nbsp;<span style="font-weight: normal;">{{ $question->choice_a }}</span></label>
                                                                </li>
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio"
                                                                    v-model="answer.{{'q'.$question->id}}" 
                                                                    name="fieldAnswer[{{$question->id}}]" 
                                                                    value="B" 
                                                                    id="answer-{{$question->id}}-2"/>
                                                                    &nbsp;
                                                                    <label for="answer-{{$question->id}}-2" class="answer-text">B.&nbsp;<span style="font-weight: normal;">{{ $question->choice_b }}</span></label>
                                                                </li>
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio"
                                                                    v-model="answer.{{'q'.$question->id}}" 
                                                                    name="fieldAnswer[{{$question->id}}]" 
                                                                    value="C" id="answer-{{$question->id}}-3"/>
                                                                    &nbsp;
                                                                    <label for="answer-{{$question->id}}-3" class="answer-text">C.&nbsp;<span style="font-weight: normal;">{{ $question->choice_c }}</span></label>
                                                                </li>
                                                                <li class="font-size-30 answer-number">
                                                                    <input type="radio"
                                                                    v-model="answer.{{'q'.$question->id}}" 
                                                                    name="fieldAnswer[{{$question->id}}]" 
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
                                    @endforeach
                                    <!-- end:Loop -->
                                </form>
                            </div>
                            <!-- /.Main Paper Exam -->
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
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    function initialState (){
        return {
            data: {
                idsection: "{{ $idsection }}",
                idmonitoring: "{{ $idmonitoring }}"
            },
            answer: {!! json_encode($qsheet) !!},
            list: {!! json_encode($list) !!},
            question: {!! json_encode($csheet) !!},
            imgloading: "{{asset('/assets/img/hex-loader.gif')}}",
            speakerImg: false,
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
            var idx = 1;
            var idxChoice = 1
            var idxQuestion = vm.list[0]

            console.log(vm.question[idxQuestion].audio)

            var source = "{{ url('admin/audio-api/audio/') }}" + '/' + vm.question[idxQuestion].audio;
            var audio = document.createElement("audio");

            audio.autoplay = true;
            audio.load()
            audio.addEventListener("load", function() { 
                audio.play(); 
            }, true);
            audio.src = source;

            audio.onplaying = function() {
                vm.speakerImg = true
            }

            audio.onended = function() {
                if(idx <= vm.list.length){
                    vm.question[vm.list[0]].show = false
                    // console.log('idx = ' + idx + ' idxChoice = ' + idxChoice + ' idxQuestion = ' + idxQuestion)

                    //show choice                    
                    if (idx - idxChoice == 1) {
                        vm.question[idxQuestion].show = true
                        vm.speakerImg = false

                        setTimeout(() => {
                            vm.question[idxQuestion].show = false
                            vm.speakerImg = true

                            // run next audio after minutes
                            /*console.log('index - ' + idx)
                            console.log('list lengt - ' + vm.list.length)*/
                            if (idx < vm.list.length) {
                                vm.onSubmitProgress(idxQuestion)

                                idxQuestion = vm.list[idx]

                                if (idxQuestion.substring(0, 1) == "p") {
                                    vm.question[idxQuestion].show = true
                                }
                                audio.src = "{{ url('admin/audio-api/audio/') }}" + '/' + vm.question[idxQuestion].audio;

                                idxChoice++
                                idx++;
                            } else {
                                vm.onSubmit()
                            }
                        }, 10000)
                    } else {
                        idxQuestion = vm.list[idx]
                        audio.src = "{{ url('admin/audio-api/audio/') }}" + '/' + vm.question[idxQuestion].audio;
                        idx++;
                    }
                }
            };
        },
        methods: {
            onSubmitProgress: function(idxQuestion) {
                let vm = this
                axios.post(
                    "{{ route('exam.store-progress') }}", {
                        idsection: vm.data.idsection,
                        idmonitoring: vm.data.idmonitoring,
                        answers: vm.answer,
                        lastquestionId: idxQuestion
                })
                .then(resp => {
                    // console.log(resp.data)
                    if (resp.data.status == "success") {
                        console.log(resp.redirect);
                        window.location.href = resp.data.redirect;
                    }
                })
                .catch(err => {
                    
                })
            },
            onSubmit: function() {
                // e.preventDefault();
                
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
                    
                })
            }
        }
    });
</script>
<script>
    
</script>
@endsection