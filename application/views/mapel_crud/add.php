<style>
.grid-container {
  display: grid;
  grid-template-columns: 15% 15% 15% 25% 15% 15%;
  grid-column-gap:4px;
  padding-right:3px;
}
.grid-container > div{
  text-align:left;
}

.grid-main {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 20px;
  padding-top: 20px;
}

.box1{
  /*align-self:start;*/
  grid-column:2/3;
  overflow: auto;
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:3px;
}

</style>

<div class="grid-main">

    <div class="box1 mb-4">
      <div class="text-center">
          <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
      </div>

      <?= $this->session->flashdata('message'); ?>

      <form class="user" method="post" action="<?= base_url('Mapel_CRUD/add_proses'); ?>">

        <label style="font-size:14px;"><b>Nama:</b></label>
        <input type="text" class="form-control form-control-sm mb-2" name="mapel_nama" required>

        <label style="font-size:14px;"><b>KKM:</b></label>
        <input type="number" class="form-control form-control-sm mb-2" name="mapel_kkm" required>

        <label style="font-size:14px;"><b>Urutan dalam rapor:</b></label>
        <input type="number" class="form-control form-control-sm mb-2" name="mapel_urutan" required>

        <label style="font-size:14px;"><b>Singkatan Mapel:</b></label>
        <input type="text" class="form-control form-control-sm mb-2" name="mapel_sing" required>

        <button type="submit" class="btn btn-secondary btn-user btn-block">
          Tambah
        </button>
      </form>
      <hr>
    </div>

</div>
