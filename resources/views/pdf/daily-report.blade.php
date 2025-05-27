<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Report</title>
</head>
<body>

    <table style="width: 100%; border-collapse: collapse; ">
        <tbody>
            <tr>
                <th colspan="4" style="font-size: 18px; font-weight: bold; text-align: center; padding: 10px;">
                    LAPORAN TRANSAKSI HARIAN
                </th>
            </tr>
            <tr>
                <td colspan="4" style="padding: 5px 0;"></td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 5px;">
                    Diunduh Oleh: {{ $user_name }}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 5px;">
                    Tanggal Transaksi: {{ $date }}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 10px 0;"></td>
            </tr>

            @foreach($models as $total)
                <tr style="background-color: #d9ecd0;">
                    <th colspan="2" style="border: 1px solid #000; padding: 5px; text-align: left;">
                        {{ strtoupper($total['user_name']) }}
                    </th>
                    <th style="border: 1px solid #000; padding: 5px; text-align: left;">Waktu</th>
                    <th style="border: 1px solid #000; padding: 5px; text-align: right;">
                        {{ format_rupiah($total['total_amount']) }}
                    </th>
                </tr>

                @foreach($total['transactions'] as $index => $tr)
                    <tr>
                        <td style="width: 5%; border: 1px solid #000; padding: 5px;">{{ $index + 1 }}</td>
                        <td style="width: 55%; border: 1px solid #000; padding: 5px;">
                            {{ $tr->student ? $tr->student->name : '' }}
                        </td>
                        <td style="width: 15%; border: 1px solid #000; padding: 5px;">
                            {{ \Carbon\Carbon::parse($tr->created_at)->format('H:i') }}
                        </td>
                        <td style="width: 25%; border: 1px solid #000; padding: 5px; text-align: right;">
                            {{ format_rupiah($tr->amount) }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>


</body>
</html>
