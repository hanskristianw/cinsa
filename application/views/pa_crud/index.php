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
    <form action="<?= base_url('PA_CRUD/add') ?>" method="post">
      <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_kpi_id ?>">
      <button type="submit" class="btn btn-primary mb-3">
        &plus; Kompetensi PA
      </button>
    </form>
  </div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">
    <table class="table table-bordered table-hover table-sm" style="font-size:14px;">
      <thead class="thead-dark">
        <tr>
          <th class="pt-4 pb-4 pl-2">Nama</th>
          <th class="pt-4 pb-4 pl-2">Indikator</th>
          <th class="pt-4 pb-4 pl-2 text-center" colspan="3" style="width:20%;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($kpi_all as $m) :
        ?>
          <tr>
            <td><?= $m['kompe_pa_nama'] ?></td>
            <td>
              <?php
                $indi = explode(";;",$m['indi_pa_nama']);
              ?>
                <?php
                  if($indi[0]):
                  foreach ($indi as $i):
                ?>
                    <li><?= $i ?></li>
                <?php
                  endforeach;
                  endif;
                ?>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('PA_CRUD/edit') ?>" method="post">
                <input type="hidden" name="kompe_pa_id" value=<?= $m['kompe_pa_id'] ?>>
                <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_kpi_id ?>">
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('PA_CRUD/add_indi') ?>" method="post">
                <input type="hidden" name="kompe_pa_id" value=<?= $m['kompe_pa_id'] ?>>
                <input type="hidden" name="jabatan_kpi_id" value="<?= $jabatan_kpi_id ?>">
                <button type="submit" class="badge badge-success">
                  Indikator
                </button>
              </form>
            </td>
            <td class="text-center">
              <form class="" action="<?= base_url('PA_CRUD/delete') ?>" method="post">
                <input type="hidden" name="kompe_pa_id" value=<?= $m['kompe_pa_id'] ?>>
                <button type="submit" class="badge badge-danger">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        <?php
        endforeach;
        ?>
      </tbody>
    </table>
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
