<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900"><b><u><?= $kelas['sk_nama'] ?></u></b></h4>
              <h4 class="h4 text-gray-900"><b><u>Cognitive and Psychomotor <?= $kelas['kelas_nama'] ?></u></b></h4>
              <h4 class="h4 text-gray-900 mb-4"><i><?= $mapel['mapel_nama']." ".$topik['topik_nama']." Semester ".$topik['topik_semester'] ?></i></h4>
            </div>

            <div id="notif"></div>
            
            <?php 
            
              if(!empty($siswa_baru)):
                echo '<div class="alert alert-danger alert-dismissible fade show">
                          <button class="close" data-dismiss="alert" type="button">
                              <span>&times;</span>
                          </button>
                          <strong>ALERT:</strong> New student(s) in '.$kelas['kelas_nama'].' found!
                      </div>';
              
            ?>
              <form class="" action="<?= base_url('Tes_CRUD/save_new_student'); ?>" method="post" id="sub_uj" >
                <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
                <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
                <input type="hidden" value="<?= $topik_id ?>" name="topik_id">
                <table class="table table-hover table-sm" style='font-size:14px;'>
                  <thead>
                    <tr>
                      <th rowspan="4">No</th>
                      <th rowspan="4">Name</th>
                      <th colspan="3">Cognitive</th>
                      <th colspan="3">Psychomotor</th>
                    </tr>
                    <tr>
                      <td>Quiz(%)</td>
                      <td>Test(%)</td>
                      <td>Ass(%)</td>
                      <td>Quiz(%)</td>
                      <td>Test(%)</td>
                      <td>Ass(%)</td>
                    </tr>

                    <tr>
                      <td><input type="hidden" value="<?= $siswa_all[1]['kog_quiz_persen'] ?>" name="kog_quiz_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['kog_test_persen'] ?>" name="kog_test_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['kog_ass_persen'] ?>" name="kog_ass_persen"></td>

                      <td><input type="hidden" value="<?= $siswa_all[1]['psi_quiz_persen'] ?>" name="psi_quiz_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['psi_test_persen'] ?>" name="psi_test_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['psi_ass_persen'] ?>" name="psi_ass_persen"></td>

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
                        <td style='width:250px;'>
                          <?php
                          
                            echo $m['sis_nama_depan']." ".$m['sis_nama_bel'];
                          ?>
                        </td>
                        <td><input type="number" onfocus='this.select();' required class='kin' style='width: 47px;' name="kog_quiz[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin2' style='width: 47px;' name="kog_test[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin3' style='width: 47px;' name="kog_ass[]" value="0" max="100"></td>

                        <td><input type="number" onfocus='this.select();' required class='kin4' style='width: 47px;' name="psi_quiz[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin5' style='width: 47px;' name="psi_test[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin6' style='width: 47px;' name="psi_ass[]" value="0" max="100"></td>
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

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>UNTUK PENGISIAN RAPORT SISIPAN:</strong><br>
                    Hanya nilai 2 topik pertama pada semester yang sama yang muncul di sisipan, cek urutan di menu topik<br>
                    Persentase TIDAK berpengaruh di sisipan<br>
                    Isikan nilai 0 bagi siswa yang BELUM mengikuti tes <br>
                    Isikan nilai 0 juga bagi tes yang BELUM dilakukan atau MEMANG TIDAK ADA, misalnya nilai quiz psikomotor <br>
                    Isikan nilai -1 bagi siswa yang MENDAPAT 0 dikarenakan curang atau yang lainnya<br>
                </div>'; ?>

            <form class="" action="<?= base_url('Tes_CRUD/save_update'); ?>" method="post" id="sub_uj" >
              <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
              <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
              <input type="hidden" value="<?= $topik_id ?>" name="topik_id">
              <table class="table table-hover table-sm" style='font-size:14px;'>
                <thead>
                  <tr>
                    <th rowspan="4">No</th>
                    <th rowspan="4">Name</th>
                    <th colspan="4">Cognitive</th>
                    <th colspan="4">Psychomotor</th>
                  </tr>
                  <tr>
                    <td>Quiz(%)</td>
                    <td>Test(%)</td>
                    <td>Ass(%)</td>
                    <td></td>
                    <td>Quiz(%)</td>
                    <td>Test(%)</td>
                    <td>Ass(%)</td>
                    <td></td>
                  </tr>
                  <?php

                    function returnSelected($persen) {
                      $opt = "";
                      for($i=0;$i<=100;$i++){
                        if($i == $persen){
                          $opt .= "<option value='".$i."' selected>".$i."</option>";
                        }
                        else{
                          $opt .= "<option value='".$i."'>".$i."</option>";
                        }
                      }
                      return $opt;
                    }


                  ?>

                  <tr>
                    <td><select name="kog_quiz_persen" id="kog_quiz_persen"><?= returnSelected($siswa_all[1]['kog_quiz_persen']) ?></select></td>
                    <td><select name="kog_test_persen" id="kog_test_persen"><?= returnSelected($siswa_all[1]['kog_test_persen']) ?></select></td>
                    <td><select name="kog_ass_persen" id="kog_ass_persen"><?= returnSelected($siswa_all[1]['kog_ass_persen']) ?></select></td>
                    <td><b>Result</b></td>

                    <td><select name="psi_quiz_persen" id="psi_quiz_persen"><?= returnSelected($siswa_all[1]['psi_quiz_persen']) ?></select></td>
                    <td><select name="psi_test_persen" id="psi_test_persen"><?= returnSelected($siswa_all[1]['psi_test_persen']) ?></select></td>
                    <td><select name="psi_ass_persen" id="psi_ass_persen"><?= returnSelected($siswa_all[1]['psi_ass_persen']) ?></select></td>
                    <td><b>Result</b></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $ag_temp = "xxx";
                    $nomor = 1;
                    foreach ($siswa_all as $m) :
                  ?>

                    <?php
                        if($cek_agama == 1){
                          $ag = $m['agama_nama'];
                          if($ag != $ag_temp){
                            echo '
                            <tr class="table-warning">
                              <td colspan="8" align="center">
                                <b>'.$ag.'</b>
                              </td>
                            </tr>';
                          }
                          $ag_temp = $ag;
                        }
                    ?>
                    <tr>
                      <td>
                        <input type="hidden" value="<?= $m['tes_id']; ?>" name="tes_id[]">
                        <?= $m['sis_no_induk']; ?>
                      </td>
                      <td style='width:250px;'>
                        <?php
                          echo $m['sis_nama_depan']." ".$m['sis_nama_bel'];
                        ?>
                      </td>
                      <td><input type="number" onfocus='this.select();' required class='kin kq<?= $nomor ?>' style='width: 47px;' name="kog_quiz[]" value="<?= $m['kog_quiz'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required class='kin2 kt<?= $nomor ?>' style='width: 47px;' name="kog_test[]" value="<?= $m['kog_test'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required class='kin3 ka<?= $nomor ?>' style='width: 47px;' name="kog_ass[]" value="<?= $m['kog_ass'] ?>" max="100"></td>
                      <td><div class='r<?= $nomor ?>'></div></td>
                      
                      <td><input type="number" onfocus='this.select();' required class='kin5 pq<?= $nomor ?>' style='width: 47px;' name="psi_quiz[]" value="<?= $m['psi_quiz'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required class='kin6 pt<?= $nomor ?>' style='width: 47px;' name="psi_test[]" value="<?= $m['psi_test'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required class='kin7 pa<?= $nomor ?>' style='width: 47px;' name="psi_ass[]" value="<?= $m['psi_ass'] ?>" max="100"></td>
                      <td><div class='p<?= $nomor ?>'></div></td>
                     </tr>
                  <?php $nomor++;  endforeach; ?>
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
