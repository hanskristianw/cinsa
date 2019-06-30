<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">List of Class</h1>
            </div>


            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('kelas_crud/add') ?>" class="btn btn-primary mb-3">Add New Class</a>

            <table class="table display compact table-hover dt">
              <thead>
                <tr>
                  <th>List of Class</th>
                  <th>Abbr</th>
                  <th>Level</th>
                  <th>&Sigma; Students</th>
                  <th>Homeroom Teacher</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kelas_all as $m) : ?>
                  <tr>
                    <td><?= "<b>".$m['kelas_nama'] ."</b> (". $m['t_nama'] . ")" ?></td>
                    <td><?= "<b>".$m['kelas_nama_singkat'] ."</b>" ?></td>
                    <td><?= $m['jenj_nama'] ?></td>
                    <td><?= $m['jum_siswa'] ?></td>
                    <td>
                    
                        <form class="" action="<?= base_url('Kelas_CRUD/save_homeroom') ?>" method="post">
                          <select name="kelas_kr_id" id="kelas_kr_id" class="form-control mb-2">
                            <?php
                              $_selected = $m['kelas_kr_id'];
                              echo "<option value= '0'>No HR Teacher</option>";
                              foreach ($guru_all as $n) :
                                  if ($_selected == $n['kr_id']) {
                                      $s = "selected";
                                  } else {
                                      $s = "";
                                  }
                                  echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] ." ". $n['kr_nama_belakang'][0]. "</option>";
                              endforeach
                            ?>
                          </select>
                    </td>
                    <td>
                      <div class="form-group row ml-2">
                          <input type="hidden" name="kelas_id" value=<?= $m['kelas_id'] ?>>
                          <button type="submit" class="badge badge-dark">
                            Save HR Teacher
                          </button>
                        </form>
                        <form class="" action="<?= base_url('Kelas_CRUD/update') ?>" method="get">
                          <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                          <button type="submit" class="badge badge-warning">
                            Edit Class
                          </button>
                        </form>
                        <form class="" action="<?= base_url('Kelas_CRUD/edit_student') ?>" method="get">
                          <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                          <button type="submit" class="badge badge-success">
                            Edit Students
                          </button>
                        </form>
                        <form class="" action="<?= base_url('Kelas_CRUD/edit_subject') ?>" method="get">
                          <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                          <button type="submit" class="badge badge-primary">
                            Edit Subjects
                          </button>
                        </form>
                        <form class="" action="" method="post">
                          <input type="hidden" name="_id" value=<?= $m['kelas_id'] ?>>
                          <button type="submit" class="badge badge-danger">
                            Delete
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
