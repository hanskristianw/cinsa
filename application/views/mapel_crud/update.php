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

                <form class="user" method="post" action="<?= base_url('Mapel_CRUD/update'); ?>">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="hidden" name="_id" value="<?= set_value('_id', $mapel_update['mapel_id']); ?>">
                            <input type="text" class="form-control" id="mapel_nama" name="mapel_nama" placeholder="Subject Name" value="<?= set_value('mapel_nama', $mapel_update['mapel_nama']) ?>">
                            <?= form_error('mapel_nama','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="number" class="form-control" id="mapel_kkm" name="mapel_kkm" placeholder="Passing Grade" value="<?= set_value('mapel_kkm', $mapel_update['mapel_kkm']) ?>">
                            <?= form_error('mapel_kkm','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="_mapel_urutan" name="_mapel_urutan" value="<?= set_value('_mapel_urutan', $mapel_update['mapel_urutan']) ?>">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="number" class="form-control" id="mapel_urutan" name="mapel_urutan" placeholder="Subject Order in Report Card" value="<?= set_value('mapel_urutan', $mapel_update['mapel_urutan']) ?>">
                            <?= form_error('mapel_urutan','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="mapel_sing" name="mapel_sing" placeholder="Abbreviation (ex: MAT, PE, ICT)" value="<?= set_value('mapel_sing', $mapel_update['mapel_sing']) ?>">
                            <?= form_error('mapel_sing','<small class="text-danger pl-3">','</small>'); ?>
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
