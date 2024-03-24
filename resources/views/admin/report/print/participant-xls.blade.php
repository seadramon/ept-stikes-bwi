<table class="content">
    <thead style="text-align: center">
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="font-weight:bold;">Instansi : {{ $instansi }}</th>
        </tr>
        <tr>
            <th>No</th>
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