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


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">

    <form class="" action="<?= base_url('laporan_crud/login_siswa') ?>" method="post">
      <select class="form-control form-control-sm mb-2" name="sk_id">
        <?php foreach ($sk_all as $s): ?>
          <option value="<?= $s['sk_id'] ?>"><?= $s['sk_nama'] ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-secondary btn-user btn-block">
        Proses
      </button>
    </form>

  </div>
</div>

<script>
  $(document).ready(function () {

    // $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
    //   $(".alert-success").slideUp(500);
    // });

  });
</script>
