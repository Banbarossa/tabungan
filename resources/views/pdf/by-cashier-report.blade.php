<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Report</title>
    <style>
        table, th, td {
            border-collapse: collapse;
        }
    </style>
</head>
<body>

    <table style="width: 100%; border-collapse: collapse; ">
        <tbody>
            <tr>
                <th colspan="5" style="font-size: 18px; font-weight: bold; text-align: center; padding: 10px;">
                    LAPORAN TRANSAKSI HARIAN
                </th>
            </tr>

            <tr>
                <td colspan="5" style="padding: 5px 0;"></td>
            </tr>

            <tr>
                <td style="padding: 5px;" colspan="2">
                    Cashir
                </td>
                <td style="padding: 5px;" colspan="3">
                    <strong>{{ strtoupper($user_name) }}</strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;" colspan="2">
                    Tanggal Transaksi
                </td>
                <td style="padding: 5px;" colspan="3">
                    <strong>{{ $date }}</strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;" colspan="2">
                    Total
                </td>
                <td style="padding: 5px;" colspan="3">
                    <strong>{{ format_rupiah($sum) }}</strong>
                </td>
            </tr>

            <tr>
                <td colspan="5" style="padding: 10px 0;"></td>
            </tr>

            <tr style="background-color: #acacac;">
                <th  style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>No</strong></th>
                <th  style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Nama Santri</strong></th>
                <th  style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Waktu</strong></th>
                <th  style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Jumlah</strong></th>
                <th  style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Verifikasi</strong></th>
            </tr>

            @foreach($models as $index => $tr)
                <tr>
                    <td style="width: 5%; border: 1px solid #000; padding: 5px;">
                        {{ $index + 1 }}
                    </td>
                    <td style="width: 30%; border: 1px solid #000; padding: 5px;">
                        {{$tr->student ? $tr->student->name :''}}
                    </td>
                    <td style="width: 20%; border: 1px solid #000; padding: 5px;">
                        {{ $tr->created_at }}
                    </td>
                    <td style="width: 20%; border: 1px solid #000; padding: 5px;">
                        {{format_rupiah($tr->amount)}}
                    </td>
                    <td style="width: 25%; border: 1px solid #000; padding: 5px;">
                        {{ $tr->verifiedByUser ? $tr->verifiedByUser->name :'Belum Verikasi' }}
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>


</body>
</html>
