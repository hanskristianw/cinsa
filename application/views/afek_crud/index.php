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
      <h1 class="h4 text-gray-900 mb-4 mt-4"><u>Pilih tahun ajaran, kelas dan topik afektif</u></h1>
    </div>

    <?= $this->session->flashdata('message'); ?>

    <form class="user" action="Afek_CRUD/input" method="POST">

      <label style="font-size:15px;" class="ml-1"><b><u>Urutan data:</u></b></label>
      <select name="cek_agama" class="form-control form-control-sm mb-2">
        <option value='0'>Urutkan berdasarkan nama</option>
        <option value='1'>Kelompokkan berdasarkan agama</option>
      </select>

      <label style="font-size:15px;" class="ml-1"><b><u>Tahun Ajaran:</u></b></label>
      <select name="t_id" id="afek_t_id" class="form-control form-control-sm">
        <option value="0">Pilih Tahun</option>
        <?php foreach ($t_all as $m) : ?>
          <option value='<?= $m['t_id'] ?>'>
            <?= $m['t_nama'] ?>
          </option>
        <?php endforeach ?>
      </select>

      <div id="kelas_afek_ajax" class="mt-2">

      </div>
      <div id="mapel_afek_ajax">

      </div>
      <div id="topik_afek_ajax">

      </div>
    </form>

  </div>

</div>
