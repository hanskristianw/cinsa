<style>
.grid-container {
  display: grid;
  grid-template-columns: 15% 15% 15% 25% 15% 15%;
  grid-column-gap:4px;
  padding-right:3px;
}
.grid-container > div{
  text-align:left;
}

.grid-main {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 20px;
  padding-top: 20px;
}

.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.boxttd{
  display: grid;
  grid-template-columns: 50% 50%;
  margin-top: 20px;
}

.grid-logo {
  display: grid;
  grid-template-columns: 25% 75%;
  grid-column-gap: 2%;
}

.grid-logo2 {
  display: grid;
  grid-template-columns: 10% 90%;
  grid-column-gap: 2%;
}

.logo {
  opacity: 1;
  max-width: 90px;
  height: auto;-moz-border-radius: 0px;
  -webkit-border-radius: 0px;
  border-radius: 0px;
}

.box2{
  display: grid;
  grid-template-columns: 50% 50%;
  margin-top: 20px;
}

@media screen and (max-width: 600px) {
  .cetak{
    display: none;
  }
}

</style>

<?php
  function format_tgl($tgl){
    if(isset($tgl)){

      $tgl_a = explode("-", $tgl);

      return $tgl_a[2].' '.return_nama_bulan_indo($tgl_a[1]).' '.$tgl_a[0];
    }else{
      return "-";
    }
  }

  function format_nilPa($nil){
    if($nil == 4){
      return "SS";
    }elseif($nil == 3){
      return "S";
    }elseif($nil == 2){
      return "TS";
    }elseif($nil == 1){
      return "STS";
    }
  }

  function format_kategori($nil){
    if($nil > 85)
      return "A";
    elseif($nil > 75)
      return "B";
    elseif($nil > 65)
      return "C";
    elseif($nil > 55)
      return "D";
    else
      return "E";
  }
?>

