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


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
  <?php echo '<div class="alert alert-info alert-dismissible fade show">
          <button class="close" data-dismiss="alert" type="button">
              <span>&times;</span>
          </button>
          <strong>Perhatian:</strong> <br><br>
          Pembatalan review digunakan jika guru pengajar berniat melakukan revisi pada jurnal, karena jurnal yang selesai direview tidak dapat dirubah oleh guru pengajar
          </div>'; ?>

    <form action="<?= base_url('Review_CRUD/proses_cancel_review'); ?>" method="POST" id="form_setuju">
    <table class="table table-sm table-bordered" style="font-size:12px;">
      <thead class="bg-secondary text-white text-center">
        <th style="width:25px;">Minggu ke</th>
        <th style="width:25px;">Jam ke</th>
        <th style="width:100px;">Mapel</th>
        <th>Outline</th>
        <th>Absen</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php
          //var_dump($review_all);
          $nama_next = 0;
          foreach ($review_all as $r):
          $nama_bulan = $r['jurnal_bulan_id'];
        ?>
        <?php if($nama_bulan!=$nama_next):?>
        <tr class="bg-dark text-white text-center">
          <td colspan="6"><?= return_nama_bulan_indo($r['jurnal_bulan_id']) ?></td>
        </tr>
        <?php
          $nama_next = $r['jurnal_bulan_id'];
          endif;
        ?>

        <tr>
          <td>
            <?= $r['jurnal_minggu_ke'] ?>
          </td>
          <td><?= $r['jurnal_jam_ke'] ?></td>
          <td><?= $r['mapel_nama'] ?></td>
          <td><?= $r['mapel_outline_nama'] ?></td>
          <td>
            <?php
              if($r['jurnal_d_s_id_absen'] != ""){
                $sis_arr = return_siswa_by_d_s_id($r['jurnal_d_s_id_absen']);

                foreach ($sis_arr as $s){
                  echo "<input type='hidden' name='".$r['jurnal_id']."[]' value='".$s['d_s_id']."'>";
                  echo "<div style='font-size:11px;'>".$s['sis_nama_depan'].' '.$s['sis_nama_bel']."</div>";
                }
              }
            ?>
          </td>
          <td>
            <form action="<?= base_url('Review_CRUD/proses_cancel_review') ?>" method="post">
              <input type="hidden" name="jurnal_id" value="<?= $r['jurnal_id'] ?>">
              <button type="submit" class="badge badge-danger">
                Batalkan
              </button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </form>
  </div>
</div>
