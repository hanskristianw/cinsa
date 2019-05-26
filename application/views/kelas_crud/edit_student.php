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
                                    <th>Student Name</th>
                                    <th>Reg Number</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sis_all as $m) : ?>
                                    <tr>
                                        <td><?= $m['sis_nama_depan'] ?> <?= $m['sis_nama_bel'] ?></td>
                                        <td><?= $m['sis_no_induk'] ?></td>
                                        <td><?= $m['t_nama'] ?></td>
                                        <td>
                                            <div class="form-group row">
                                                <form class="" action="<?= base_url('Kelas_CRUD/edit_student') ?>" method="post">
                                                    <input type="hidden" name="sis_id" value=<?= $m['sis_id'] ?>>
                                                    <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                                                    <button type="submit" class="ml-2 badge badge-success">
                                                        Add to <?= $kelas_all['kelas_nama']; ?>
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
                
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mt-4 mb-4">Student in <?= $kelas_all['kelas_nama']; ?></h1>
                    </div>
                    <div class="mb-3 pr-3 pl-3"><?= $this->session->flashdata('message'); ?></div>
                    <div class="col-sm mb-3 mb-sm-0 table-responsive">
                        <table class="table display compact table-hover dt">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Reg Number</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($d_s_all as $m) : ?>
                                    <tr>
                                        <td><?= $m['sis_nama_depan'] ?> <?= $m['sis_nama_bel'] ?></td>
                                        <td><?= $m['sis_no_induk'] ?></td>
                                        <td><?= $m['t_nama'] ?></td>
                                        <td>
                                            <div class="form-group row">
                                                <form class="" action="<?= base_url('Siswa_CRUD/update') ?>" method="post">
                                                    <input type="hidden" name="sis_id" value=<?= $m['sis_id'] ?>>
                                                    <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                                                    <button type="submit" class="ml-2 badge badge-danger">
                                                        Remove
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
            </div>
        </div>
    </div>

</div>