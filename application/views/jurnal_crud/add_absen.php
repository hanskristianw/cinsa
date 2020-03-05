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
  margin-bottom: 20px;
}

.box2{
  /*align-self:start;*/
  grid-template-columns: 50% 50%;
}
</style>

<div class="grid-container">

  <div class="box1">
    <h4 class="h4 text-gray-900 mt-3 text-center"><u><?= $title ?> <?= date("d-m-Y", strtotime($jurnal_tgl)); ?></u></h4>
    <h5 class="text-center"><?= ucwords(strtolower($kelas_nama)) .' '. $mapel_outline_nama ?></h5>
  </div>
  <div class="box1">
    <?php if($siswa_tdk_masuk_jurnal): ?>
    <h5 class="text-center"><u><b>Siswa yang tidak masuk</b></u></h5>
    <table class="table table-sm table-bordered table-hover table-striped" style="font-size: 12px;">
      <thead>
        <tr>
          <th>NIS</th>
          <th>Nama</th>
          <th class="text-center">Keterangan</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($siswa_tdk_masuk_jurnal as $tj) :?>
        <tr>
          <td style="width:35px;" class="align-middle"><?= $tj['sis_no_induk'] ?></td>
          <td class="align-middle"><?= $tj['sis_nama_depan'] ?> <?= $tj['sis_nama_bel'] ?></td>
          <td><?= $tj['absen_j_ket'] ?></td>
          <td>
            <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/delete_absen'); ?>">
              <input type="hidden" name="absen_j_id" value="<?= $tj['absen_j_id'] ?>">
              <button type="submit" class="badge badge-danger ml-2">
                <i class="fa fa-times"></i> Delete
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <br><br>
    <?php endif; ?>


    <div class="alert alert-warning" role="alert" style="font-size:14px;">
      <b>Perhatian: </b>Berikan tanda centang &#9745; pada siswa yang <b>TIDAK ADA</b> di kelas.
    </div>

    <table style="font-size:14px;" class="mb-2">
      <td class="bg-danger" style="width:40px;"></td>
      <td>&#8594;</td>
      <td><b>Telah Diabsen Oleh Wali Kelas pada pagi hari</b></td>
    </table>

    <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/add_absen_proses'); ?>" id="form_baru">
      <input type="hidden" value="<?= $jurnal_id ?>" name="jurnal_id">
      <table class="table table-sm table-bordered table-hover table-striped" style="font-size: 12px;">
        <thead>
          <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Tidak Hadir</th>
            <th class="text-center">Keterangan<br>(bila perlu)</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($sis as $s) :?>
          <?php 
            $merah = "";
            $dis = "";
            $ket = "";
            foreach($siswa_tdk_masuk_walkel as $t){
              if($t['d_s_id'] == $s['d_s_id']){
                $merah = "bg-danger text-white";
                $dis = "disabled";
                $ket = $t['absen_siswa_ket'];
              } 
            }
            
          ?>
          <tr class="<?= $merah ?>">
            <td style="width:35px;" class="align-middle"><?= $s['sis_no_induk'] ?></td>
            
            <td class="align-middle"><?= $s['sis_nama_depan'] ?> <?= $s['sis_nama_bel'] ?></td>
            <td style="width:35px;" class="align-middle">
              <input type="checkbox" name="tidak_masuk[]" value="<?= $s['d_s_id'] ?>" <?= $dis ?>>
            </td>
            <td class="align-middle">
              <input type="text" value="<?= $ket ?>" name="<?= $s['d_s_id'] ?>" class="form-control form-control-sm" style="font-size: 12px; height:20px;" <?= $dis ?>>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary btn-block">
        Save
      </button>
    </form>

  </div>
</div>


<script>
$(document).ready(function() {
  $('#form_baru').submit(function(){
      if(!$('#form_baru input[type="checkbox"]').is(':checked')){
        alert("Pilih setidaknya 1 siswa.");
        return false;
      }
  });
});
</script>