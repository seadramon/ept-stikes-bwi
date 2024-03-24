<table class="content">
    <thead style="text-align: center">
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="font-weight:bold;">Room : {{ !empty($ruang)?$ruang->nama:'All' }}</th>
        </tr>
        <tr>
            <th style="font-weight:bold;">Pengawas : {{ !empty($pengawas)?$pengawas->name:'All' }}</th>
        </tr>
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
                <td colspan="5">Data is Empty</td>
            </tr>
        @endif
    </tbody>
</table>