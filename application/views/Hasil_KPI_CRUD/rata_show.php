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
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">

      <div class="grid-logo" style="margin-bottom:20px;">
        <div style="text-align:right;">
          <img src="<?= base_url('assets/img/') ?>yppi.png" class="logo">
        </div>

        <p class='judul mt-4'>PERFORMANCE APPRAISAL (PA) <br><?= $nama ?><br>(<?= $jabatan_kpi['jabatan_kpi_nama'] ?>)</p>
      </div>

      <table class="rapot mt-4">
        <thead>
          <th style="width:200px;padding-top:15px;padding-bottom:15px;">Karyawan</th>
          <?php $penilai_no = 1; foreach ($penilai_all as $p): ?>
            <th>Penilai <?= $penilai_no ?></th>
          <?php $penilai_no++; endforeach; ?>
          <th style="width:70px;">Rata-rata</th>
        </thead>
        <tbody>
          <tr>
            <td style="padding-left:3px;"><?= $dinilai_all['kr_nama_depan'].' '.$dinilai_all['kr_nama_belakang'] ?></td>
            <?php $total=0; $total_penilai=0; foreach ($penilai_all as $p): ?>
            <td style="text-align: center;">
              <?php
                $nil_pa = detail_nil_pa_akhir($p['kr_id'], $dinilai_all['kr_id'], $t_id);
                if($nil_pa['hasil']){
                  $total += $nil_pa['hasil'];
                  $total_penilai ++;
                  echo '<div class="huruf_angka">'.$nil_pa['hasil']. '('.format_kategori($nil_pa['hasil']).')</div>';

                  echo '<div class="huruf" style="display:none;">'.format_kategori($nil_pa['hasil']).'</div>';
                }
                else
                  echo "-";
              ?>
            </td>
            <?php endforeach; ?>
            <!-- rata-rata -->
            <td style="text-align: center;">
              <?php
                if($total != 0){
                  echo '<div class="huruf_angka">'.$total/$total_penilai. '('.format_kategori($total/$total_penilai).')</div>';

                  echo '<div class="huruf" style="display:none;">'.format_kategori($total/$total_penilai).'</div>';
                }
                else
                  echo "-";
              ?>
            </td>
          </tr>
        </tbody>
      </table>

  </div>
</div>
