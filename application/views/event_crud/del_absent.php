<style>
  .wrapper{
    display:grid;
    grid-template-columns:1fr 1fr 1fr 1fr;
    grid-auto-rows:minmax(20px, auto);
    /* grid-gap:1em; */
    justify-items:stretch;
    align-items:stretch;
    padding:1em;
    overflow: auto;
  }

  .wrapper_inside{
    display:grid;
    grid-template-columns:1fr 1fr 1fr 1fr;
    /* grid-gap:1em; */
    justify-items:stretch;
    align-items:stretch;
  }

  .top{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:2em;
    height: 10px;
  }
  .top_left{
    align-self:left;
    grid-column:1/5;
    text-align: left;
    padding:2em;
    height: 10px;
  }

  .bottom_center{
    align-self:center;
    grid-column:1/5;
    text-align:left;
    padding:1em;
    margin-bottom: 20px;
  }

  .announce{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:1em;
  }

  .left{
    /*justify-self:end;*/
    grid-column:1/3;
    padding:1em;
    /* grid-row:3; */
    /* border:1px solid #333; */
  }

  .right{
    grid-column:3/5;
    padding:1em;
    /* grid-row:2/4; */
    /* border:1px solid #333; */
  }

</style>

<?php

  function return_status_absen($status){
    if($status == 0){
      return "Bukan undangan";
    }elseif($status == 1){
      return "Hadir";
    }elseif($status == 2){
      return "Tidak Hadir";
    }
  }

?>

<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="top">
      <h4><u>Hapus absensi kegiatan <?= $event_d['event_nama'] ?></u></h4>
    </div>
    <div class="wrapper">
      <div class="bottom_center">
        
        <?= $this->session->flashdata('message'); ?>

        <table class="table table-sm table-bordered" style="font-size:14px;">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Unit</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($event_all as $e): ?>
            <tr>
              <td><?= $e['kr_nama_depan'].' '.$e['kr_nama_belakang'] ?></td>
              <td><?= $e['sk_nama'] ?></td>
              <td><?= return_status_absen($e['d_event_hadir']) ?></td>
              <td>
                <form class="" action="<?= base_url('Event_CRUD/del_absent_proses') ?>" method="post">
                  <input type="hidden" name="event_id" value=<?= $e['event_id'] ?>>
                  <input type="hidden" name="kr_id" value=<?= $e['kr_id'] ?>>
                  <button type="submit" class="badge badge-danger">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
