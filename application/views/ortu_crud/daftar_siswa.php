<style>
  .grid-container {
    display: grid;
    grid-template-columns: 5% 90% 5%;
    grid-column-gap: 3px;
    padding: 10px;
    margin: 20px;
    box-shadow: 5px 5px 5px 5px;
    overflow: auto;
    padding-bottom: 120px;
    padding-top: 50px;
  }


  .box1 {
    /*align-self:start;*/
    grid-column: 2/3;
  }

  .box2 {
    /*align-self:start;*/
    grid-template-columns: 50% 50%;
  }
</style>


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center mb-4"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
    <div class="alert alert-warning" role="alert">
      Silahkan tandai siswa dengan &#10003; bila ingin memblokir akses siswa, akses siswa dapat diblokir karena alasan tertentu, info lebih lanjut hubungi wakakur atau divisi pendidikan, <b>blokir siswa hanya berlaku pada tahun ajaran dimana kelas tersebut aktif</b>
    </div>
  </div>
  <div class="box1">
    <form class="user" method="post" action="<?= base_url('Ortu_CRUD/proses_blokir'); ?>">

      <table class="table table-sm table-bordered" style="font-size:13px;">
        <thead>
          <tr class="bg-dark text-white">
            <th style="width:5%;" class="text-center align-middle">No Induk</th>
            <th style="height:80px;" class="text-center align-middle">Nama Siswa</th>
            <th style="height:80px;" class="text-center align-middle">Username</th>
            <th style="width:10%;" class="bg-danger text-white text-center align-middle">Blokir Akses Siswa?</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $blokir = "";
          foreach ($sis_all as $s) :
          ?>
            <tr>
              <td style="width:80px;" class="text-center">
                <input type="hidden" name="d_s_id[]" value="<?= $s['d_s_id'] ?>">
                <?= $s['sis_no_induk'] ?>
              </td>
              <td class="text-center"><?= $s['sis_nama_depan'] . ' ' . $s['sis_nama_bel'] ?></td>
              <td class="text-center"><?= $s['sis_username'] ?></td>
              <td class="text-center">
                <?php if ($s['d_s_blokir'] == 0) : ?>
                  <input type="hidden" name="d_s_blokir[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
                <?php else : ?>
                  <input type="hidden" name="d_s_blokir[]" value="1"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value" checked>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <button type="submit" class="btn btn-primary btn-user btn-block">
        Proses
      </button>
    </form>
  </div>
</div>