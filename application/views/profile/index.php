<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg">
            <div class="p-5">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="<?= base_url('assets/img/profile/').$kr['kr_pp'] ?>" class="card-img">
                </div>
                <div class="col-md-8 p-3">
                  <div >
                    <h5><b>Full name &nbsp: </b><?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'] ?></h5>
                    <h5><b>User since : </b> <?= date('d F Y', $kr['kr_date_created']); ?></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
