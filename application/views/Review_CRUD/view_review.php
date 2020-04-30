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
          1. Setiap orang tua siswa akan mendapatkan notifikasi jika siswa tidak masuk, pastikan bahwa siswa benar-benar tidak masuk ke guru pengajar yang bersangkutan
          <br><br>
          2. Pastikan juga outline terisi, setelah disetujui, guru tidak dapat merubah informasi apapun yang berkaitan dengan jurnal pada minggu, hari dan jam itu
        </div>'; ?>

    <form action="<?= base_url('Review_CRUD/proses_review'); ?>" method="POST" id="form_setuju">
    <table class="table table-sm table-bordered" style="font-size:12px;">
      <thead class="bg-secondary text-white text-center">
        <th style="width:45px;">
            Setujui? <br><br>
            <input type="checkbox" id="checkAll">
        </th>
        <th style="width:25px;">Minggu ke</th>
        <th style="width:25px;">Jam ke</th>
        <th style="width:100px;">Mapel</th>
        <th>Outline</th>
        <th>Absen/Keterangan</th>
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
          <td class="text-center">
              <input type="hidden" name="setujui[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
          </td>
          <td>
            <input type="hidden" name="jurnal_bulan_id[]" value="<?= $r['jurnal_bulan_id'] ?>">
            <input type="hidden" name="jurnal_id[]" value="<?= $r['jurnal_id'] ?>">
            <?= $r['jurnal_minggu_ke'] ?>
          </td>
          <td><?= $r['jurnal_jam_ke'] ?></td>
          <td><?= $r['mapel_nama'] ?></td>
          <td><?= $r['mapel_outline_nama'] ?></td>
          <td>
            <?php
              if($r['jurnal_d_s_id_absen'] != ""){
                $sis_arr = return_siswa_by_d_s_id($r['jurnal_d_s_id_absen']);
                $s_ket = explode("{/}",$r['jurnal_d_s_id_ket']);

                //var_dump($s_ket);
                $hitung = 0;
                foreach ($sis_arr as $s){
                  echo "<input type='hidden' name='".$r['jurnal_id']."[]' value='".$s['d_s_id']."'>";
                  echo "<input type='hidden' name='k".$r['jurnal_id']."[]' value='".$s_ket[$hitung]."'>";
                  echo "<div style='font-size:11px;'>".$s['sis_nama_depan'].' '.$s['sis_nama_bel'].' / '.$s_ket[$hitung]."</div>";
                  $hitung++;
                }
              }
            ?>

          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button type="submit" class="btn btn-secondary btn-block">
      <i class="fa fa-save"></i> PROSES
    </button>
    </form>
  </div>
</div>


<script>
  $(document).ready(function() {

    $('#checkAll').click(function () {
        $('input:checkbox').prop('checked', this.checked);
    });

    $('#form_setuju').submit(function(){
      if(!$('#form_setuju input[type="checkbox"]').is(':checked')){
        alert("Setujui setidaknya satu jurnal.");
        return false;
      }
    });

  });
</script>
