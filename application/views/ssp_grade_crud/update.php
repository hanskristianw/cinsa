<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900"><b><u>SSP GRADE (<?= $ssp_all['ssp_topik_nama'] ?>)</u></b></h4>
            </div>

            <div id="notif"></div>
            
            <?php 
            
              if(!empty($siswa_baru)):
                echo '<div class="alert alert-danger alert-dismissible fade show">
                          <button class="close" data-dismiss="alert" type="button">
                              <span>&times;</span>
                          </button>
                          <strong>ALERT:</strong> New student(s) found!
                      </div>';
              
            ?>
              <form class="" action="<?= base_url('SSP_grade_CRUD/save_new_student'); ?>" method="post" id="sub_uj" >
                <input type="hidden" value="<?= $ssp_topik_id ?>" name="ssp_topik_id">
                <table class="table table-hover table-sm">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Grade</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                      foreach ($siswa_baru as $m) :
                    ?>

                      <tr>
                        <td>
                          <input type="hidden" value="<?= $m['d_s_id']; ?>" name="d_s_id[]">
                          <?= $m['sis_no_induk']; ?>
                        </td>
                        <td>
                          <?php
                            if($m['sis_nama_bel']){
                              $bel = $m['sis_nama_bel'][0];
                            }else{
                              $bel = "";
                            }
                            echo $m['sis_nama_depan']." ".$bel;
                          ?>
                        </td>
                        <td>
                          <?= $m['kelas_nama']; ?>
                        </td>
                        <td>
                        <select name="ssp_nilai_angka[]" id="ssp_nilai_angka" class="form-control">
                          <option value="4">A</option>
                          <option value="3">B</option>
                          <option value="2">C</option>
                          <option value="1">D</option>
                        </select>
                      </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
                <button type="submit" class="btn btn-success mt-2 mb-3">
                    <i class="fa fa-save"></i>
                    Save New Student(s)
                </button>
              </form>    
            
              <hr>
            <?php endif; ?>

            <?php echo '<div class="alert alert-success alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>ALERT:</strong> Grade found, use UPDATE BUTTON below to save grade
                </div>'; ?>

            <form class="" action="<?= base_url('SSP_grade_CRUD/save_update'); ?>" method="post">
            
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Grade</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($siswa_all as $m) :
                  ?>
                    <tr>
                      <td>
                        <input type="hidden" value="<?= $m['ssp_nilai_id']; ?>" name="ssp_nilai_id[]">
                        <?= $m['sis_no_induk']; ?>
                      </td>
                      <td>
                        <?php
                          if($m['sis_nama_bel']){
                            $bel = $m['sis_nama_bel'][0];
                          }else{
                            $bel = "";
                          }
                          echo $m['sis_nama_depan']." ".$bel;
                        ?>
                      </td>
                      <td>
                        <?= $m['kelas_nama']; ?>
                      </td>
                      <td>
                        <select name="ssp_nilai_angka[]" id="ssp_nilai_angka" class="form-control">
                          <?php 
                            $j = 0;
                            $_selected = $m['ssp_nilai_angka'];
                            $s = "selected";
                            for($i=4;$i>=1;$i--){
                              if($_selected == $i){$s = "selected";}else{$s = "";}
                              echo '<option value="'.$i.'" '.$s.'>'.chr(65+$j).'</option>';
                              $j++;
                            }
                          ?>
                        </select>
                      </td>
                     </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              
              <?php
                if(!empty($siswa_baru)){
                  $dis = "disabled";
                }else{
                  $dis = "";
                }
              ?>

              <button type="submit" <?= $dis ?> class="btn btn-success mt-2" id="btn-save">
                  <i class="fa fa-save"></i>
                  Update All
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
