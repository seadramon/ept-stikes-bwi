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
                        <b>Instansi : {{ $instansi }}</b><br>                     
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
                        <th>NO</th>
                        <th>Nomor Induk</th>
                        <th>Nama</th>
                        <th>Phone</th>
                        <th>Email</th>
                        @if ($instansi != "All")
                            <th>Instansi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) > 0)
                        <?php $i = 1; ?>
                        @foreach($data as $row)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $row->nomor_induk }}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->email}}</td>
                                @if ($instansi != "All")
                                    <td>{{{$row->instansi}}}</td>
                                @endif
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ ($instansi != 'All')?6:5 }}">&nbsp;</td>
                        </tr>
                    @endif
                </tbody>
            </table> 
        </main>

    </body>
</html>