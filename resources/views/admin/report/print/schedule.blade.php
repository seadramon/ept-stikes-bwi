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
                        <b>Pengawas : {{ !empty($pengawas)?$pengawas->name:'All' }}</b><br>                     
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
                        <th>No</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Room</th>
                        <th>Pengawas</th>
                        <th>Number of Participants</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) > 0)
                        <?php $i = 1; ?>
                        @foreach($data as $row)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->start }}</td>
                                <td>{{$row->end}}</td>
                                <td>{{$row->ruang->nama}}</td>
                                <td>{{$row->pengawas->name}}</td>
                                <td>{{$row->monitoring->count()}}</td>
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">Data is Empty</td>
                        </tr>
                    @endif
                </tbody>
            </table> 
        </main>

    </body>
</html>