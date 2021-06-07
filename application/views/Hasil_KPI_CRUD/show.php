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
    //$penilai = detail_penilai_pa($kr_id, $t_id);
    // echo $kr_id;
    // echo "<br>";
    // echo $t_id;
    // echo "<br>";
    // echo $penilai_kr_id;

      //cari nilai dari penilai dan yang dinilai pada tahun itu
      $nil_pa = detail_nil_pa($penilai_kr_id, $peg['kr_id'], $t_id, $jab['jabatan_kpi_id']);



      // echo $pen['kr_id'];
      // echo "<br>";
      // echo $peg['kr_id'];
      // echo "<br>";
      // echo $t_id;
      //$nil_kpi = detail_nil_kpi($pen['kr_id'], $peg['kr_id'], $t_id);

      //if($nil_pa && $nil_kpi):
      if($nil_pa):
  ?>

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
            <td style="vertical-align: top; text-align: left; padding-top:5px;"><?= $detail_penilai['kr_gelar_depan'].' '.$detail_penilai['kr_nama_depan'].' '.$detail_penilai['kr_nama_belakang'].' '.$detail_penilai['kr_gelar_belakang'] ?></td>
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
            <div style="font-weight:700;font-size:13px;"><?= $detail_penilai['kr_gelar_depan'].' '.$detail_penilai['kr_nama_depan'].' '.$detail_penilai['kr_nama_belakang'].' '.$detail_penilai['kr_gelar_belakang'] ?></div>
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
    else:
  ?>
    <h5 class="text-center text-danger">-Belum ada nilai oleh <?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'] ?>-</h5>
  <?php
      endif;
  ?>

  </div>

  <div class="box1 cetak">
    <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success" value="Print">
  </div>

</div>
