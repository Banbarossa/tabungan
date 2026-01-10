<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Report</title>
    <html>
    <head>
        <meta charset="utf-8">
        <style>
            @page {
                margin: 50px 30px;
            }

            body {
                font-family: Helvetica, sans-serif;
                font-size: 11px;
            }

            .header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }

            .header-table th {
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                padding: 0px;
                /*border-bottom: 1px solid #000;*/
            }

            .content-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 11px;
            }

            .content-table th,
            .content-table td {
                padding: 5px;
            }

            .content-table th {
                text-align: left;
                font-weight: normal;
                background-color: #f0f0f0;
                border-top: 1px dashed #302e2e;
                border-bottom: 1px dashed #302e2e;
            }

            .content-table td {
                text-align: left;
            }

            .content-table tfoot th {
                text-align: right;
                font-weight: bold;
            }

            .pagenum:before {
                content: counter(page);
            }

            .separator {
                border-bottom: double solid #000;
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body>
    <table class="logo">
        <tr>
            <td style="width:40px; vertical-align:top; padding-right:10px;">
                <img src="{{ $logo }}" style="width:50px; height:50px; object-fit:contain;">
            </td>
            <td style="vertical-align:middle; line-height:1;">
                <div style="font-size:14px; font-weight:bold; letter-spacing:0.5px; margin:0;">
                    Pesantren Imam Syafi'i
                </div>
                <div style="font-size:11px; margin:2px 0; letter-spacing:0.3px;">
                    Jl. Banda Aceh-Medan KM 16.5 Lr. Masjid Tuha Desa Reuhat Tuha., Kecamatan Suka makmur
                </div>
                <div style="font-size:11px; margin:2px 0; letter-spacing:0.3px;">
                    Kabupaten Aceh Besar -Aceh 23361 Telp:0651-7556100 Fax 0651-77556090
                </div>
                <div style="font-size:11px; margin:2px 0; letter-spacing:0.3px;">
                    email:ponpesimamsyafii@yahoo.co.id website:pis.sch.id
                </div>
            </td>
        </tr>
    </table>
    <div class="separator"></div>

    <table class="header-table">
        <thead>
        <tr>
            <th colspan="9" style="width: 100%">LAPORAN TRANSAKSI HARIAN</th>
        </tr>
        <tr>
            <th colspan="9" style="width: 100%">TANGGAL : {{$tanggal}}</th>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td style="width: 6rem"> Diunduh Oleh</td>
            <td style="width: 1rem">:</td>
            <td>{{ Auth::user()->name }}</td>
        </tr>
        <tr>
            <td> Petugas</td>
            <td>:</td>
            <td>{{$petugas}}</td>
        </tr>

        </thead>
    </table>

    <table class="content-table">
        <thead>
        <tr>
            <th>No</th>
            @foreach($headings as $head)
                <th>{{ $head }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($data as $index => $tr)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                @foreach($headings as $head)
                    <td>{{ $tr[$head] }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="{{ count($headings) - 3 }}"></td>
            <td colspan="2" style="border-top: dashed gray; text-align:left">Grand Total</td>
            <td style="text-align: right; border-top: dashed gray ">{{ format_rupiah($totalDebet) }}</td>
            <td style="text-align: right; border-top: dashed gray">{{format_rupiah($totalKredit)  }}</td>
        </tr>
        <tr>
            <td colspan="{{ count($headings) - 3 }}"></td>
            <td colspan="2" style="text-align: left;border-bottom: dashed gray">Setoran - Penarikan</td>
            <td colspan="2" style="text-align: right;border-bottom: dashed gray">{{ format_rupiah($selisih) }}</td>
        </tr>
        </tfoot>
    </table>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_text(20, 570, "Page: {PAGE_NUM} of {PAGE_COUNT}", 'Helvetica', 8, array(0,0,0));
              $date = date("d-m-Y H:i:s");
            $pdf->page_text(700, 570, "Downloaded: {$date}", "helvetica", 8, [0,0,0]);
        }
    </script>
    </body>
    </html>
