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

?>

<div class="grid-container">

  <div class="box1 mb-4">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>

  <div class="box1">

    <?php if($nilai_total): ?>
      <form class="user" method="post" action="<?= base_url('Hapus_PA/hasil_proses'); ?>">

        <h5 class="text-center"><u><?= count($nilai_total) ?> nilai ditemukan</u></h5>

        <label style="font-size:13px;"><b>Penilai</b>: <?= $penilai['kr_nama_depan'].' '.$penilai['kr_nama_belakang'] ?></label><br>
        <label style="font-size:13px;" class="mb-3"><b>Karyawan yang dinilai</b>: <?= $dinilai['kr_nama_depan'].' '.$dinilai['kr_nama_belakang'] ?></label>
        <table class="table table-sm table-bordered" style="font-size:13px;">
          <thead>
            <th>Indikator</th>
            <th>Nilai</th>
          </thead>
          <tbody>
            <?php foreach($nilai_total as $n): ?>
              <tr>
                <td><?= $n['indi_pa_nama'] ?></td>
                <td>
                  <input type="hidden" name="nilai_pa_id[]" value="<?= $n['nilai_pa_id'] ?>">
                  <?= format_nilPa($n['nilai_pa_hasil']) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Nilai yang sudah dihapus tidak dapat dikembalikan, lanjutkan?')">
          HAPUS
        </button>

      </form>
    <?php else: ?>
      <h5 class="text-danger text-center mt-4">- Belum nilai -</h5>
    <?php endif; ?>

  </div>
</div>
