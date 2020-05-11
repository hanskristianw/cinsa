<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?><br><?= $k_detail['kelas_nama'] ?></u></h1>
            </div>


            <?= $this->session->flashdata('message'); ?>
            <form class="user" method="post" action="<?= base_url('Kelas_CRUD/edit_cb_proses'); ?>">
              <input type="hidden" name="kelas_id" value="<?= $k_detail['kelas_id'] ?>">
              <label><b><u>Guru CB saat ini:</u></b></label><br>

              <?php
              if ($k_detail['kr_nama_depan'])
                echo $k_detail['kr_nama_depan'] . ' ' . $k_detail['kr_nama_belakang'];
              else
                echo "<label class='text-danger'><b>-Guru CB belum diset-</b></label>";
              ?>
              <br><br>
              <?php if ($konselor) : ?>
                <label><b><u>Rubah Menjadi:</u></b></label>
                <select name="kelas_cb_kr_id" id="kelas_cb_kr_id" class="form-control form-control-sm mb-2">
                  <?php
                  $_selected = set_value('jenj_id');

                  foreach ($konselor as $m) :
                    if ($_selected == $m['kr_id']) {
                      $s = "selected";
                    } else {
                      $s = "";
                    }
                    echo "<option value=" . $m['kr_id'] . " " . $s . ">" . $m['kr_nama_depan'] . ' ' . $m['kr_nama_belakang'] . "</option>";
                  endforeach
                  ?>
                </select>
              <?php else : ?>
                <label class='text-danger'><b>-Silahkan hubungi divisi pendidikan untuk set konselor pada unit ini-</b></label>
              <?php endif; ?>

              <?php if ($konselor) : ?>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Update
                </button>
              <?php endif; ?>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>