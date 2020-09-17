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
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}
</style>


<?php

  function return_tgl($tgl){

    $phpdate = strtotime( $tgl );
    $mysqldate = date( 'd-m-Y', $phpdate );

    return $mysqldate;
  }

?>

<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">


    <div class="alert alert-warning alert-dismissible fade show">
        <button class="close" data-dismiss="alert" type="button">
            <span>&times;</span>
        </button>
        <strong>Perhatian:</strong> Orang tua/siswa mungkin saja melakukan login di 1 atau lebih perangkat android
    </div>

    <table class="table table-sm table-bordered" style="font-size:14px;">
      <thead class="thead-dark">
        <tr style="height:50px;">
          <th class="align-middle text-center" style="width:20%;">Nama siswa</th>
          <th class="align-middle text-center">Perangkat</th>
          <th class="align-middle text-center">Terakhir Login</th>
          <th class="align-middle text-center" style="width:10%;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($device_all as $p): ?>
          <tr>
            <td><?= $p['sis_nama_depan'].' '.$p['sis_nama_bel'] ?></td>
            <td><?= $p['token_device'] ?></td>
            <td class="text-center"><?= return_tgl($p['token_last_seen']) ?></td>
            <td>
              <div class="box2">
                <form class="" action="<?= base_url('jadwal_crud/token_delete') ?>" method="post">
                  <input type="hidden" name="token_id" value=<?= $p['token_id'] ?>>
                  <button type="submit" class="badge badge-danger" onclick="return confirm('Perangkat yang dihapus dari daftar tidak akan mendapatkan pengumuman, lanjutkan?')">
                    Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>
