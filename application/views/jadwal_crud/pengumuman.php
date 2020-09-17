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
            <br>
            Pengumuman adalah berita internal unit yang terhubung dengan aplikasi android orang tua <br><br>
            <strong>Contoh pengumuman:</strong><br>

            <ul>
              <li>UTS dimulai tanggal dd-mm-yyyy</li>
              <li>Pengambilan rapor dilakukan di kelas masing-masing</li>
            </ul>

            Daftar perangkat orang tua yang sudah terinstall aplikasi dan akan mendapat pengumuman <a href="<?= base_url('jadwal_crud/daftar_siswa') ?>">klik disini</a>
        </div>

    <a href="<?= base_url('jadwal_crud/pengumuman_input') ?>" class="btn btn-primary mb-3">&#43; Pengumuman</a>

    <table class="table table-sm table-bordered" style="font-size:14px;">
      <thead class="thead-dark">
        <tr style="height:50px;">
          <th class="align-middle text-center" style="width:10%;">Tanggal</th>
          <th class="align-middle text-center">Judul Pengumuman</th>
          <th class="align-middle text-center">Detail Pengumuman</th>
          <th class="align-middle text-center" style="width:10%;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pengumuman_all as $p): ?>
          <tr>
            <td class="text-center"><?= return_tgl($p['pengumuman_tgl']) ?></td>
            <td><?= $p['pengumuman_judul'] ?></td>
            <td><?= $p['pengumuman_isi'] ?></td>
            <td>
              <div class="box2">
                <form class="" action="<?= base_url('jadwal_crud/pengumuman_edit') ?>" method="post">
                  <input type="hidden" name="pengumuman_id" value=<?= $p['pengumuman_id'] ?>>
                  <button type="submit" class="badge badge-warning">
                    Edit
                  </button>
                </form>
                <form class="" action="<?= base_url('jadwal_crud/pengumuman_delete') ?>" method="post">
                  <input type="hidden" name="pengumuman_id" value=<?= $p['pengumuman_id'] ?>>
                  <button type="submit" class="badge badge-danger">
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

<script>
  $(document).ready(function () {

    // $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
    //   $(".alert-success").slideUp(500);
    // });

  });
</script>
