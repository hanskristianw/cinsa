<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Insert Employee</h1>
                </div>
                <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control form-control-user" id="kr_nama_depan" name="kr_nama_depan" placeholder="First Name" value="<?= set_value('kr_nama_depan') ?>">
                            <?= form_error('kr_nama_depan','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-user" id="kr_nama_belakang" name="kr_nama_belakang" placeholder="Last Name" value="<?= set_value('kr_nama_belakang') ?>">
                            <?= form_error('kr_nama_belakang','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="kr_username" name="kr_username" placeholder="Username" value="<?= set_value('kr_username') ?>">
                        <?= form_error('kr_username','<small class="text-danger pl-3">','</small>'); ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user" id="kr_password1" name="kr_password1" placeholder="Password">
                            <?= form_error('kr_password1','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user" id="kr_password2" name="kr_password2" placeholder="Repeat Password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Insert
                    </button>
                </form>
                <hr>
            </div>
            </div>
        </div>
        </div>
    </div>

</div>
