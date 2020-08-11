<style>
.grid-container {
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

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
  grid-column-gap:10px;
}
</style>

<div class="grid-container">
  <div class="box1 mt-4 ">
    <div class="alert alert-warning" role="alert"><b>Perhatian:</b><br>Nilai akan ditransfer berdasarkan email gsuite siswa, email gsuite siswa dapat diedit oleh TU masing-masing unit</div>
    <div class="box2">
      <div class="">
        <h6 class="text-center"><b><u>Nilai Pada Classroom</u></b></h6>
        <table class="table table-bordered table-striped" style="font-size:12px;">
          <thead>
            <tr>
              <th colspan="2">Classroom</th>
            </tr>
            <tr>
              <th>Nama</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($n_class as $key => $value): ?>
            <tr>
              <td><?= $key ?></td>
              <td class="p-3">
                <input type="hidden" class="nil_class" value="<?= $value ?>" id="<?= $key ?>">
                <?= $value ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="">
        <form action="<?= base_url('Classroom_CRUD/set_uj') ?>" method="post">
          <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
          <input type="hidden" name="mapel_id" value="<?= $mapel_id ?>">
          <input type="hidden" name="jenis" value="<?= $jenis ?>">
          <h6 class="text-center"><b><u>Nilai Pada SAS (<?= $judul ?>)</u></b></h6>
          <table class="table table-bordered table-striped" style="font-size:12px;">
            <thead>
              <tr>
                <th colspan="3">Kelas Tujuan</th>
              </tr>
              <tr>
                <th>Nama</th>
                <th>Nilai Sebelum</th>
                <th>Nilai Setelah</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $index = 0;
                foreach ($siswa_all as $s):
              ?>
              <tr>
                <td><?= '<b>'.$s['sis_nama_depan'].' '.$s['sis_nama_bel'].'</b><br><i>'.$s['sis_email'].'</i>' ?></td>
                <td>
                  <?php
                    //nilai sebelum
                    if(isset($s[$jenis]))
                      echo $s[$jenis];
                    else
                      echo "-";
                  ?>
               </td>
                <td>
                  <input type="hidden" name="d_s_id[]" value="<?= $s['d_s_id'] ?>">
                  <?php if(isset($s['uj_id'])): ?>
                    <input type="hidden" name="uj_id[]" value="<?= $s['uj_id'] ?>">
                  <?php endif; ?>

                  <?php
                    $ketemu = 0;
                    foreach ($n_class as $key => $value):
                  ?>
                    <?php
                      if($key == $s['sis_email'] ):
                        $ketemu = 1;
                    ?>
                      <input type="number" name="nil[]" value="<?= $value ?>" style='width: 47px;height: 20px;' min="0" max="100" required>
                    <?php endif; ?>
                  <?php endforeach; ?>


                <?php if($ketemu == 0 ): ?>
                  <input type="number" name="nil[]" value="0" style='width: 47px;height: 20px;' min="0" max="100" required>
                <?php endif; ?>

                </td>
              </tr>
              <?php $index++; endforeach; ?>
            </tbody>
          </table>
          <button type="submit" class="btn btn-success btn-sm">
            Simpan
          </button>
        </form>
      </div>
    </div>



  </div>

</div>
