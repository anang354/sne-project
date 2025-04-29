<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SLIP GAJI {{$name}} Periode {{ucfirst($bulan)}} {{$tahun}}</title>
  <style>
    .watermark {
      position: absolute;
      top: 20%;
      right: 0;
      transform: rotate(-45deg); 
      z-index: -1;
    }
    .watermark h1 {
      font-family: 'Courier New', Courier, monospace;
      font-size: 60pt;
      color: #eee;
    }
    .slip-box {
		max-width: 800px;
		margin: auto;
		padding: 30px;
		font-size: 12px;
		line-height: 24px;
		font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		color: #333;
	}
      h1, h2, h3, h4, h5, h6 {
        margin: 0;
      }
	.slip-box table {
		width: 100%;
		line-height: inherit;
		text-align: left;
		border-collapse: collapse;
	}
      .slip-box table tr.top td:last-child{
        text-align: right;
      }
      .slip-box table tr.top td h2 {
        font-size: 14pt;
        color: #333;
        padding: none;
        margin:0;
        text-transform: uppercase;
        font-weight: 600;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
      }
      .slip-box table tr.top td p {
        margin: 0;
        font-size: 10pt;
        line-height: 15px;
      }
      .slip-box table tr td h2.title {
        font-size: 12pt;
        color: #333;
        padding: none;
        text-transform: uppercase;
        text-align: center;
        letter-spacing: 1px;
        text-decoration: underline;
      }
      .slip-box table tr.heading td{
        background: #f1f1f1;
        border-bottom: 2px solid #333;
        border-top: 2px solid #333;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 3px 0;
        vertical-align: middle;
      }
      table tr.items td:nth-child(3){
        text-align: right;
        padding-right: 25px;
      }
      table tr.items td:nth-child(6) {
        text-align: right;
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
  </style>
</head>
<body>
  <div class="watermark">
    <h1>PRIVATE & CONFIDENTIAL</h1>
  </div>
  <div class="slip-box">
      <table>
          <tr>
            <td colspan="2">
              <table>
                <tr class="top">
                  <td><img src="{{$image}}"/></td>
                  <td>
                    <h2>PT Dunia Solar Indonesia</h2>
                    <p>Jl. Kerapu No.12, Tj. Sengkuang,<br />
                      Kec. Batu Ampar, Kota Batam</p>
                      <a href="https://duniasolarindonesia.com">www.duniasolarindonesia.com</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="padding: 40px 0;">
              <h2 class="title">SLIP GAJI KARYAWAN</h2>
            </td>
          </tr>

          <!-- INFORMASI KARYAWAN -->
          <tr class="information">
            <td>
              <table>
                  <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{$name}}</td>
                  </tr>
                  <tr>
                    <td>Departemen</td>
                    <td>:</td>
                    <td>{{$department}}</td>
                  </tr>
                  <tr>
                    <td>Posisi</td>
                    <td>:</td>
                    <td>{{$position}}</td>
                  </tr>
              </table>
            </td>
            <td>
                <table>
                  <tr>
                    <td>Bulan</td>
                    <td>:</td>
                    <td>{{ucfirst($bulan)}}</td>
                  </tr>
                  <tr>
                    <td>Tahun</td>
                    <td>:</td>
                    <td>{{$tahun}}</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
            </td>
          </tr>

          <!-- GAJI KARYAWAN -->         
          <tr>
              <td colspan="2">
				<table>
					<tr class="heading">
						<td>RINCIAN GAJI</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>POTONGAN</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr class="items">
						<td>Gaji Pokok</td>
						<td>:</td>
						<td>{{number_format($gajiPokok, 0, '.', ',')}}</td>
						<td>Potongan Hari &nbsp; &nbsp; &nbsp; {{$potonganHari ? $potonganHari : '-'}} hari</td>
						<td>:</td>
						<td>{{$potonganAbsensi ? number_format($potonganAbsensi, 0, '.', ',') : '-'}}</td>
					</tr>
					<tr class="items">
						<td>Tunj. Jabatan</td>
						<td>:</td>
						<td>{{$tunjJabatan ? number_format($tunjJabatan, 0, '.', ',') : '-'}}</td>
						<td>BPJS-TK</td>
						<td>:</td>
						<td>{{$bpjsTk ? number_format($bpjsTk, 0, '.', ',') : '-'}}</td>
					</tr>
					<tr class="items">
						<td>Tunj. Bahasa</td>
						<td>:</td>
						<td>{{$tunjBahasa ? number_format($tunjBahasa, 0, '.', ',') : '-'}}</td>
						<td>BPJS-KS</td>
						<td>:</td>
						<td>{{$bpjsKs ? number_format($bpjsKs, 0, '.', ',') : '-'}}</td>
					</tr>
					<tr class="items">
						<td>Tunj. Keahlian</td>
						<td>:</td>
						<td>{{$tunjKerajinan ? number_format($tunjKerajinan, 0, '.', ',') : '-'}}</td>
						<td>PPH21</td>
						<td>:</td>
						<td>{{$pph21 ? number_format($pph21, 0, '.', ',') : '-'}}</td>
					</tr>
					<tr class="items">
						<td>Tunj. Lainnya</td>
						<td>:</td>
						<td>{{$tunjLainnya ? number_format($tunjLainnya, 0, '.', ',') : '-'}}</td>
						<td rowspan="2" style="line-height: 1.2em; vertical-align: top;">Denda Telat Masuk/Izin Keluar/<br/>Pulang Cepat</td>
						<td>:</td>
						<td>{{$denda ? number_format($denda, 0, '.', ',') : '-'}}</td>
					</tr>
					<tr class="items">
						<td>Lembur</td>
						<td>:</td>
						<td>{{$lembur ? number_format($lembur, 0, '.', ',') : '-'}}</td>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr class="items">
						<td>Uang Makan Lembur</td>
						<td>:</td>
						<td>{{$uangMakan ? number_format($uangMakan, 0, '.', ',') : '-'}}</td>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr class="items">
						<td>Rapel</td>
						<td>:</td>
						<td>{{$rapel ? number_format($rapel, 0, '.', ',') : '-'}}</td>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr class="heading">
						<td colspan="2"><h4>TOTAL GAJI</h4></td>
						<td style="text-align: right; padding-right: 20px;"><h4>{{$totalGaji ? number_format($totalGaji, 0, '.', ',') : '-'}}</h4></td>
						<td colspan="2"><h4>TOTAL POTONGAN</h4></td>
						<td style="text-align: right;"><h4>{{$totalPotongan ? number_format($totalPotongan, 0, '.', ',') : '-'}}</h4></td>
					</tr>
					<tr><td colspan="6">&nbsp;</td></tr>
					<tr class="heading">
						<td colspan="3"><h2>GAJI BERSIH</h2></td>
						<td colspan="3"><h2>{{$gajiBersih ? number_format($gajiBersih, 0, '.', ',') : '-'}}</h2></td>
					</tr>
					<tr class="items">
						<td colspan="6">
						<i>Terbilang: {{$terbilang}}</i>
						</td>
					</tr>
				</table>
			  </td>
          </tr>
      </table>

      <div class="signature">
        <p>Batam, {{$tanggal}}</p>
        <p><b>HRD</b></p>
        <div class="qr-code">
          <img src="data:image/svg+xml;base64,{{$qrCode}}"/>
        </div>
        <p><b>SUGENG</b></p>
      </div>
  </div>
</body>
</html>
