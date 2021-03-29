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

      <form class="user" method="post" action="<?= base_url('Topik_CRUD/proses_add'); ?>">
          <input type="hidden" name="mapel_id" value="<?= $mapel_id ?>">
          <label for="topik_nama" style="font-size:14px;"><b><u>Nama Topik</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="topik_nama" name="topik_nama" required>

          <label for="topik_urutan" style="font-size:14px;"><b><u>Urutan Topik</u>:</b></label>
          <input type="number" class="form-control form-control-sm mb-2" id="topik_urutan" name="topik_urutan" required>

          <label for="jenj_id" style="font-size:14px;"><b><u>Untuk Jenjang</u>:</b></label>
          <select name="jenj_id" id="jenj_id" class="form-control form-control-sm mb-2">
              <?php
              $_selected = set_value('jenj_id');

              foreach ($jenj_all as $m) :
              if ($_selected == $m['jenj_id']) {
                  $s = "selected";
              } else {
                  $s = "";
              }
              echo "<option value=" . $m['jenj_id'] . " " . $s . ">" . $m['jenj_nama'] . "</option>";
              endforeach
              ?>
          </select>

          <label for="topik_semester" style="font-size:14px;"><b><u>Semester</u>:</b></label>
          <select name="topik_semester" class="form-control form-control-sm mb-2">
              <?php
                  $_selected = set_value('topik_semester');

                  if ($_selected == 1) {
                      echo '<option value="1" selected>Semester 1</option>
                      <option value="2">Semester 2</option>';
                  } elseif ($_selected == 2) {
                      echo '<option value="1">Semester 1</option>
                      <option value="2" selected>Semester 2</option>';
                  }
                  else{
                      echo '<option value="1">Semester 1</option>
                      <option value="2">Semester 2</option>';
                  }
              ?>

          </select>

          <button type="submit" class="btn btn-secondary btn-user btn-block">
              Tambah Topik
          </button>
      </form>
      <hr>
    </div>

</div>
