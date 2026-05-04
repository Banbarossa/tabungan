<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Riwayat Transaksi</title>
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

        .separator {
            border-bottom: double solid #000;
            margin-bottom: 1rem;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .summary-wrap {
            margin: 8px 0 14px 0;
            border: 1px solid #cfcfcf;
            background-color: #fafafa;
            padding: 10px 12px;
        }

        .summary-title {
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 6px 0;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .summary-table td {
            padding: 4px 0;
        }

        .summary-label {
            color: #333;
        }

        .summary-value {
            text-align: right;
            font-weight: bold;
            width: 170px;
            white-space: nowrap;
        }

        .summary-divider td {
            border-top: 1px dashed #c0c0c0;
            padding-top: 6px;
        }
    </style>
</head>
<body>
@if(!empty($logo))
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
@endif

<table class="header-table">
    <thead>
    <tr>
        <th colspan="{{ count($headings) + 1 }}" style="width: 100%">RIWAYAT TRANSAKSI</th>
    </tr>
    <tr>
        <th colspan="{{ count($headings) + 1 }}" style="width: 100%">{{ $student?->name }}</th>
    </tr>
    <tr>
        <td></td>
    </tr>
    </thead>
</table>

@php
    $names = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
    $months = collect($filterMonths ?? [])->map(fn($m) => (int) $m)->filter(fn($m) => $m >= 1 && $m <= 12)->values()->all();
    $monthsText = empty($months) ? 'Semua Bulan' : collect($months)->map(fn($m) => $names[$m] ?? $m)->implode(', ');
@endphp

<table class="meta-table">
    <tr>
        <td style="width: 92px;">Filter Tahun</td>
        <td style="width: 10px;">:</td>
        <td>{{ $filterYear ?: '-' }}</td>
        <td style="width: 40px;"></td>
        <td style="width: 90px;">Diunduh Oleh</td>
        <td style="width: 10px;">:</td>
        <td>{{ $downloadedBy ?? '-' }}</td>
    </tr>
    <tr>
        <td>Filter Bulan</td>
        <td>:</td>
        <td>{{ $monthsText }}</td>
        <td></td>
        <td>Waktu Unduh</td>
        <td>:</td>
        <td>{{ $downloadedAt ?? '-' }}</td>
    </tr>
</table>

<div class="summary-wrap">
    <div class="summary-title">Ringkasan (Semua Data)</div>
    <table class="summary-table">
        <tr>
            <td class="summary-label">Total Setoran</td>
            <td class="summary-value">{{ $overall['formatted']['setor'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="summary-label">Total Penarikan</td>
            <td class="summary-value">{{ $overall['formatted']['tarik'] ?? '-' }}</td>
        </tr>
        <tr class="summary-divider">
            <td class="summary-label">Selisih (Setoran - Penarikan)</td>
            <td class="summary-value">{{ $overall['formatted']['selisih'] ?? '-' }}</td>
        </tr>
    </table>
</div>

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
    @foreach($rows as $index => $tr)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            @foreach($headings as $head)
                <td>{{ $tr[$head] ?? '' }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_text(20, 570, "Page: {PAGE_NUM} of {PAGE_COUNT}", 'Helvetica', 8, array(0,0,0));
    }
</script>
</body>
</html>
