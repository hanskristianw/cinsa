<style>
.grid-container {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 120px;
  padding-top: 50px;
}

.grid-logo {
  display: grid;
  grid-template-columns: 25% 75%;
  grid-column-gap: 0%;
}

.grid-logo2 {
  display: grid;
  grid-template-columns: 10% 90%;
  grid-column-gap: 2%;
}

.boxttd{
  display: grid;
  grid-template-columns: 50% 50%;
  margin-top: 20px;
}

.logo {
  opacity: 1;
  max-width: 90px;
  height: auto;-moz-border-radius: 0px;
  -webkit-border-radius: 0px;
  border-radius: 0px;
}

.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.box2{
  /*align-self:start;*/
  grid-template-columns: 50% 50%;
}
</style>

<?php
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

<div class="grid-container">

  <div class="box1">

    <div id="print_area">

      <div class="grid-logo">
        <div style="text-align:center;">
          <img src="<?= base_url('assets/img/') ?>yppi.png" class="logo">
        </div>

        <div style="margin-top:3px; padding-right:20px;">
          <p class='judul' style="font-size:18px;">YAYASAN PENDIDIKAN DAN PENGAJARAN INDONESIA<br>PERFORMANCE APPRAISAL DAN INDIKATOR KINERJA<br><?= strtoupper($jabatan_kpi['jabatan_kpi_nama']) ?></p>
        </div>

      </div>

              <?php $total=0; $total_penilai=0; foreach ($penilai_all as $p): ?>
                <?php
                  $nil_pa = detail_nil_pa_akhir($p['kr_id'], $dinilai_all['kr_id'], $t_id);
                  if($nil_pa['hasil']){
                    $total += $nil_pa['hasil'];
                    $total_penilai ++;
                  }
                ?>
              <?php endforeach; ?>
              <!-- rata-rata -->
              <?php

                if($total != 0){
                  $hasil_akhir_pa = $total/$total_penilai;
                  $hasil_akhir_pa_huruf = format_kategori($total/$total_penilai);
                }
              ?>

      <div class="box1">
        <table style="margin-top:30px;margin-left:10px;width: 100%;">
          <tr>
            <td style="width:40%;padding-top:3px;padding-bottom:3px;">Nama Karyawan</td>
            <td style="padding-top:3px;padding-bottom:3px;">: </td>
            <td style="padding-top:3px;padding-bottom:3px;"><?= $dinilai_all['kr_gelar_depan'].' '.$dinilai_all['kr_nama_depan'].' '.$dinilai_all['kr_nama_belakang'].' '.$dinilai_all['kr_gelar_belakang'] ?></td>
          </tr>
          <tr>
            <td style="padding-top:3px;padding-bottom:3px;">Hasil</td>
            <td style="padding-top:3px;padding-bottom:3px;">:</td>
            <td style="padding-top:3px;padding-bottom:3px;"><?= $dinilai_all['sk_nama'] ?></td>
          </tr>
          <tr>
            <td style="padding-top:3px;padding-bottom:3px;">Posisi</td>
            <td style="padding-top:3px;padding-bottom:3px;">:</td>
            <td style="padding-top:3px;padding-bottom:3px;"><?= $jabatan_kpi['jabatan_kpi_nama'] ?></td>
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
            <td style="padding-top:20px;padding-bottom:3px;" colspan="3"><b>Rata-rata dari <?= count($penilai_all) ?> penilai</b></td>
          </tr>
          <tr>
            <td style="padding-top:3px;padding-bottom:3px;">PA</td>
            <td style="padding-top:3px;padding-bottom:3px;">:</td>
            <td style="padding-top:3px;padding-bottom:3px;"><?= $hasil_akhir_pa ?></td>
          </tr>
          <tr>
            <td style="padding-top:3px;padding-bottom:3px;">Kategori</td>
            <td style="padding-top:3px;padding-bottom:3px;">:</td>
            <td style="padding-top:3px;padding-bottom:3px;"><?= $hasil_akhir_pa_huruf ?></td>
          </tr>
        </table>

      </div>

      <div class="box1" style="margin-top:100px;">
        <div class="boxttd">
          <div style="padding-left:10%;">
            <div style="display: inline-block; text-align: center;">
              <div style="font-weight:550;font-size:13px;">TTD Pimpinan</div>
              <br><br><br><br><br>
              <div style="font-weight:700;font-size:13px;">..........................................</div>
            </div>
          </div>
          <div style="text-align: right; padding-right:10%;">
            <div style="display: inline-block; text-align: center;">
              <div style="font-weight:550;font-size:13px;">TTD Karyawan</div>
              <br><br><br><br><br>
              <div style="font-weight:700;font-size:13px;"><?= $dinilai_all['kr_gelar_depan'].' '.$dinilai_all['kr_nama_depan'].' '.$dinilai_all['kr_nama_belakang'].' '.$dinilai_all['kr_gelar_belakang'] ?></div>
            </div>
          </div>
        </div>
      </div>
      <p style="page-break-after: always;">&nbsp;</p>
    </div>

    <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success mt-2" value="Print">

  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {


    $("#sembunyi").click(function () {
      if ($(this).prop('checked')==true){
        var count = 1;
        $(".penilai").each(function(){
          //alert('hai');
         $(this).html("Penilai "+ count);
         count++;
        });

      }else{
        $(".penilai").each(function(){
         $(this).html($(this).attr('class').split('#')[1]);
        });
      }
    });

    $("#sembunyi2").click(function () {
      if ($(this).prop('checked')==true){
        $('.huruf_angka').css({
            display: 'none'
        });
        $(".huruf").css("display","");
      }else{
        $(".huruf_angka").css("display","");
        $('.huruf').css({
            display: 'none'
        });
      }
    });


  });
</script>
