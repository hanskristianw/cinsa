<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
      <!-- Nested Row within Card Body -->

        <div class="p-2 text-center"><b><?= $this->session->flashdata('message'); ?></b></div>
        <div class="row">
          <div class="col-lg">
            <div class="p-5">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="<?= base_url('assets/img/profile/').$kr['kr_pp'] ?>" class="card-img">
                </div>
                <div class="col-md-8 p-3">
                  <div >
                    <table>
                      <tr>
                        <td><h5><b>Full name</b></h5></td>
                        <td><h5><b>&nbsp:&nbsp</b></h5></td>
                        <td class="p-1"><h5><?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'] ?></h5></td>
                      </tr>
                      <tr>
                        <td><h5><b>Unit</b></h5></td>
                        <td><h5><b>&nbsp:&nbsp</b></h5></td>
                        <td class="p-1"><h5><?= $kr['sk_nama'] ?></h5></td>
                      </tr>
                      <tr>
                        <td><h5><b>Department</b></h5></td>
                        <td><h5><b>&nbsp:&nbsp</b></h5></td>
                        <td class="p-1"><h5><?= $jabatan['jabatan_nama']?></h5></td>
                      </tr>
                      <tr>
                        <td><h5><b>User since</b></h5></td>
                        <td><h5><b>&nbsp:&nbsp</b></h5></td>
                        <td class="p-1"><h5><?= date('d F Y', $kr['kr_date_created']); ?></h5></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
