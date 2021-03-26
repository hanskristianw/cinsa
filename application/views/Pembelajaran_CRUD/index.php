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

  <div class="box1 mb-4">

    <img src="<?= base_url('assets/img/googledrive.png'); ?>" class="mb-4" width="30%">

    <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
            </button>
            <br>
            <strong>PETUNJUK SHARE LINK FOLDER media pembelajaran:</strong><br><br>
            <ul>
              <li>Masuk ke <a href="https://drive.google.com" target="_blank">drive.google.com</a>, jangan lupa sign in terlebih dahulu</li>
              <li>Klik kanan pada folder yang ingin anda share lalu tekan <b>get link</b></li>
              <li>Rubah opsi <b>RESTRICTED menjadi ANYONE WITH LINK</b>, copy link lalu tekan done</li>
              <li>Paste link yang sudah anda copy ke kotak dibawah, lalu tekan simpan</li>
            </ul>

            <i>Folder media pembelajaran dapat berisi RPP, project guru dan segala hal yang berkaitan dengan penilaian KPI dan PA, informasi lebih lanjut hubungi wakakur atau kepala sekolah.</i>
        </div>';
    ?>

    <?= $this->session->flashdata('message'); ?>

    <form class="" action="<?= base_url('Pembelajaran_CRUD/save_proses'); ?>" method="post">

      <b><u>Masukkan link Google Drive</u>:</b>
      <input type="text" name="kr_google_drive" required class="form-control form-control-sm mt-2" value="<?= $gd['kr_google_drive'] ?>">

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Simpan
      </button>
    </form>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>
