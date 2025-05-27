<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Report</title>

</head>
<body>
    <table>
        <tbody>
            <tr>
                <th colspan="4" style="font-size: 18px;font-weight: 800">LAPORAN TRANSAKSI HARIAN</th>
            </tr>
            <tr></tr>
            <tr>
                <td colspan="4">
                    Diunduh Oleh {{ $user_name }}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Tanggal Transaksi {{ $date }}
                </td>
            </tr>
            <tr></tr>
            @foreach($models as $total)
                <tr style="background-color: #ccf5dc">
                    <th colspan="2" style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>{{ strToUpper($total['user_name']) }}</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Waktu</strong></th>
                    <th style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px;text-align: end" align="end">
                        <strong>
                            {{ format_rupiah($total['total_amount']) }}
                        </strong>
                    </th>
                </tr>
                @foreach($total['transactions'] as $index=>$tr)
                    <tr>
                        <td style="width: 35px; border: 1px solid #000000;">{{ $index + 1 }}</td>
                        <td style="width: 300px; border: 1px solid #000000;">{{$tr->student ? $tr->student->name :''}}</td>
                        <td style="width: 70px; border: 1px solid #000000;">{{ Carbon\Carbon::parse($tr->created_at)->format('H:i')}}</td>
                        <td align="end" style="width: 170px;border: 1px solid #000000;ext-align: end">{{format_rupiah($tr->amount)}}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
