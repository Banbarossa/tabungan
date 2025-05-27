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
                <td colspan="2">
                    Cashir
                </td>
                <td colspan="5">
                    <strong>{{ $user_name }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Tanggal Transaksi
                </td>
                <td colspan="3">
                    <strong>{{ $date }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Total
                </td>
                <td colspan="3">
                    <strong>{{ format_rupiah($sum) }}</strong>
                </td>
            </tr>
            <tr></tr>

                <tr style="background-color: #acacac">
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>No</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Nama Santri</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Waktu</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Jumlah</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Verifikasi</strong></th>
                </tr>
                @foreach($models as $index=>$tr)
                <tr>
                    <td style="width: 35px; border: 1px solid #000000;">{{ $index + 1 }}</td>
                    <td style="width: 250px; border: 1px solid #000000;">{{$tr->student ? $tr->student->name :''}}</td>
                    <td style="width: 200px; border: 1px solid #000000;">{{ $tr->created_at }}</td>
                    <td align="end" style="width: 100px;border: 1px solid #000000;ext-align: end">{{format_rupiah($tr->amount)}}</td>
                    <td align="end" style="width: 170px;border: 1px solid #000000;ext-align: end">{{ $tr->verifiedByUser ? $tr->verifiedByUser->name :'Belum Verikasi' }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</body>
</html>
