<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                
                <div class="col-lg-6">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mt-4 mb-4">Available Subjects</h1>
                    </div>

                    <div class="col-sm mb-3 mb-sm-0 table-responsive">
                        <table class="table display compact table-hover dt">
                            <thead>
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Passing Grade</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mapel_all as $m) : ?>
                                    <tr>
                                        <td><?= $m['mapel_sing'] ?></td>
                                        <td><?= $m['mapel_kkm'] ?></td>
                                        <td>
                                            <div class="form-group row">
                                                <form class="" action="<?= base_url('Kelas_CRUD/edit_subject') ?>" method="post">
                                                    <input type="hidden" name="mapel_id" value=<?= $m['mapel_id'] ?>>
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
                        <h1 class="h4 text-gray-900 mt-4 mb-4">Subjects in class</h1>
                  </div>

                  <div class="col-sm mb-3 mb-sm-0 table-responsive">
                      <table class="table display compact table-hover dt">
                          <thead>
                              <tr>
                                  <th>Subject Name</th>
                                  <th>Teachers</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php foreach ($d_mpl_all as $m) : ?>
                                  <tr>
                                      <td><?= $m['mapel_nama'] ?></td>
                                      <td>
                                        <select name="kr_id" id="kr_id" class="form-control">
                                          <?php
                                          $_selected = set_value('kr_id');

                                          foreach ($guru_all as $n) :
                                            echo "<option value= '0'> Select 1st Teacher </option>";
                                            if ($_selected == $n['kr_id']) {
                                              $s = "selected";
                                            } else {
                                              $s = "";
                                            }
                                            echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . "</option>";
                                          endforeach
                                          ?>
                                        </select>
                                      </td>
                                      <td>
                                          <div class="form-group row">
                                              <form class="" action="<?= base_url('Kelas_CRUD/edit_subject') ?>" method="post">
                                                  <input type="hidden" name="d_mpl_mapel_id" value=<?= $m['d_mpl_mapel_id'] ?>>
                                                  <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                                                  <div>
                                                    <button type="submit" class="ml-2 badge badge-success">
                                                        Save Teacher
                                                    </button>
                                                  </div>
                                                  <div>
                                                    <button type="submit" class="ml-2 badge badge-danger">
                                                        Remove
                                                    </button>
                                                  </div>
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