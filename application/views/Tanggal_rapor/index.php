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

  <div class="box1 text-center mt-4"><h4><u><?= $title ?></u></h4></div>

  <div class="box1">
    <div class="alert alert-warning alert-dismissible fade show">
        <button class="close" data-dismiss="alert" type="button">
            <span>&times;</span>
        </button>
        <strong>Perhatian:</strong>
        <br><br>
        Silahkan lakukan perubahan sebelum melakukan cetak rapor CB / rapor Akademik
    </div>
  </div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">

    <form action="<?= base_url('Tanggal_Rapor/update') ?>" method="post">
      <input type="hidden" name="sk_id" value="<?= $sk['sk_id'] ?>">
      <table style="width:100%;">
        <tr>
          <td style="width:20%;"><label><b><u>Tanggal Rapor Mid</u></b>:</label></td>
          <td><input type="date" name="sk_mid" value="<?= $sk['sk_mid'] ?>"></td>
        </tr>
        <tr>
          <td><label><b><u>Tanggal Rapor Final</u></b>:</label></td>
          <td><input type="date" name="sk_fin" value="<?= $sk['sk_fin'] ?>"></td>
        </tr>
        <tr>
          <td>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Ubah
            </button>
          </td>
          <td></td>
        </tr>
      </table>
    </form>

  </div>
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
