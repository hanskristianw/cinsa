<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
                </div>
                
                <form class="user" method="post" action="<?php echo base_url('Sekolah_CRUD/update_unit_proses'); ?>">
                    
                    <input type="hidden" name="_id" value="<?= set_value('_id',$sk_update['sk_id']); ?>">
                    
                    <div class="form-group row">
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="sk_nama"><b><u>Name</u>:</b></label>
                            <input type="text" class="form-control" id="sk_nama" name="sk_nama" value="<?= $sk_update['sk_nama'] ?>" required>
                        </div>
                        <div class="col-sm mb-3 mb-sm-0">
                            <label for="sk_nickname"><b><u>Nickname</u>:</b></label>
                            <input type="text" class="form-control" id="sk_nickname" name="sk_nickname" value="<?= $sk_update['sk_nickname'] ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Update
                    </button>
                </form>
                <hr>
            </div>
            </div>
        </div>
        </div>
    </div>

</div>
