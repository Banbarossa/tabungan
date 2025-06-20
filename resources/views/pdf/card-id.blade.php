<!DOCTYPE html>
<html>
<head>
    <title>Kartu Tabungan</title>
    <style>
        @page { margin: 0mm; }
        body {
            margin: 10mm;
            font-family: 'Courier', monospace;
        }

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

        .isi-depan {
            position: absolute;
            top: 22mm;
            left: 8mm;
            right: 5mm;
            font-size: 10pt;
            color: #484747;
            font-family:'monospace', Courier;
        }
        .isi-belakang {
            position: absolute;
            top: 16mm;
            left: 16mm;
            right: 5mm;
            font-size: 10pt;
            color: #484747;
            font-family:'monospace', Courier;
        }

        .foto {
            position: absolute;
            top: 5mm;
            left: 12mm;
            width: 18mm;
            height: 24mm;
        }

        .qr {
            position: absolute;
            bottom: 4mm;
            left: 18mm;
            width: 24mm;
        }
        .barcode {
            position: absolute;
            top: 16mm;
            left: 18mm;
            /* transform: rotate(-90deg);
            transform-origin: left top; */
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
                            <div class="isi-depan">
                                {{-- <div class="header">
                                    <h2>Kartu Tabungan</h2>
                                </div> --}}
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 18px;letter-spacing: 1px">
                                                <strong>{{$siswa->no_id}}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 18px;">
                                                <strong>{{ $siswa->name }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            {{-- <img src="{{ $siswa->qr }}" alt="qr-code" class="qr"> --}}

                        </div>
                    </td>
                    <td>
                        <div class="kartu">
                            <img
                                src="{{ public_path('images/card-bg-behind.png') }}"
                                style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: -1;"
                            />
                            <div class="isi-belakang">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="{{ $siswa->barcode }}"
                                                    alt="barcode"
                                                >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ $siswa->qr }}" alt="qr-code" >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            {{-- <div class="qr" style="padding: 3px 3px;background-color: #fff">
                                <img src="{{ $siswa->qr }}" alt="qr-code" >
                            </div> --}}

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
