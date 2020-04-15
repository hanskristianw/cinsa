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
    <h1 class="h4 text-gray-900 mb-4"><u><?= $title . ' - ' . $kr['kr_nama_depan'] . ' ' . $kr['kr_nama_belakang'] ?></u></h1>

    <?= $this->session->flashdata('message'); ?>
  </div>

  <?php
  if (isset($error)) {
    echo $error;
  }
  ?>
  <form method="post" action="<?= base_url('profile/save_ttd') ?>" enctype="multipart/form-data">

    <img src="<?= base_url('assets/img/ttd/') . $kr_ttd['kr_ttd'] ?>" alt="ttd" width="300">

    <div class="custom-file mt-2">
      <input type="hidden" value="<?= $kr_ttd['kr_ttd'] ?>" name="kr_ttd">
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