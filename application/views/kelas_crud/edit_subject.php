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
                                    <th>Number of Teachers</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mapel_all as $m) : ?>
                                    <tr>
                                        <td><?= $m['mapel_sing'] ?></td>
                                        <td><?= $m['mapel_kkm'] ?></td>
                                        
                                        <form class="" action="<?= base_url('Kelas_CRUD/edit_subject') ?>" method="post">
                                            <td>
                                                <select name="jum_guru" id="jum_guru" class="form-control mb-2">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="form-group row">
                                                        <input type="hidden" name="mapel_id" value=<?= $m['mapel_id'] ?>>
                                                        <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                                                        <button type="submit" class="ml-3 btn btn-success">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                </div>
                                            </td>
                                        
                                        </form>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                        <hr>
                    </div>
                </div>
                <div class="col-lg-6">
                  <div class="text-center">
                        <h1 class="h4 text-gray-900 mt-4 mb-4">Subjects in <?= $kelas_all['kelas_nama']; ?></h1>
                  </div>
                  <div class="mb-3 pr-3 pl-3"><?= $this->session->flashdata('message'); ?></div>
                  <div class="col-sm mb-3 mb-sm-0 table-responsive">
                      <table class="table display compact table-hover dt">
                          <thead>
                              <tr>
                                  <th>Subject Name</th>
                                  <th>Teacher(s)/Hour(s)</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                                <?php 
                                    foreach ($d_mpl_all as $m) : 
                                        $count = 0;
                                ?>
                                  <tr>
                                      <td><?= $m['mapel_sing'] ?></td>
                                    
                                    <form class="" action="<?= base_url('Kelas_CRUD/save_teacher') ?>" method="post">
                                      <td>
                                        <input type="hidden" name="d_mpl_id" value= <?=$m['d_mpl_id']?>>
                                        <?php
                                            $guru_id = explode(",", $m['d_mpl_kr_id']);
                                            $beban = explode(",", $m['d_mpl_beban']);
                                            for($i=1;$i<=$m['jum_guru'];$i++){
                                        ?>
                                            <select name="kr_id[]" id="kr_id[]" class="form-control mb-2">
                                                <?php
                                                $_selected = $guru_id[$count];
                                                
                                                echo "<option value= '0'> Teacher ".$i."</option>";
                                                foreach ($guru_all as $n) :
                                                    if ($_selected == $n['kr_id']) {
                                                        $s = "selected";
                                                    } else {
                                                        $s = "";
                                                    }
                                                    echo "<option value=" . $n['kr_id'] . " " . $s . ">" . $n['kr_nama_depan'] . " " . $n['kr_nama_belakang'][0]."</option>";
                                                endforeach
                                                ?>
                                            </select>
                                            <input type="number" name="beban[]" class="form-control" min="0" placeholder="Hour" value=<?=$beban[$count]?>>
                                            <hr>
                                        <?php
                                                $count++;
                                            }
                                        ?>
                                      </td>
                                      <td>
                                          <div class="form-group row">
                                                  <input type="hidden" name="mapel_id" value=<?= $m['mapel_id'] ?>>
                                                  <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                                                  <div>
                                                    <button type="submit" class="ml-3 mt-4 btn btn-success">
                                                    <i class="fa fa-save"></i>
                                                    </button>
                                                  </div>
                                                  
                                    </form>
                                                  <div>
                                                    <form class="" action="<?= base_url('Kelas_CRUD/delete_subject') ?>" method="post">
                                                        <input type="hidden" name="d_mpl_id_delete" value= <?=$m['d_mpl_id']?>>
                                                        <input type="hidden" name="kelas_id" value=<?= $kelas_all['kelas_id']; ?>>
                                                        <button type="submit" class="ml-2 mt-4 btn btn-danger">
                                                        <i class="fa fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                  </div>
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