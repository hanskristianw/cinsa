<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-4">
            <div class="text-center">
              <h4 class="h4 text-gray-900 mt-3"><u><?= $title ?></u></h4>
              <h5><?= ucwords(strtolower($mapel_nama)) ?></h5>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" method="post" action="<?= base_url('Topik_CRUD/proses_add_outline'); ?>">
              <input type="hidden" name="mapel_outline_mapel_id" value="<?= $mapel_id ?>">

              <label for="mapel_outline_nama"><b><u>Deskripsi Outline</u>:</b></label>
              <textarea rows="4" name="mapel_outline_nama" class="form-control mb-2"></textarea>

              <label for="mapel_outline_jenj_id"><b><u>Untuk Jenjang</u>:</b></label>
              <select name="mapel_outline_jenj_id" class="form-control form-control-sm">
                <?php
                  $_selected = set_value('mapel_outline_jenj_id');

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
              
              <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
                Proses
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>