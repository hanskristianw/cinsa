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
      <h1 class="h4 text-gray-900 mb-4"><u>Daftar Kelas</u></h1>
    </div>


    <?= $this->session->flashdata('message'); ?>

    <a href="<?= base_url('kelas_crud/add') ?>" class="btn btn-primary mb-3">&plus; Kelas</a>

    <table class="table table-bordered table-sm display compact table-hover dt" style="font-size:14px;">
      <thead>
        <tr style="height:50px;">
          <th class="align-middle text-center">Nama</th>
          <th class="align-middle text-center">Sing</th>
          <th class="align-middle text-center">Jenjang</th>
          <th class="align-middle text-center">&Sigma; Murid</th>
          <th class="align-middle text-center">Wali Kelas</th>
          <th class="align-middle text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $t_nama_temp = "";
        foreach ($kelas_all as $m) :
        ?>
          <?php
          if ($t_nama_temp != $m['t_nama']) {
            $tahun_fix = "<tr class='bg-dark text-light'>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class='text-center'><b>" . $m['t_nama'] . "</b></td>
                              <td></td>
                            </tr>";
          } else {
            $tahun_fix = "";
          }
          ?>
          <?= $tahun_fix ?>
          <tr>
            <td><?= $m['kelas_nama'] ?></td>
            <td><?= $m['kelas_nama_singkat'] ?></td>
            <td><?= $m['jenj_nama'] ?></td>
            <td><?= $m['jum_siswa'] ?></td>
            <td>

              <form class="" action="<?= base_url('Kelas_CRUD/save_homeroom') ?>" method="post">
                <select name="kelas_kr_id" id="kelas_kr_id" style="font-size:12px; height:20px;">
                  <?php
                  $_selected = $m['kelas_kr_id'];
                  echo "<option value= '4'>No HR Teacher</option>";
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
            </td>
            <td>
              <div class="form-group row m-0 p-0">
                <input type="hidden" name="kelas_id" value=<?= $m['kelas_id'] ?>>
                <button type="submit" class="badge badge-dark">
                  Save HR
                </button>
                </form>
                <form class="" action="<?= base_url('Kelas_CRUD/update') ?>" method="get">
                  <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                  <button type="submit" class="badge badge-warning">
                    Edit Kelas
                  </button>
                </form>
                <form class="" action="<?= base_url('Kelas_CRUD/edit_student') ?>" method="get">
                  <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                  <button type="submit" class="badge badge-success">
                    Edit Siswa
                  </button>
                </form>
                <form class="" action="<?= base_url('Kelas_CRUD/edit_subject') ?>" method="get">
                  <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                  <button type="submit" class="badge badge-primary">
                    Edit Mapel
                  </button>
                </form>
                <form class="" action="<?= base_url('Kelas_CRUD/edit_cb') ?>" method="post">
                  <input type="hidden" name="kelas_id" value=<?= $m['kelas_id'] ?>>
                  <input type="hidden" name="kelas_sk_id" value=<?= $m['kelas_sk_id'] ?>>
                  <button type="submit" class="badge badge-secondary">
                    Edit Guru CB
                  </button>
                </form>
                <form class="" action="<?= base_url('Kelas_CRUD/delete') ?>" method="post">
                  <input type="hidden" name="kelas_id" value=<?= $m['kelas_id'] ?>>
                  <button type="submit" onclick="return confirm('Kelas akan dihapus, lanjutkan?')" class="badge badge-danger">
                    Del
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php
          $t_nama_temp = $m['t_nama'];
        endforeach
        ?>
      </tbody>
    </table>
    <hr>
  </div>

</div>
