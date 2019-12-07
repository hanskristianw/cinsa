<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-lg-6">

        <div class="card o-hidden border-0 shadow-lg my-3">
          <div class="card-body p-2">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg">
                <div class="p-2">
                  <div class="text-center">
                    <h5 class="mb-3">Sistem Administrasi Sekolah</h5>
                    <hr>
                    <img src="<?= base_url('assets/img/profile/yppi.png'); ?>" class="mb-4 img-fluid rounded-circle" width="50%">
                  </div>

                  <div style='font-size:14px;'><?= $this->session->flashdata('message'); ?></div>

                  <form class="user" method="POST" action="<?= base_url('auth'); ?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="kr_username" name="kr_username" aria-describedby="emailHelp" placeholder="Enter Username..." value="<?= set_value('kr_username') ?>">
                      <?= form_error('kr_username','<small class="text-danger pl-3">','</small>'); ?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="kr_password" name="kr_password" placeholder="Password">
                      <?= form_error('kr_password','<small class="text-danger pl-3">','</small>'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                    <div class="text-center" style='font-size:13px;'>
                      &copy; 2018<script>new Date().getFullYear()>2010&&document.write("-"+new Date().getFullYear());</script>, Yayasan Pendidikan dan Pengajaran Indonesia.
                    </div>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

</div>
