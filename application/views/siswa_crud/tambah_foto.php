<style>
  .grid-container {
    display: grid;
    grid-template-columns: 100%;
    grid-column-gap: 3px;
    padding: 10px;
    margin-left: 10%;
    margin-right: 10%;
    margin-bottom: 50px;
    box-shadow: 5px 5px 5px 5px;
    overflow: auto;
  }
</style>

<div class="grid-container">

  <div class="text-center mt-3">
    <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="alert alert-danger alert-dismissible fade show">
        <button class="close" data-dismiss="alert" type="button">
            <span>&times;</span>
        </button>
        <br>
        <strong>PETUNJUK UPLOAD FOTO:</strong><br><br>
        <ul>
          <li>Foto sebaiknya punya dimensi yang sama misal 500x500 atau 600x600 dst</li>
          <li>Ukuran foto sebaiknya tidak lebih dari 1mb (1000kb) untuk mempercepat proses load di website dan android</li>
        </ul>
    </div>
  </div>

  <?php
  if (isset($error)) {
    echo $error;
  }
  ?>
  <form method="post" action="<?= base_url('Siswa_CRUD/save_foto') ?>" enctype="multipart/form-data">

    <input type="hidden" value="<?= $sis_pp['sis_id'] ?>" name="sis_id">

    <img src="<?= base_url('assets/img/siswa/') . $sis_pp['sis_pp'] ?>" alt="ttd" width="300">

    <div class="custom-file mt-2">
      <input type="hidden" value="<?= $sis_pp['sis_pp'] ?>" name="sis_pp">
      <input type="file" class="custom-file-input" id="image" name="image" required>
      <label class="custom-file-label" for="image">Pilih Foto Siswa</label>
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
      Tambah Foto
    </button>
  </form>
  <hr>

</div>


<script type="text/javascript">
  $(document).ready(function() {
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>
