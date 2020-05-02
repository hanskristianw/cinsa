<style>
.grid-container {
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
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}
</style>


<div class="grid-container">
  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">

    <form class="" action="<?= base_url('Changelog_CRUD/save'); ?>" method="post">

      <label style="font-size:14px;"><b>Alert:</b></label>
      <select class="form-control form-control-sm mb-3" name="changelog_alert">
        <option value="success">Success</option>
        <option value="danger">Danger</option>
        <option value="warning">Warning</option>
      </select>

      <label style="font-size:14px;"><b>Badge:</b></label>
      <select class="form-control form-control-sm mb-3" name="changelog_jenis">
        <option value="Added">Added</option>
        <option value="Fixed">Fixed</option>
        <option value="Removed">Removed</option>
        <option value="Changed">Changed</option>
        <option value="Security">Security</option>
      </select>

      <label style="font-size:14px;"><b>Text:</b></label>
      <input type="text" class="form-control form-control-sm mb-3" name="changelog_text" value="" required>

      <label style="font-size:14px;"><b>Tanggal:</b></label>
      <input type="date" name="changelog_tgl" class="form-control form-control-sm" required>
      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Simpan
      </button>
    </form>
  </div>

</div>
