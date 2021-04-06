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
  <div class="box1 mb-4 mt-4">
    <div class="text-center">
        <h3 class="text-gray-900"><u><?= $title ?></u></h3>
        <h6 style="color:red"><b>Unit utama: <?= $utama['sk_nama'] ?></b></h6>
    </div>

    <div style="padding-bottom:10px;">
      <label><b><u>Pilih Unit Tambahan: </u></b></label><br>
      <form action="<?= base_url('Karyawan_CRUD/unit_tambahan_proses') ?>" method="post">

        <input type="hidden" name="kr_id" value="<?= $kr_id ?>">

        <?php foreach ($tambah as $t):?>
          <input type="checkbox" id="<?= $t['sk_id'] ?>" value="<?= $t['sk_id'] ?>" name="sk_id[]"> <label for="<?= $t['sk_id'] ?>"><?= $t['sk_nama'] ?></label>
          <br>
        <?php endforeach; ?>
        <button class="btn btn-dark mt-2">
          Simpan
        </button>
      </form>

      <hr>

      <?php if($terdaftar): ?>

      <b><u>Unit Tambahan terdaftar</u>:</b>
      <table class="table table-sm table-bordered mt-2" style="font-size:14px;">
        <thead>
          <th>Nama</th>
          <th>Action</th>
        </thead>
        <tbody>
          <?php foreach ($terdaftar as $t):?>
            <tr>
              <td><?= $t['sk_nama'] ?></td>
              <td>
                <form action="<?= base_url('Karyawan_CRUD/delete_tambahan') ?>" method="post">
                  <input type="hidden" name="kr_sk_tam_id" value="<?= $t['kr_sk_tam_id'] ?>" method="post">
                  <button onclick="return confirm('Hapus unit tambahan?')" type="submit" class="badge badge-danger">
                    Delete tambahan
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php endif; ?>

    </div>




  </div>
</div>
