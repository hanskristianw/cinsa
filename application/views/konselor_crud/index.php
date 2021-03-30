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
  margin-right: 20px;
}

</style>

<div class="grid-main">

  <div class="box1">
    <div class="text-center">
      <h1 class="h4 text-gray-900"><u><b>Daftar Konselor</b></u></h1>
    </div>

    <input type="hidden" id="tes_flag" value = 1>

    <?= $this->session->flashdata('message'); ?>

    <form class="user" action="<?= base_url('Konselor_CRUD/add') ?>" method="POST">
      <div class="form-group row m-0 p-0">
        <div class="col-sm mb-sm-0">
          <select name="sk_id" id="kadiv_kon_sk" class="form-control form-control-sm mb-3">
            <option value="0">Pilih Sekolah</option>
            <?php foreach ($sk_all as $m) : ?>
              <option value='<?= $m['sk_id'] ?>'>
                <?= $m['sk_nama'] ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div id="but_konselor" style="margin-left:15px;margin-right:15px;">
        <button type="submit" class="btn btn-secondary">
          Tambah Konselor
        </button>
      </div>
    </form>

    <div id="kadiv_kon_detail" style="margin-left:15px;margin-right:15px;">

    </div>

  </div>

</div>
