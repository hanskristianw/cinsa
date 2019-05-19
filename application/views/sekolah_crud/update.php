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
                
                <form class="user" method="post" action="<?php echo base_url('Sekolah_CRUD/update'); ?>">
                    
                    <input type="hidden" name="_id" value="<?= set_value('_id',$sk_update['sk_id']); ?>">
                    
                    <input type="hidden" name="is_update" value="1">
                    
                    <div class="form-group row">
                        <div class="col-sm mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="sk_nama" name="sk_nama" placeholder="School Name" value="<?= set_value('sk_nama',$sk_update['sk_nama']); ?>">
                            <?php echo form_error('sk_nama','<small class="text-danger pl-3">','</small>'); ?>
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
