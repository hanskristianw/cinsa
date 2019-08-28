<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Insert Character</h1>
                </div>

                <?= $this->session->flashdata('message'); ?>

                <form class="user" method="post" action="<?= base_url('Karakter_CRUD/add'); ?>">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="karakter_nama" name="karakter_nama" placeholder="Character Name (Ex: Integrity)" value="<?= set_value('karakter_nama') ?>">
                            <?= form_error('karakter_nama','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="number" class="form-control" id="karakter_urutan" name="karakter_urutan" placeholder="Character Order" value="<?= set_value('karakter_urutan') ?>">
                            <?= form_error('karakter_urutan','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                        <div class="mb-3">
                            <textarea type="text" rows="3" class="form-control" id="karakter_a" name="karakter_a" placeholder="Character Desc if A" value="<?= set_value('karakter_a') ?>"></textarea>
                            <?= form_error('karakter_a','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="mb-3">
                            <textarea type="text" rows="3" class="form-control" id="karakter_b" name="karakter_b" placeholder="Character Desc if B" value="<?= set_value('karakter_b') ?>"></textarea>
                            <?= form_error('karakter_b','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="mb-3">
                            <textarea type="text" rows="3" class="form-control" id="karakter_c" name="karakter_c" placeholder="Character Desc if C" value="<?= set_value('karakter_c') ?>"></textarea>
                            <?= form_error('karakter_c','<small class="text-danger pl-3">','</small>'); ?>
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
