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
}
</style>

<div class="grid-container">
  <div class="box1">

    <h4 class="text-center mb-3"><u>Siswa pada jenjang akhir</u></h4>

    <div class="alert alert-warning" role="alert">
      Silahkan tandai siswa dengan &#10003; <b>bila siswa SUDAH LULUS</b><br><br>Siswa yang sudah lulus tidak akan tampil pada daftar siswa
    </div>
    <?= $this->session->flashdata('message'); ?>

    <form class="user" method="post" action="<?= base_url('Kelulusan_CRUD/proses_lulus'); ?>">
      <table class="table table-bordered table-striped dt" style="font-size:13px;">
        <thead class="thead-dark">
          <tr style="height:60px;">
            <th class="text-center">Nama</th>
            <th class="text-center">Kelas Akhir</th>
            <th class="text-center">Lulus?</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($sis_all as $s):
          ?>
            <tr>
              <td style='padding: 5px 3px 0px 13px;'><?= $s['sis_nama_depan'].' '.$s['sis_nama_bel'] ?></td>
              <td><?= $s['kelas_nama'] ?></td>
              <td>
                <input type="hidden" name="sis_id[]" value="<?= $s['sis_id'] ?>">
                <?php if ($s['sis_alumni'] == 0) : ?>
                  <input type="hidden" name="sis_alumni[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
                <?php else : ?>
                  <input type="hidden" name="sis_alumni[]" value="1"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value" checked>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-secondary btn-user btn-block mt-2">
        Proses
      </button>
    </form>

  </div>

</div>
