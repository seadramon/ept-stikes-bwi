<table class="content">
    <thead style="text-align: center">
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="font-weight:bold;">Room : {{ !empty($ruang)?$ruang->nama:'All' }}</th>
        </tr>
        <tr>
            <th style="font-weight:bold;">Period : {{ date('d F Y', strtotime($jadwal->start)) .' to '. date('d F Y', strtotime($jadwal->end)) }}</th>
        </tr>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Name</th>
            <th colspan="3" style="text-align: center;">Score</th>
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