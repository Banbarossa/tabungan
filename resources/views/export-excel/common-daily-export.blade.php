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
                <th colspan="8" style="font-size: 18px;font-weight: 800">LAPORAN TRANSAKSI HARIAN</th>
            </tr>
            <tr></tr>
            <tr>
                <td colspan="2">
                    Tanggal Transaksi
                </td>
                <td colspan="3">
                    <strong>{{ $date }}</strong>
                </td>
            </tr>
            <tr></tr>

                <tr style="background-color: #acacac">
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>No</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Nama Santri</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Tanggal</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Cashier</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Setor</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Tarik</strong></th>
                    <th  style="border: 1px solid #000000; background-color: #d9ecd0;font-size: 12px"><strong>Saldo</strong></th>
                </tr>
                @foreach($models as $index=>$tr)
                <tr>
                    <td style="width: 35px; border: 1px solid #000000;">{{ $index + 1 }}</td>
                    <td style="width: 250px; border: 1px solid #000000;">{{$tr->student ? $tr->student->name :''}}</td>
                    <td style=" border: 1px solid #000000;">{{ $tr->created_at }}</td>
                    <td style=" border: 1px solid #000000;">{{ $tr->handledbyUser ? ucWords($tr->handledbyUser->name) :'' }}</td>
                    <td style=" border: 1px solid #000000;">
                        @if ($tr->type == 'setor')
                        {{ format_rupiah($tr->amount) }}
                        @else
                        -
                        @endif
                    </td>
                    <td style=" border: 1px solid #000000;">
                        @if ($tr->type == 'tarik')
                        {{ format_rupiah($tr->amount) }}
                        @else
                        -
                        @endif
                    </td>
                    <td style=" border: 1px solid #000000;">
                        {{ format_rupiah($tr->latest_saldo)}}
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</body>
</html>