<div class="grid-main">

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1" id="print_area">
  <?php
    $peg = detail_pegawai($kr_id);
  ?>



  <?php
    $penilai = detail_penilai_pa($kr_id, $t_id);
    foreach ($penilai as $pen):
      //cari nilai dari penilai dan yang dinilai pada tahun itu
      $nil_pa = detail_nil_pa($pen['kr_id'], $peg['kr_id'], $t_id);
      $nil_kpi = detail_nil_kpi($pen['kr_id'], $peg['kr_id'], $t_id);

      if($nil_pa && $nil_kpi):

  ?>
      <!-- KPI -->
      <p class='judul mt-4'>INDIKATOR KINERJA UTAMA <?= strtoupper($jab['jabatan_kpi_nama']) ?></p>
      <div class="grid-logo">
        <div style="text-align:center;">
          <img src="<?= base_url('assets/img/') ?>yppi.png" class="logo">
        </div>

        <table style="font-size:14px; margin-top:30px; margin-left:10px;">
          <tr>
            <td style="vertical-align: top; text-align: left;"><b>Nama</b></td>
            <td style="vertical-align: top; text-align: left;">:</td>
            <td style="vertical-align: top; text-align: left;"><?= $peg['kr_gelar_depan'].' '.$peg['kr_nama_depan'].' '.$peg['kr_nama_belakang'].' '.$peg['kr_gelar_belakang'] ?></td>
            <td style="vertical-align: top; text-align: left; padding-left:10px;"><b>Tanggal Masuk</b></td>
            <td style="vertical-align: top; text-align: left;">:</td>
            <td style="vertical-align: top; text-align: left;"><?= format_tgl($peg['kr_mulai_tgl']) ?></td>
          </tr>
          <tr>
            <td style="vertical-align: top; text-align: left; padding-top:5px;"><b>Posisi</b></td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;">:</td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;"><?= $jab['jabatan_kpi_nama'] ?></td>
            <td style="vertical-align: top; text-align: left; padding-left:10px; padding-top:5px;"><b>Penilai</b></td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;">:</td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;"><?= $pen['kr_gelar_depan'].' '.$pen['kr_nama_depan'].' '.$pen['kr_nama_belakang'].' '.$pen['kr_gelar_belakang'] ?></td>
          </tr>

        </table>
      </div>

    <br>

    <div class="box1">
      <table class="rapot" style="font-size:14px;">
        <thead>
          <th style="width:30px;">No</th>
          <th class="pt-3 pb-3">FAKTOR PENILAIAN (KPI)</th>
          <th style="width:40px;" class="pt-3 pb-3">Target</th>
          <th style="width:40px;" class="pt-3 pb-3">Hasil</th>
          <th style="width:30px;" class="pt-3 pb-3">Skor</th>
          <th style="width:40px;" class="pt-3 pb-3">Bobot</th>
          <th style="width:40px;" class="pt-3 pb-3">Nilai</th>
        </thead>
        <tbody>
          <?php
            $temp = "";
            $no_indi = 1;
            $huruf = 65;
            $nilai_kompe = -1;
            $bobot = 0;
            $hasil_akhir_kpi = 0;
            foreach ($nil_kpi as $i) :
              $next_id = $i['kompe_kpi_id'];
          ?>

          <?php
              if($temp != $i['kompe_kpi_nama']):
                if($nilai_kompe != -1){
                  $hasil_akhir_kpi += round($nilai_kompe * ($bobot/100),2);
                  //echo '<td colspan="7">'.$nilai_kompe.'x'.$bobot.' = '.$hasil_akhir_kpi.'</td>';
                }
          ?>

          <?php $nilai_kompe = 0; ?>
            <tr>
              <td style="text-align:center;"><b><?= chr($huruf) ?></b></td>
              <td colspan="6" style="padding-left:5px;"><b><?= $i['kompe_kpi_nama'].' - '.$i['kompe_kpi_bobot'].'%' ?></b></td>
            </tr>
          <?php $huruf++;endif; ?>
            <tr>
              <td style="text-align:center;"><?= $no_indi ?></td>
              <td style="padding-left:5px;"><?= $i['indi_kpi_nama'] ?> </td>
              <td style="text-align: center;"><?= $i['indi_kpi_target'] ?></td>
              <td style="text-align: center;"> <?= $i['nilai_kpi_hasil'] ?> </td>
              <?php $skor = round(($i['nilai_kpi_hasil']/$i['indi_kpi_target'])*5,2); ?>
              <td style="text-align: center;"> <?= $skor ?> </td>
              <td style="text-align: center;"> <?= $i['indi_kpi_bobot'] ?>% </td>
              <?php
                $nilai = round($skor*($i['indi_kpi_bobot']/100),2);
                $nilai_kompe += $nilai;
              ?>
              <td style="text-align: center;"> <?= $nilai ?> </td>
            </tr>
          <?php

              if($no_indi == count($nil_kpi))
              {
                $hasil_akhir_kpi += round($nilai_kompe * ($bobot/100),2);
                //echo '<td colspan="7">'.$nilai_kompe.'x'.$bobot.' = '.$hasil_akhir_kpi.'</td>';
              }

              $temp = $i['kompe_kpi_nama'];
              $bobot = $i['kompe_kpi_bobot'];
              $no_indi++;
            endforeach;
          ?>
          <tr>
            <td colspan="7" style="padding-left:5px;padding-top:10px;padding-bottom:10px;">
              <b>Total Nilai (rentang 1-100):</b> <?= $hasil_akhir_kpi*20 ?><br>
              <b>Kategori:</b> <?= format_kategori($hasil_akhir_kpi*20) ?>
            </td>
          </tr>
        </tbody>
      </table>

    </div>

    <div class="box1">
      <div class="boxttd">
        <div style="padding-left:10%;">
          <div style="display: inline-block; text-align: center;">
            <div style="font-weight:550;font-size:13px;">TTD Penilai</div>
            <br><br><br><br><br>
            <div style="font-weight:700;font-size:13px;"><?= $pen['kr_gelar_depan'].' '.$pen['kr_nama_depan'].' '.$pen['kr_nama_belakang'].' '.$pen['kr_gelar_belakang'] ?></div>
          </div>
        </div>
        <div style="text-align: right; padding-right:10%;">
          <div style="display: inline-block; text-align: center;">
            <div style="font-weight:550;font-size:13px;">TTD Karyawan</div>
            <br><br><br><br><br>
            <div style="font-weight:700;font-size:13px;"><?= $peg['kr_gelar_depan'].' '.$peg['kr_nama_depan'].' '.$peg['kr_nama_belakang'].' '.$peg['kr_gelar_belakang'] ?></div>
          </div>
        </div>
      </div>
    </div>

    <p style="page-break-after: always;">&nbsp;</p>

      <!-- PA -->
      <p class='judul mt-4'>PERFORMANCE APPRAISAL (PA) <?= strtoupper($jab['jabatan_kpi_nama']) ?></p>

      <div class="grid-logo">
        <div style="text-align:center;">
          <img src="<?= base_url('assets/img/') ?>yppi.png" class="logo">
        </div>

        <table style="font-size:14px; margin-top:30px; margin-left:10px;">
          <tr>
            <td style="vertical-align: top; text-align: left;"><b>Nama</b></td>
            <td style="vertical-align: top; text-align: left;">:</td>
            <td style="vertical-align: top; text-align: left;"><?= $peg['kr_gelar_depan'].' '.$peg['kr_nama_depan'].' '.$peg['kr_nama_belakang'].' '.$peg['kr_gelar_belakang'] ?></td>
            <td style="vertical-align: top; text-align: left; padding-left:10px;"><b>Tanggal Masuk</b></td>
            <td style="vertical-align: top; text-align: left;">:</td>
            <td style="vertical-align: top; text-align: left;"><?= format_tgl($peg['kr_mulai_tgl']) ?></td>
          </tr>
          <tr>
            <td style="vertical-align: top; text-align: left; padding-top:5px;"><b>Posisi</b></td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;">:</td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;"><?= $jab['jabatan_kpi_nama'] ?></td>
            <td style="vertical-align: top; text-align: left; padding-left:10px; padding-top:5px;"><b>Penilai</b></td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;">:</td>
            <td style="vertical-align: top; text-align: left; padding-top:5px;"><?= $pen['kr_gelar_depan'].' '.$pen['kr_nama_depan'].' '.$pen['kr_nama_belakang'].' '.$pen['kr_gelar_belakang'] ?></td>
          </tr>

        </table>
      </div>

    <br>

    <div class="box1">
      <table class="rapot" style="font-size:14px;">
        <thead>
          <th style="width:30px;">No</th>
          <th class="pt-3 pb-3">FAKTOR PENILAIAN (PA)</th>
          <th style="width:50px;" class="pt-3 pb-3">Hasil</th>
        </thead>
        <tbody>
          <?php
            $temp = "";
            $no_indi = 1;
            $huruf = 65;
            $jumlah_indikator = 0;
            foreach ($nil_pa as $i) :
              if($temp != $i['kompe_pa_nama']):
          ?>
            <tr>
              <td style="text-align:center;"><b><?= chr($huruf) ?></b></td>
              <td colspan="2" style="padding-left:5px;"><b><?= $i['kompe_pa_nama'] ?></b></td>
            </tr>
          <?php
              $huruf++;
              endif;
          ?>
          <tr>
            <td style="text-align:center;"><?= $no_indi ?></td>
            <td style="padding-left:5px;"><?= $i['indi_pa_nama'] ?></td>
            <td style="padding-left:5px;text-align:center;"><?= format_nilPa($i['nilai_pa_hasil']) ?></td>
          </tr>
          <?php
              $jumlah_indikator += $i['nilai_pa_hasil'];
              $temp = $i['kompe_pa_nama'];
              $no_indi++;
            endforeach;
          ?>
          <tr>
            <td colspan="3" style="padding-left:5px;padding-top:10px;padding-bottom:10px;">

              <?php
                $hasil_akhir_pa = round(($jumlah_indikator/(4*($no_indi-1)))*100, 2);
              ?>

              <b>Total Nilai (rentang 1-100):</b> <?= round(($jumlah_indikator/(4*($no_indi-1)))*100, 2) ?><br>
              <b>Kategori:</b> <?= format_kategori(round(($jumlah_indikator/(4*($no_indi-1)))*100, 2)) ?>
            </td>
          </tr>
        </tbody>
      </table>

    </div>

    <div class="box1">
      <div class="boxttd">
        <div style="padding-left:10%;">
          <div style="display: inline-block; text-align: center;">
            <div style="font-weight:550;font-size:13px;">TTD Penilai</div>
            <br><br><br><br><br>
            <div style="font-weight:700;font-size:13px;"><?= $pen['kr_gelar_depan'].' '.$pen['kr_nama_depan'].' '.$pen['kr_nama_belakang'].' '.$pen['kr_gelar_belakang'] ?></div>
          </div>
        </div>
        <div style="text-align: right; padding-right:10%;">
          <div style="display: inline-block; text-align: center;">
            <div style="font-weight:550;font-size:13px;">TTD Karyawan</div>
            <br><br><br><br><br>
            <div style="font-weight:700;font-size:13px;"><?= $peg['kr_gelar_depan'].' '.$peg['kr_nama_depan'].' '.$peg['kr_nama_belakang'].' '.$peg['kr_gelar_belakang'] ?></div>
          </div>
        </div>
      </div>
    </div>

    <p style="page-break-after: always;">&nbsp;</p>

    <div class="grid-logo">
      <div style="text-align:center;">
        <img src="<?= base_url('assets/img/') ?>yppi.png" class="logo">
      </div>

      <div style="margin-top:3px; padding-right:20px;">
        <p class='judul' style="font-size:18px;">YAYASAN PENDIDIKAN DAN PENGAJARAN INDONESIA<br>PERFORMANCE APPRAISAL DAN INDIKATOR KINERJA<br><?= strtoupper($jab['jabatan_kpi_nama']) ?></p>
      </div>

    </div>

    <div class="box1">
      <table style="margin-top:30px;margin-left:10px;width: 100%;">
        <tr>
          <td style="width:40%;padding-top:3px;padding-bottom:3px;">Nama Karyawan</td>
          <td style="padding-top:3px;padding-bottom:3px;">: </td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= $peg['kr_gelar_depan'].' '.$peg['kr_nama_depan'].' '.$peg['kr_nama_belakang'].' '.$peg['kr_gelar_belakang'] ?></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">Posisi</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= ucfirst(strtolower($jab['jabatan_kpi_nama'])) ?></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">Unit</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= $peg['sk_nama'] ?></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">Mulai Bekerja di YPPI</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= format_tgl($peg['kr_mulai_tgl']) ?></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">Penilai</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= $pen['kr_gelar_depan'].' '.$pen['kr_nama_depan'].' '.$pen['kr_nama_belakang'].' '.$pen['kr_gelar_belakang'] ?></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">Tanggal Penilaian</td>
          <td>:</td>

          <?php
            $tgl = date("d/m/Y");

            $tgl_arr = explode("/", $tgl);

          ?>

          <td><?= $tgl_arr[0].' '.return_nama_bulan_indo($tgl_arr[1]).' '.$tgl_arr[2] ?></td>
        </tr>
        <tr>
          <td style="padding-top:20px;padding-bottom:3px;" colspan="3"><b>Hasil Penilaian</b></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">PA</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= $hasil_akhir_pa ?></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">KPI</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= $hasil_akhir_kpi*20 ?></td>
        </tr>
        <tr>
          <?php
            $NA_KPI = ($hasil_akhir_kpi*20) * ($per['persen_master_kpi']/100) + $hasil_akhir_pa * ($per['persen_master_pa']/100);
          ?>
          <td style="padding-top:3px;padding-bottom:3px;">Nilai Akhir</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= round($NA_KPI,2) ?></td>
        </tr>
        <tr>
          <td style="padding-top:3px;padding-bottom:3px;">Kategori</td>
          <td style="padding-top:3px;padding-bottom:3px;">:</td>
          <td style="padding-top:3px;padding-bottom:3px;"><?= format_kategori(round($NA_KPI,2)) ?></td>
        </tr>
      </table>

    </div>

    <div class="box1">
      <div class="boxttd">
        <div style="padding-left:10%;">
          <div style="display: inline-block; text-align: center;">
            <div style="font-weight:550;font-size:13px;">TTD Penilai</div>
            <br><br><br><br><br>
            <div style="font-weight:700;font-size:13px;"><?= $pen['kr_gelar_depan'].' '.$pen['kr_nama_depan'].' '.$pen['kr_nama_belakang'].' '.$pen['kr_gelar_belakang'] ?></div>
          </div>
        </div>
        <div style="text-align: right; padding-right:10%;">
          <div style="display: inline-block; text-align: center;">
            <div style="font-weight:550;font-size:13px;">TTD Karyawan</div>
            <br><br><br><br><br>
            <div style="font-weight:700;font-size:13px;"><?= $peg['kr_gelar_depan'].' '.$peg['kr_nama_depan'].' '.$peg['kr_nama_belakang'].' '.$peg['kr_gelar_belakang'] ?></div>
          </div>
        </div>
      </div>
    </div>
    <p style="page-break-after: always;">&nbsp;</p>

  <?php
      endif;
    endforeach;
  ?>

  </div>

  <div class="box1 cetak">
    <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success" value="Print">
  </div>

</div>
