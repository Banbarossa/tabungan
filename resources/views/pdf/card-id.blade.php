<!DOCTYPE html>
<html>
<head>
    <title>Kartu Tabungan</title>
    <style>
        @page { margin: 0mm; }
        body { margin: 10mm; font-family: sans-serif; }

        /* .page {
            width: 210mm;
            padding: 10mm;

            box-sizing: border-box;

        } */

        .kartu {
            width: 85.6mm;
            height: 54mm;
            margin-bottom: 5mm;
            position: relative;
            page-break-inside: avoid;
            border: solid #336666 1px;
        }

        .isi {
            position: absolute;
            top: 12mm;
            left: 18mm;
            right: 5mm;
            font-size: 10pt;
            color: #000;
            font-family: Helvetica, sans-serif;
        }

        .foto {
            position: absolute;
            top: 5mm;
            right: 5mm;
            width: 18mm;
            height: 24mm;
        }

        .qr {
            position: absolute;
            bottom: 2mm;
            right: 6mm;
            width: 17mm;
        }
        .barcode {
            position: absolute;
            bottom: 2mm;
            left: 2mm;
            transform: rotate(-90deg);
            transform-origin: left top;
        }
        .header{
            background-color: #336666;
            padding: 2px 4px;
            margin-bottom: 8px;
        }
        h2{
            margin: 0px;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 3px;
            margin-left: 2px;
            letter-spacing: 1px;
            padding: 0px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="page">
        <table>
            <tbody>
                @foreach ($siswas as $siswa)

                <tr style="page-break-inside: avoid;">
                    <td>
                        <div class="kartu">
                            <img
                                src="{{ public_path('images/card-bg-front.png') }}"
                                style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: -1;"
                            />
                            <div class="isi">
                                <div class="header">
                                    <h2>Kartu Tabungan</h2>
                                </div>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 36px;vertical-align: top">Nama</td>
                                            <td style="width: 4px ;vertical-align: top">:</td>
                                            <td><strong>{{ $siswa->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>NISN/NIS</td>
                                            <td style="width: 4px">:</td>
                                            <td>{{$siswa->no_id}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <img src="{{ $siswa->barcode }}"
                                alt="barcode"
                                class="barcode"
                            >
                            <img src="{{ $siswa->qr }}" alt="qr-code" class="qr">

                        </div>
                    </td>
                    <td>
                        <div class="kartu">
                            <img
                                src="{{ public_path('images/card-bg-behind.png') }}"
                                style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: -1;"
                            />


                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
