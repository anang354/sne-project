<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip THR  {{ $name.'-'.$tahun }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            position: relative;
        }

        /* Watermark */
        #watermark {
            position: fixed;
            top: 35%;
            left: 5%;
            transform: rotate(-30deg);
            transform-origin: 50% 50%;
            opacity: 0.1;
            font-size: 80px;
            font-weight: bold;
            color: #b1b1b1;
            z-index: -1000;
            width: 100%;
            text-align: center;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
        }

        .company-info {
            text-align: center;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .company-address {
            font-size: 10px;
            margin: 5px 0;
        }

        .company-web {
            font-size: 10px;
            color: blue;
            text-decoration: underline;
        }

        /* Title */
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        /* Info Section */
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .info-table td {
            vertical-align: top;
            width: 15%;
        }

        .info-table td.separator {
            width: 2%;
        }

        .info-table td.value {
            width: 33%;
        }

        /* Details Section */
        .details-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 5px 0;
        }

        .line-total {
            border-top: 2px solid #000;
            margin-top: 5px;
        }

        .total-row td {
            font-size: 16px;
            font-weight: bold;
            padding-top: 15px;
        }

        .terbilang {
            font-style: italic;
            margin-top: 10px;
        }
      .signature {
        margin-top: 30px;
      }
      .signature p {
        margin: 0;
      }
      .qr-code {
        margin-top: 10px;
      }
      .qr-code img{
        max-width: 100px;
      }
      .message {
        width: 100%;
        text-align: center;
        margin-top: 30px;
      }
      .message p {
        font-size: 16px;
        font-weight: bold;
        color: #1dac58;
      }
    </style>
</head>
<body>

    <div id="watermark">PRIVATE & CONFIDENTIAL</div>

    <table class="header-table">
        <tr>
            <td width="100">
                <td><img src="{{$image}}"/></td>
            </td>
            <td class="company-info">
                <div class="company-name">PT. DUNIA SOLAR INDONESIA</div>
                <div class="company-address">Jl. Kerapu No. 12, Kel. Tanjung Sengkuang, Kec. Batu Ampar, Kota Batam</div>
                <div class="company-web">www.duniasolarindonesia.com</div>
            </td>
            <td width="100"></td>
        </tr>
    </table>

    <div class="title">SLIP {{ $titleSlip }}</div>

    <table class="info-table">
        <tr>
            <td>Nama</td>
            <td class="separator">:</td>
            <td class="value">{{ $name }}</td>
            
            <td>Tanggal Bergabung</td>
            <td class="separator">:</td>
            <td class="value">{{ $join_date }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td class="separator">:</td>
            <td class="value">{{ $nip }}</td>
            
            <td>Masa Kerja</td>
            <td class="separator">:</td>
            <td class="value">{{ $masa_kerja }} Bulan</td>
        </tr>
        <tr>
            <td>Jabatan/Posisi</td>
            <td class="separator">:</td>
            <td class="value">{{ $position }}</td>
            
            <td>Status</td>
            <td class="separator">:</td>
            <td class="value">Karyawan Kontrak</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td class="separator">:</td>
            <td class="value">{{ $departemen }}</td>
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div class="details-title">Rincian Pembayaran THR</div>

    <table class="details-table">
        <tr>
            <td width="20%">Tunjangan Hari Raya / THR</td>
            <td width="2%">:</td>
            <td>Rp. {{ number_format($thp, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>PPh21</td>
            <td>:</td>
            <td>Rp. {{ number_format($pph21, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="3"><div class="line-total"></div></td>
        </tr>
        <tr class="total-row">
            <td>Take Home Pay</td>
            <td>:</td>
            <td>Rp. {{ number_format($thp - $pph21, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="terbilang">
        *Terbilang: <i>{{ $terbilang }}</i>
    </div>
    <div class="signature">
            <p>Batam, {{ date('d F Y') }}</p>
            <p><b>HRD</b></p>
            <div class="qr-code">
            <img src="data:image/svg+xml;base64,{{$qrCode}}"/>
            </div>
            <p><b>GIANA LESTARI</b></p>
        </div>
    <div class="message">
        <p>{{ $message }}</p>
    </div>
</body>
</html>