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
            <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
        </div>

        <?php if($jum_tes > 0): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
            </button>
            <strong>PERHATIAN:</strong> Edit jenjang hanya dapat dilakukan ketika topik tidak mempunyai nilai
        </div>
        <?php endif; ?>
        <?= $this->session->flashdata('message'); ?>

        <form class="user" method="post" action="<?= base_url('Topik_CRUD/edit_proses'); ?>">
            <input type="hidden" name="_id" value="<?= set_value('_id', $topik_update['topik_id']) ?>">
            <label for="topik_nama" style="font-size:14px;"><b><u>Nama Topik</u>:</b></label>
            <input type="text" class="form-control form-control-sm mb-2" id="topik_nama" name="topik_nama" value="<?= set_value('topik_nama', $topik_update['topik_nama']) ?>" required>

            <label for="topik_urutan" style="font-size:14px;"><b><u>Urutan Topik</u>:</b></label>
            <input type="number" class="form-control form-control-sm mb-2" id="topik_urutan" name="topik_urutan" value="<?= set_value('topik_urutan', $topik_update['topik_urutan']) ?>" required>

            <?php if($jum_tes == 0): ?>
              <label for="jenj_id"><b><u>For Level</u>:</b></label>
              <select name="jenj_id" id="jenj_id" class="form-control form-control-sm">
                  <?php
                  $_selected = set_value('jenj_id', $topik_update['topik_jenj_id']);

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
            <?php else: ?>
                <input type="hidden" name="jenj_id" value="<?= $topik_update['topik_jenj_id'] ?>">
            <?php endif; ?>

            <label for="topik_semester" style="font-size:14px;"><b><u>Semester</u>:</b></label>
            <select name="topik_semester" class="form-control form-control-sm mb-2">
              <?php
                  $_selected = set_value('topik_semester', $topik_update['topik_semester']);

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
                Update
            </button>
        </form>
        <hr>
    </div>

</div>
