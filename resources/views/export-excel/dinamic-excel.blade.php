<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title ?? 'Judul'}}</title>
</head>

<body>
<table>
    <thead>
    <tr>
        <td colspan="{{count($headings) +1}}" ><strong style="font-size: 24px">{{$title ?? 'Judul'}}</strong></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td colspan="{{count($headings) +1}}">Waktu download : {{ $time_download }}</td>
    </tr>
    <tr>
        <td colspan="{{count($headings) +1}}" >Diunduh Oleh : {{ Auth::user()->name }}</td>
    </tr>

    </thead>
    <tbody>
    <!-- siswa  -->
    <tr>
    </tr>
    <tr>

        <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
            <strong>NO</strong>
        </td>
        @foreach($headings as $head)
            <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                <strong>{{$head}}</strong>
            </td>
        @endforeach
    </tr>
    @php
        $no = 0;
    @endphp
    @foreach($rows as $row)
        @php
            $no++;
        @endphp


        <tr>
            <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
            @foreach($headings as $head)
                <td style="border: 1px solid #000000;">{{ $row[$head] }}</td>

            @endforeach

        </tr>
    @endforeach
    <!-- End siswa  -->
    </tbody>
</table>
</body>

</html>
