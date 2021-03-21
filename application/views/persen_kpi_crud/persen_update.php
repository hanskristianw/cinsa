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

  <div class="box1 text-center mt-4"><h4><u><?= $title .' '. $t_nama['t_nama']?> </u></h4></div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">
    <form class="" action="<?= base_url('Persen_KPI_CRUD/persen_update_proses'); ?>" method="post">

      <input type="hidden" name="persen_master_id" value="<?= $p_master['persen_master_id'] ?>">

      <b><u>Persentase KPI</u>:</b>
      <input type="number" name="persen_master_kpi" value="<?= $p_master['persen_master_kpi'] ?>" max="100" min="0" class="form-control form-control-sm mt-1 mb-2 kpi">

      <b><u>Persentase PA</u>:</b>
      <input type="number" name="persen_master_pa" value="<?= $p_master['persen_master_pa'] ?>" max="100" min="0" class="form-control form-control-sm mt-1 pa">

      <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
        Update
      </button>
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

    $(".pa").change(function() {
      $(".kpi").val(100-$(this).val());
    });

    $(".kpi").change(function() {
      $(".pa").val(100-$(this).val());
    });

  });
</script>
