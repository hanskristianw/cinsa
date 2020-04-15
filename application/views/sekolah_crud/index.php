<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
            </div>

            <?php
            function returnTypeUnit($no)
            {
              if ($no == "0")
                return "School";
              else
                return "Management";
            }
            ?>

            <h4 class="text-center mb-3"><u>Daftar Unit</u></h4>
            <a href="<?= base_url('sekolah_crud/add') ?>" class="btn btn-primary mb-3">Tambah Unit</a>

            <?= $this->session->flashdata('message'); ?>

            <table class="table table-bordered table-hover table-sm" style="font-size:14px;">
              <thead class="thead-dark">
                <tr>
                  <th>Name</th>
                  <th>Principal</th>
                  <th>Mid<br>Report Date</th>
                  <th>Final<br>Report Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $temp = "";
                foreach ($sk_all as $m) :
                ?>

                  <?php if ($m['sk_type'] !== $temp) : ?>
                    <tr>
                      <td colspan="5" class="text-center bg-info text-white"><?= returnTypeUnit($m['sk_type']) ?></td>
                    </tr>
                  <?php endif; ?>
                  <tr>
                    <td><?= $m['sk_nama'] ?></td>
                    <?php if ($m['sk_type'] == 0) : ?>
                      <td><?= $m['kepsek'] ?></td>
                      <td><?= $m['sk_mid'] ?></td>
                      <td><?= $m['sk_fin'] ?></td>
                    <?php else : ?>
                      <td>-</td>
                      <td>-</td>
                      <td>-</td>
                    <?php endif; ?>
                    <td class="pl-3">
                      <div class="form-group row p-0 m-0">
                        <form class="" action="<?= base_url('Sekolah_CRUD/update') ?>" method="post">
                          <input type="hidden" name="_id" value=<?= $m['sk_id'] ?>>
                          <input type="hidden" name="sk_type" value=<?= $m['sk_type'] ?>>
                          <button type="submit" class="badge badge-warning">
                            Edit
                          </button>
                        </form>

                        <form class="" action="<?= base_url('Sekolah_CRUD/ttd_kepsek') ?>" method="post">
                          <input type="hidden" name="sk_id" value=<?= $m['sk_id'] ?>>
                          <button type="submit" class="badge badge-secondary">
                            Ttd Kepsek
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php
                  $temp = $m['sk_type'];
                endforeach;
                ?>
              </tbody>
            </table>

            <hr>
          </div>
        </div>
      </div>
    </div>
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