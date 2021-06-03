<style>
.grid-container {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 120px;
  padding-top: 50px;
}


.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.box2{
  /*align-self:start;*/
  grid-template-columns: 50% 50%;
}
</style>


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">

    <?php if($penilai_all): ?>
      <form class="user" id="frmTest" method="post" action="<?= base_url('Rekap_PA_jabatan/hasil'); ?>">

        <input type="hidden" name="kr_dinilai" value="<?= $dinilai ?>">
        <input type="hidden" name="t_id" value="<?= $t_id; ?>">
        <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_dinilai; ?>">

        <div class="card mt-4">
          <div class="card-header">
            <div class="text-center"><b><u>Pilih Penilai</u></b></div>
            <input class="checkAllpeni" id="checkAllpeni" type="checkbox">
            <label style="font-size:13px;" for="checkAllpeni"><b><u>Semua Penilai</u></b></label><br>

          </div>
          <div class="card-body">
            <?php foreach ($penilai_all as $p): ?>
              <input type=checkbox name="kr_penilai[]" class="penic" value="<?= $p['kr_id'] ?>" id="<?= $p['kr_id'] ?>">
              <label style="font-size:13px;" for="<?= $p['kr_id'] ?>"><?= $p['kr_nama_depan'].' '.$p['kr_nama_belakang'] ?></label><br>
            <?php endforeach; ?>
          </div>
        </div>
        <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
          Proses
        </button>

      </form>
    <?php else: ?>
      <h5 class="text-danger text-center mt-4">- Belum ada penilai -</h5>
    <?php endif; ?>

  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {

    $(".checkAllpeni").click(function () {
      $('input.penic:checkbox').not(this).prop('checked', this.checked);
    });

    $("#frmTest").submit(function(){
        var checked = $("#frmTest input.penic:checked").length > 0;
        if (!checked){
            alert("Pilih setidaknya 1 penilai");
            return false;
        }
    });

  });
</script>
