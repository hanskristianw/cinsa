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
    <h5 class="text-center"><b><u>Kenaikan / Kelulusan<br> <?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <form class="user" method="post" action="<?= base_url('Ortu_CRUD/daftar_siswa_naik'); ?>">
      <label><b>Kelas:</b></label>
      <select name="kelas_id" class="form-control form-control-sm mb-2">
        <?php foreach ($kelas_all as $k) : ?>
          <option value='<?= $k['kelas_id'] ?>'>
            <?= $k['kelas_nama'] . ' (' . $k['t_nama'] . ')' ?>
          </option>
        <?php endforeach ?>
      </select>
      <button type="submit" class="btn btn-secondary btn-user btn-block">
        Proses
      </button>
    </form>
  </div>
</div>

<script type="text/javascript">
  $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
    $(".alert-danger").slideUp(500);
  });
  $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
    $(".alert-success").slideUp(500);
  });
</script>