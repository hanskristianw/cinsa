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
  overflow: auto;
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
}

.box3{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 45% 5% 50%;
}

</style>

<div class="grid-main">

  <div class="box1 text-center mt-4 mb-4"><h4><u>INDIKATOR KINERJA UTAMA <?= strtoupper($jab['jabatan_kpi_nama']) ?></u></h4></div>


  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1">
    <div class="box2">
      <div class="box3 mt-1 mb-1">
        <div><b>Nama Karyawan</b></div>
        <div><b>:</b></div>
        <div><?= $kr_dinilai['kr_nama_depan'].' '.$kr_dinilai['kr_nama_belakang'] ?></div>

        <div><b>Posisi</b></div>
        <div><b>:</b></div>
        <div><?= ucfirst($jab['jabatan_kpi_nama']) ?></div>
      </div>
      <div class="box3 mt-1 mb-1">
        <div><b>Unit</b></div>
        <div><b>:</b></div>
        <div><?= $kr_dinilai['sk_nama'] ?></div>

        <div><b>Penilai</b></div>
        <div><b>:</b></div>
        <div><?= $kr_penilai['kr_nama_depan'].' '.$kr_penilai['kr_nama_belakang'] ?></div>
      </div>
    </div>
  </div>


  <div class="box1 mb-4 mt-4">
    <?php
      if($new_indi):
    ?>
      <div class="alert alert-danger alert-dismissible fade show">
          <button class="close" data-dismiss="alert" type="button">
              <span>&times;</span>
          </button>
          <strong>Perhatian:</strong> Indikator baru ditemukan, silahkan simpan indikator sebelum melakukan proses edit
      </div>

      <form class="" action="<?= base_url('PA_penilai_CRUD/input_new_proses'); ?>" method="post">

        <input type="hidden" name="nilai_pa_penilai_kr_id" value="<?= $kr_penilai['kr_id'] ?>">
        <input type="hidden" name="nilai_pa_dinilai_kr_id" value="<?= $kr_dinilai['kr_id'] ?>">
        <input type="hidden" name="t_id" value="<?= $t_id ?>">

        <table class="table table-bordered table-hover table-sm" style="font-size:14px;">
          <thead class="thead-dark">
            <th class="pt-3 pb-3">FAKTOR PENILAIAN (KPI)</th>
            <th class="pt-3 pb-3">Hasil</th>
          </thead>
          <tbody>
          <?php
            $temp = "";
            foreach ($new_indi as $i) :
              if($temp != $i['kompe_pa_nama']):
          ?>
            <tr>
              <td colspan="3" class="pt-2 pb-2 bg-secondary text-white"><b><?= $i['kompe_pa_nama'] ?></b></td>
            </tr>
          <?php endif; ?>
            <tr>
              <td class="pt-2 pb-1"><?= $i['indi_pa_nama'] ?> <input type="hidden" name="indi_pa_id[]" value="<?= $i['indi_pa_id'] ?>"> </td>
              <td>
                <select class="" name="nilai_pa_hasil[]" style='height: 18px;font-size: 12px;'>
                  <option value="4">Sangat Setuju</option>
                  <option value="3">Setuju</option>
                  <option value="2">Tidak Setuju</option>
                  <option value="1">Sangat Tidak Setuju</option>
                </select>
              </td>
            </tr>
          <?php
              $temp = $i['kompe_pa_nama'];
            endforeach;
          ?>
          </tbody>
        </table>
        <button type="submit" class="btn btn-success btn-user btn-block mt-3 mb-4">
          Simpan indikator baru
        </button>

      </form>
      <hr>
    <?php
      endif;
    ?>


    <form class="" action="<?= base_url('PA_penilai_CRUD/update_proses'); ?>" method="post">

      <input type="hidden" name="nilai_pa_penilai_kr_id" value="<?= $kr_penilai['kr_id'] ?>">
      <input type="hidden" name="nilai_pa_dinilai_kr_id" value="<?= $kr_dinilai['kr_id'] ?>">
      <input type="hidden" name="t_id" value="<?= $t_id ?>">

      <table class="table table-bordered table-hover table-sm" style="font-size:14px;">
        <thead class="thead-dark">
          <th class="pt-3 pb-3">FAKTOR PENILAIAN (PA)</th>
          <th class="pt-3 pb-3">Hasil update</th>
        </thead>
        <tbody>
        <?php
          $temp = "";

          $pil = ['Sangat Setuju','Setuju','Tidak Setuju','Sangat Tidak Setuju'];

          foreach ($update as $i) :
            if($temp != $i['kompe_pa_nama']):
        ?>
          <tr>
            <td colspan="3" class="pt-2 pb-2 bg-secondary text-white"><b><?= $i['kompe_pa_nama'] ?></b></td>
          </tr>
        <?php endif; ?>
          <tr>
            <td class="pt-2 pb-1"><?= $i['indi_pa_nama'] ?> <input type="hidden" name="nilai_pa_id[]" value="<?= $i['nilai_pa_id'] ?>"> </td>
            <td>
              <select class="" name="nilai_pa_hasil[]" style='height: 18px;font-size: 12px;'>
                <?php
                  $pil_count = 0;

                  for ($x=4; $x >= 1 ; $x--) {

                    if($i['nilai_pa_hasil'] == $x)
                      echo '<option value = '.$x.' selected>'.$pil[$pil_count].'</option>';
                    else
                      echo '<option value = '.$x.'>'.$pil[$pil_count].'</option>';

                    $pil_count++;
                  }

                ?>
              </select>
            </td>
          </tr>
        <?php
            $temp = $i['kompe_pa_nama'];
          endforeach;
        ?>
        </tbody>
      </table>
      <?php
        if(!$new_indi):
      ?>
      <button type="submit" class="btn btn-success btn-user btn-block mt-3">
        Update
      </button>
      <?php
        endif;
      ?>
    </form>


  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>
