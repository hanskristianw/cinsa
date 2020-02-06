<style>
.grid-container {
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:10px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
}
</style>


<div class="grid-container">
  <div>
  <h5 class="text-center"><u>Guru DENGAN Beban Tambahan</u></h5>
  <form action="<?= base_url('disjam_CRUD/set_beban_proses_up') ?>" method="POST">
  <table class="table table-hover table-bordered table-sm" style="font-size:11px;">
    <thead>
      <tr>
        <th style='width: 150px;'>Nama</th>
        <th>Beban dalam jam</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      if($kr_terbeban):
      foreach ($kr_terbeban as $k) : 
      ?>
      <tr>
        <td>
          <input type="hidden" value="<?= $k['beban_tam_id'] ?>" name="beban_tam_id[]">
          <?= $k['kr_nama_depan'].' '.$k['kr_nama_belakang'] ?>
        </td>
        <td><input type="number" min="0" value="<?= $k['beban_tam_jum'] ?>" name="beban_tam_jum[]"></td>
      </tr>
      <?php
      endforeach;
      else:
        echo "<td colspan='2' class='text-center text-danger'>NO DATA</td>";
      endif; 
      ?>
    </tbody>
  </table>
  <?php
    if($kr_terbeban):
  ?>
  <button type="submit" class="btn btn-success btn-user btn-block">
      Update
  </button>
  <?php
    endif; 
  ?>
  </form>
  </div>
  <div>
  <h5 class="text-center"><u>Guru TANPA Beban Tambahan</u></h5>
  <form action="<?= base_url('disjam_CRUD/set_beban_proses_save') ?>" method="POST">
  <input type="hidden" value="<?= $t_id ?>" name="beban_tam_t_id">
  <table class="table table-hover table-bordered table-sm" style="font-size:11px;">
    <thead>
      <tr>
        <th style='width: 150px;'>Nama</th>
        <th>Beban dalam jam</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($kr_tanpa_beban as $k) : 
      ?>
      <tr>
        <td>
          <input type="hidden" value="<?= $k['kr_id'] ?>" name="beban_tam_kr_id[]">
          <?= $k['kr_nama_depan'].' '.$k['kr_nama_belakang'] ?>
        </td>
        <td><input type="number" min="1" name="beban_tam_jum[]"></td>
      </tr>
      <?php
      endforeach; 
      ?>
    </tbody>
  </table>
  <button type="submit" class="btn btn-success btn-user btn-block">
      Save
  </button>
  </form>
  </div>
</div>