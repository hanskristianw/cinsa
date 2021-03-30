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

  <div class="box1 text-center">
      <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
  </div>

  <div class="box1">

    <form class="user" method="post" action="<?php echo base_url('Sekolah_CRUD/update_proses'); ?>">

      <input type="hidden" name="_id" value="<?= set_value('_id',$sk_update['sk_id']); ?>">

      <label for="sk_nama"><b><u>Nama Sekolah</u>:</b></label>
      <input type="text" class="form-control form-control-sm mb-3" id="sk_nama" name="sk_nama" value="<?= $sk_update['sk_nama'] ?>" required>

      <label for="sk_nickname"><b><u>Singkatan Sekolah</u>:</b></label>
      <input type="text" class="form-control form-control-sm mb-3" id="sk_nickname" name="sk_nickname" value="<?= $sk_update['sk_nickname'] ?>" required>

      <label for="kr_id"><b><u>Kepala Sekolah</u>:</b></label>
      <select name="kr_id" id="kr_id" class="form-control form-control-sm mb-3">
          <?php
          $_selected = set_value(kr_id,$sk_update['sk_kepsek']);

          echo "<option value= '0'> Pilih Kepsek</option>";
          foreach ($guru_all as $n) :
              if ($_selected == $n['kr_id']) {
                  $s = "selected";
              } else {
                  $s = "";
              }
              echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . " " . $n['kr_nama_belakang'] . "</option>";
          endforeach
          ?>
      </select>

      <label for="sk_wakasis"><b><u>Wakakur Kesiswaan</u>:</b></label>
      <select name="sk_wakasis" id="sk_wakasis" class="form-control form-control-sm mb-3">
        <?php
        $_selected = set_value(kr_id,$sk_update['sk_wakasis']);

        echo "<option value= '4'> Admin</option>";
        foreach ($guru_all as $n) :
            if ($_selected == $n['kr_id']) {
                $s = "selected";
            } else {
                $s = "";
            }
            echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . " " . $n['kr_nama_belakang'] . "</option>";
        endforeach
        ?>
      </select>

      <!-- <label for="scout_id"><b><u>Pengajar Pramuka</u>:</b></label>
      <select name="scout_id" id="scout_id" class="form-control form-control-sm mb-3"> -->
        <?php
          // $_selected = set_value(kr_id,$sk_update['sk_scout_kr_id']);
          //
          // echo "<option value= '4'> Admin</option>";
          // foreach ($guru_all as $n) :
          //     if ($_selected == $n['kr_id']) {
          //         $s = "selected";
          //     } else {
          //         $s = "";
          //     }
          //     echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . " " . $n['kr_nama_belakang'] . "</option>";
          // endforeach
        ?>
        <!-- </select> -->

        <label for="sk_mid"><b><u>ID Instagram Sekolah</u>:</b></label>
        <input type="text" name="sk_insta" class="form-control form-control-sm mb-3" value="<?= $sk_update['sk_insta'] ?>" required>

        <label for="sk_mid"><b><u>Tanggal Penerimaan Rapor Sisipan</u>:</b></label>
        <input type="date" name="sk_mid" class="form-control form-control-sm mb-3" value="<?= $sk_update['sk_mid'] ?>" required>

        <label for="sk_mid"><b><u>Tanggal Penerimaan Rapor Final</u>:</b></label>
        <input type="date" name="sk_fin" class="form-control form-control-sm mb-3" value="<?= $sk_update['sk_fin'] ?>" required>

        <label for="sk_ex_nama"><b><u>Nama Extrakurikuler</u>:</b></label>
        <input type="text" class="form-control form-control-sm mb-3" id="sk_ex_nama" name="sk_ex_nama" value="<?= $sk_update['sk_ex_nama']; ?>">

        <label for="sk_ex_abr"><b><u>Singkatan Extrakurikuler</u>:</b></label>
        <input type="text" class="form-control form-control-sm mb-3" id="sk_ex_abr" name="sk_ex_abr" value="<?= $sk_update['sk_ex_abr']; ?>">

        <button type="submit" class="btn btn-secondary btn-user btn-block">
            Update
        </button>
      </form>
    </div>
    <hr>

</div>
