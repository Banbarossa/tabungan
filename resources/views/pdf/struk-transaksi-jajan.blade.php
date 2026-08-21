<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Penarikan Tabungan Siswa</title>
    <style>
        @page {
            margin: 20px 25px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Header Styling */
        .header-table td {
            vertical-align: top;
        }

        .institution-name {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .institution-address {
            font-size: 9.5px;
            color: #111;
        }

        .badge-box {
            border: 1px dashed #000;
            padding: 6px 10px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            line-height: 1.2;
            width: 170px;
        }

        /* Divider Line */
        .dashed-line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        /* Form Details Table */
        .details-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            width: 90px;
        }

        .colon {
            width: 12px;
            text-align: center;
        }

        /* Amount Section */
        .amount-table {
            margin-top: 5px;
            margin-bottom: 5px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }

        .amount-label {
            font-weight: bold;
            font-size: 13px;
            width: 90px;
        }

        .amount-value {
            font-weight: bold;
            font-size: 14px;
        }

        /* Signature Section */
        .signature-table {
            margin-top: 15px;
            text-align: center;
        }

        .signature-space {
            height: 50px;
        }
    </style>
</head>
<body>

    <!-- Header / Kop -->
    <table class="header-table">
        <tr>
            <td style="width: 70%;">
                <div class="institution-name">{{ $header['nama_instansi'] ?? 'PESANTREN IMAM SYAFI\'I' }}</div>
                <div class="institution-address">
                    {{ $header['alamat'] ?? 'Jl. Banda Aceh - Medan Km. 16,5 Lr. Masjid Tuha Desa Reuhat Tuha, Kecamatan Suka Makmur' }}<br>
                    {{ $header['kabupaten'] ?? 'Kabupaten Aceh Besar - Aceh 23361 Telp : 0651-7556100 Fax: 0651-7556090' }}<br>
                    Email : {{ $header['email'] ?? 'ponpesimamsyafii@yahoo.co.id' }} Website : {{ $header['website'] ?? 'pis.sch.id' }}
                </div>
            </td>
            <td style="width: 30%; align: right;">
                <div class="badge-box" style="float: right;">
                    {{ $transaksi['type'] ==='setor'?'BUKTI SETORAN':'BUKTI PENARIKAN' }}
                    <br>TABUNGAN SISWA
                </div>
            </td>
        </tr>
    </table>

    <div class="dashed-line"></div>

    <!-- Informasi Penarikan & Siswa -->
    <table class="details-table">
        <tr>
            <!-- Kolom Kiri -->
            <td style="width: 55%;">
                <table>
                    <tr>
                        <td class="label">
                            {{ $transaksi['type']=== 'setor'?'Diproses Oleh':'Diterima Oleh'  }}
                        </td>
                        <td class="colon">:</td>
                        <td>{{ $transaksi['type']==='setor'?$transaksi['petugas']:$student['nama']  }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nomor Induk</td>
                        <td class="colon">:</td>
                        <td>{{ data_get($student,'nisn') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kelas</td>
                        <td class="colon">:</td>
                        <td>{{ data_get($student,'kelas') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status Siswa</td>
                        <td class="colon">:</td>
                        <td>{{ data_get($student,'status','-')}}</td>
                    </tr>
                </table>
            </td>
            <!-- Kolom Kanan -->
            <td style="width: 45%;">
                <table>
                    <tr>
                        <td class="label">Tanggal</td>
                        <td class="colon">:</td>
                        <td>{{ data_get(
                            $transaksi,'tanggal','-'
                        ) }}</td>
                    </tr>
                    <tr>
                        <td class="label">No. Bukti</td>
                        <td class="colon">:</td>
                        <td>{{ data_get($transaksi,'no_invoice') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Metode</td>
                        <td class="colon">:</td>
                        <td>{{ data_get($transaksi,'metode','-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Petugas</td>
                        <td class="colon">:</td>
                        <td>{{ data_get($transaksi,'petugas','-') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="dashed-line"></div>

    <!-- Terbilang & Keterangan -->
    <table class="details-table">
        <tr>
            <td class="label">Terbilang</td>
            <td class="colon">:</td>
            <td>
                <strong>
                    <i>{{ $transaksi['terbilang'] ?? '-' }}</i>
                </strong>
            </td>
        </tr>
        <tr>
            <td class="label">Keterangan</td>
            <td class="colon">:</td>
            <td>{{ $transaksi['type'] ==='setor' ?'Setoran tabungan santri':'Penarikan tabungan santri' }}</td>
        </tr>
    </table>

    <!-- Nominal Jumlah -->
    <table class="amount-table">
        <tr>
            <td class="amount-label">Jumlah</td>
            <td class="colon" style="font-weight: bold; font-size: 13px;">:</td>
            <td class="amount-value">
                {{-- <span style="float: left;"></span> --}}
                <span style="float: left; margin-right: 250px;">{{ data_get($transaksi,'jumlah','Rp. 0') }}</span>
            </td>
        </tr>
    </table>

    <!-- Tanda Tangan -->
    <table class="signature-table">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 25%;">Penerima,</td>
            <td style="width: 25%;">Petugas,</td>
        </tr>
        @for($i=1 ;$i<5;$i++)
        <tr class="signature-space">
            <td>&nbsp;</td>
            <td></td>
            <td></td>
        </tr>
        @endfor
        <tr>
            <td></td>
            <td>( {{ data_get($transaksi,'penerima','........................') }} )</td>
            <td>( {{ data_get($transaksi,'petugas','........................')  }} )</td>
        </tr>
    </table>

</body>
</html>
