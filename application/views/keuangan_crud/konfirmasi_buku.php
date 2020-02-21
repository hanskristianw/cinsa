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
}
</style>


<div class="grid-container">

  <div class="box1 mb-3">
    <h5 class="text-center"><b><u>Bukti Transfer</u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <table class="table table-sm table-hover table-bordered mt-3" style="font-size:12px;">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Gambar</th>
          <th>Konfirmasi Siswa Baru</th>
        </tr>
      </thead>
      <tbody>
        <?php if(count($k_all)>0): 
          $no = 1;
          foreach($k_all as $p) : ?>
          <tr>
            <td style='width:100px;'><?= $p['konfirmasi_tgl'] ?></td>
            <td style='padding: 2px 5px 2px 5px;'> 
              <a href="<?= 'http://localhost/psb/assets/img/konfirmasi/'.$p['konfirmasi_path'] ?>" target="_blank">
                <img src="<?= 'http://localhost/psb/assets/img/konfirmasi/'.$p['konfirmasi_path'] ?>" width="100px;"> 
              </a>
            </td>
            <td>
              <?php if($sis_baru_all): ?>
              <form action="<?= base_url('Keuangan_CRUD/konfirmasi_baru_proses') ?>" method="POST">
                <input type="hidden" name="konfirmasi_id" value="<?= $p['konfirmasi_id'] ?>">
                <select name="sis_baru_id" id="sis_baru_id" class="form-control form-control-sm" style="font-size:12px;">
                  <?php foreach ($sis_baru_all as $s) : ?>
                    <option value='<?=$s['sis_baru_id'] ?>'>
                      <?= number_format($s['sis_tagihan'],0,",",".").' A/N '.$s['sis_baru_nama'].$s['sis_nama_depan'].$s['sis_nama_bel'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
                <button type="submit" class="btn btn-success btn-sm mt-2" style="cursor: pointer;">
                  Konfirmasi
                </button>
              </form>
              <?php else: ?>
                <label class="text-danger">- Belum terdapat pesanan -</label>
              <?php endif; ?>
            </td>
            
          </tr>
        <?php $no++; endforeach;
          else:
            echo "<td colspan='3' class='text-center text-danger'><b>No Data</b></td>";
          endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>

$(document).ready(function() {

  $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
  });

  $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-danger").slideUp(500);
  });

});
</script>