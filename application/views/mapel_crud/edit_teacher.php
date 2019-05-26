<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                
                <div class="col-lg-6">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mt-4 mb-4"><?= $title ?></h1>
                    </div>

                    <div class="col-sm mb-3 mb-sm-0 table-responsive">
                        <table class="table display compact table-hover dt">
                            <thead>
                                <tr>
                                    <th>Teacher Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kr_all as $m) : ?>
                                    <tr>
                                        <td><?= $m['kr_nama_depan'] ?> <?= $m['kr_nama_belakang'] ?></td>
                                        <td><?= $m['kr_st_id'] ?></td>
                                        <td>
                                            <div class="form-group row">
                                                <form class="" action="<?= base_url('Mapel_CRUD/edit_teacher') ?>" method="post">
                                                    <input type="hidden" name="kr_id" value=<?= $m['kr_id'] ?>>
                                                    <input type="hidden" name="mapel_id" value=<?= $mapel_id['mapel_id']; ?>>
                                                    <button type="submit" class="ml-2 badge badge-success">
                                                        Add teacher to <?= $mapel_id['mapel_nama']; ?>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                        <hr>
                    </div>
                </div>
                <div class="col-lg-6">
                
                    
                </div>
            </div>
        </div>
    </div>

</div>