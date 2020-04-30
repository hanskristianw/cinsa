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
    <form class="user" method="post" action="<?= base_url('Review_CRUD/view_review'); ?>">
      <label><b>Kelas:</b></label>
      <select name="kelas_id" class="form-control form-control-sm mb-2">
        <?php foreach ($kelas_all as $k) : ?>
          <option value='<?=$k['kelas_id'] ?>'>
            <?= $k['kelas_nama'].' ('.$k['t_nama'].')' ?>
          </option>
        <?php endforeach ?>
      </select>
      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Proses
      </button>
    </form>
  </div>
</div>
