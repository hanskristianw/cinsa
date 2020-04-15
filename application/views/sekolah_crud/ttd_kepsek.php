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
    <h1 class="h4 text-gray-900 mb-4"><u><?= $title . ' ', $ttd_kepsek['sk_nama'] ?></u></h1>

    <?= $this->session->flashdata('message'); ?>
  </div>

  <?php
  if (isset($error)) {
    echo $error;
  }
  ?>
  <form method="post" action="<?= base_url('sekolah_crud/save_ttd_kepsek') ?>" enctype="multipart/form-data">

    <img src="<?= base_url('assets/img/ttd_kepsek/') . $ttd_kepsek['ttd_kepsek'] ?>" alt="ttd_kepsek" width="300">

    <input type="hidden" value="<?= $sk_id ?>" name="sk_id">
    <input type="hidden" value="<?= $ttd_kepsek['ttd_kepsek'] ?>" name="ttd_kepsek">

    <div class="custom-file mt-2">
      <input type="file" class="custom-file-input" id="image" name="image" required>
      <label class="custom-file-label" for="image">Pilih Gambar Ttd</label>
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
      Add Image
    </button>
  </form>
  <hr>

</div>


<script type="text/javascript">
  $(document).ready(function() {

    $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-danger").slideUp(500);
    });
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>