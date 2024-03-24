<html>
    <head>
        <style>
            body {
                font-size: 11px;
                font-family: arial;
            }

            .tengah {
                text-align: center;
                font-weight: bold;
            }

            table.content {
                table-layout: auto; 
                width:100%;
                border-collapse: collapse;
            }

            .content table, .content th, .content td {
                border: 1px solid;
                padding-left: 5px: 
            }
            @page { margin:50px 25px 60px 25px; }
            header { margin-bottom: 10px; }
            /* footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; } */
            hr.new1 {
              border-top: 1px dotted black;
            }
        </style>
    </head>

    <body>
        <header>

            <table width="100%">
                <tr>
                    <td style="text-align:left;" width="75%" valign="top">
                        <b>Room : {{ !empty($ruang)?$ruang->nama:'All' }}</b><br>                     
                    </td>
                    <td width="25%" style="font-size:10px">
                        &nbsp;
                    </td>
                </tr>  
                <tr>
                    <td style="text-align:left;" width="75%" valign="top">
                        <b>Period : {{ date('d F Y', strtotime($jadwal->start)) .' to '. date('d F Y', strtotime($jadwal->end)) }}</b><br>                     
                    </td>
                    <td width="25%" style="font-size:10px">
                        &nbsp;
                    </td>
                </tr>    
            </table>
        </header>

        <main>
            <table class="content">
                <thead style="text-align: center">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Name</th>
                        <th colspan="3">Score</th>
                        <th rowspan="2">Total Score</th>
                        <th rowspan="2">Status</th>
                    </tr>
                    <tr>
                        <th>Section 1</th>
                        <th>Section 2</th>
                        <th>Section 3</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) > 0)
                        <?php $i = 1; ?>
                        @foreach($data as $row)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>{{$row->section_1}}</td>
                                <td>{{$row->section_2}}</td>
                                <td>{{$row->section_3}}</td>
                                <td>{{$row->total}}</td>
                                <td>{{($row->status == '1')?'Active':'Inactive'}}</td>
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">Data is Empty</td>
                        </tr>
                    @endif
                </tbody>
            </table> 
        </main>

    </body>
</html>