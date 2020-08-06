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
    <h1 class="h4 text-gray-900"><u><?= $title ?></u></h1>
    <h4><?= $kr['kr_nama_depan'] . ' ' . $kr['kr_nama_belakang'] ?></h4>

    <?= $this->session->flashdata('message'); ?>
  </div>

  <?php
  if (isset($error)) {
    echo $error;
  }
  ?>
  <form method="post" action="<?= base_url('profile/save_email_google') ?>">

    <label for="kr_email"><b>Google Account:</b></label>
    <input type="text" class="form-control form-control-sm" name="kr_email" value="<?= $kr_email['kr_email'] ?>" pattern="[^' ']+@nationstaracademy.sch.id" title="Tidak boleh ada spasi, harus account nationstaracademy.sch.id" required>

    <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
      Simpan
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
