<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900"><b><u><?= $kelas['sk_nama'] ?></u></b></h4>
              <h4 class="h4 text-gray-900"><b><u>Mid and Final Score <?= $kelas['kelas_nama'] ?></u></b></h4>
              <h4 class="h4 text-gray-900 mb-4"><u><?= $mapel['mapel_nama'] ?></u></h4>
            </div>

            <?php 
            
              if(!empty($siswa_baru)):
                echo '<div class="alert alert-danger alert-dismissible fade show">
                          <button class="close" data-dismiss="alert" type="button">
                              <span>&times;</span>
                          </button>
                          <strong>ALERT:</strong> New student(s) in '.$kelas['kelas_nama'].' found!
                      </div>';
              
            ?>
              <form class="" action="<?= base_url('Uj_CRUD/save_new_student'); ?>" method="post" id="sub_uj" >
                <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
                <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
                <table class="table table-hover table-sm" style='font-size:14px;'>
                  <thead>
                    <tr>
                      <th rowspan="4">No</th>
                      <th rowspan="4">Name</th>
                      <th colspan="4">Semester 1</th>
                      <th colspan="4">Semester 2</th>
                    </tr>
                    <tr>
                      <td colspan="2">Cognitive</td>
                      <td colspan="2">Psychomotor</td>
                      <td colspan="2">Cognitive</td>
                      <td colspan="2">Psychomotor</td>
                    </tr>
                    <tr>
                      <td>Mid</td>
                      <td>Final</td>
                      <td>Mid</td>
                      <td>Final</td>
                      <td>Mid</td>
                      <td>Final</td>
                      <td>Mid</td>
                      <td>Final</td>
                    </tr>

                    <tr>
                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_mid1_kog_persen'] ?>" name="uj_mid1_kog_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_fin1_kog_persen'] ?>" name="uj_fin1_kog_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_mid1_psi_persen'] ?>" name="uj_mid1_psi_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_fin1_psi_persen'] ?>" name="uj_fin1_psi_persen"></td>

                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_mid2_kog_persen'] ?>" name="uj_mid2_kog_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_fin2_kog_persen'] ?>" name="uj_fin2_kog_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_mid2_psi_persen'] ?>" name="uj_mid2_psi_persen"></td>
                      <td><input type="hidden" value="<?= $siswa_all[1]['uj_fin2_psi_persen'] ?>" name="uj_fin2_psi_persen"></td>

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
                        <td><input type="number" onfocus='this.select();' required class='kin' style='width: 47px;' name="uj_mid1_kog[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin2' style='width: 47px;' name="uj_fin1_kog[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin3' style='width: 47px;' name="uj_mid1_psi[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin4' style='width: 47px;' name="uj_fin1_psi[]" value="0" max="100"></td>

                        <td><input type="number" onfocus='this.select();' required class='kin5' style='width: 47px;' name="uj_mid2_kog[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin6' style='width: 47px;' name="uj_fin2_kog[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin7' style='width: 47px;' name="uj_mid2_psi[]" value="0" max="100"></td>
                        <td><input type="number" onfocus='this.select();' required class='kin8' style='width: 47px;' name="uj_fin2_psi[]" value="0" max="100"></td>
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

            <form class="" action="<?= base_url('Uj_CRUD/save_update'); ?>" method="post" id="sub_uj" >
              <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
              <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">

              <table class="table table-hover table-sm" style='font-size:14px;'>
                <thead>
                  <tr>
                    <th rowspan="4">No</th>
                    <th rowspan="4">Name</th>
                    <th colspan="6">Semester 1</th>
                    <th colspan="6">Semester 2</th>
                  </tr>
                  <tr>
                    <td colspan="3">Cognitive</td>
                    <td colspan="3">Psychomotor</td>
                    <td colspan="3">Cognitive</td>
                    <td colspan="3">Psychomotor</td>
                  </tr>
                  <tr>
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
                    <td></td>
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
                    <td></td>
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
                    <td></td>
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
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
                    <td><select name="uj_mid1_kog_persen" id="uj_mid1_kog_persen"><?= returnSelected($siswa_all[1]['uj_mid1_kog_persen']) ?></select></td>
                    <td><select name="uj_fin1_kog_persen" id="uj_fin1_kog_persen"><?= returnSelected($siswa_all[1]['uj_fin1_kog_persen']) ?></select></td>
                    <td><b>Result</b></td>
                    <td><select name="uj_mid1_psi_persen" id="uj_mid1_psi_persen"><?= returnSelected($siswa_all[1]['uj_mid1_psi_persen']) ?></select></td>
                    <td><select name="uj_fin1_psi_persen" id="uj_fin1_psi_persen"><?= returnSelected($siswa_all[1]['uj_fin1_psi_persen']) ?></select></td>
                    <td><b>Result</b></td>

                    <td><select name="uj_mid2_kog_persen" id="uj_mid2_kog_persen"><?= returnSelected($siswa_all[1]['uj_mid2_kog_persen']) ?></select></td>
                    <td><select name="uj_fin2_kog_persen" id="uj_fin2_kog_persen"><?= returnSelected($siswa_all[1]['uj_fin2_kog_persen']) ?></select></td>
                    <td><b>Result</b></td>
                    <td><select name="uj_mid2_psi_persen" id="uj_mid2_psi_persen"><?= returnSelected($siswa_all[1]['uj_mid2_psi_persen']) ?></select></td>
                    <td><select name="uj_fin2_psi_persen" id="uj_fin2_psi_persen"><?= returnSelected($siswa_all[1]['uj_fin2_psi_persen']) ?></select></td>
                    <td><b>Result</b></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $ag_temp = "xxx";
                    $nomor = 1;
                    foreach ($siswa_all as $m) :
                  ?>

                    <input type="hidden" value="<?= $m['uj_mid1_kog_log'] ?>" name="uj_mid1_kog_log[]">
                    <input type="hidden" value="<?= $m['uj_mid1_psi_log'] ?>" name="uj_mid1_psi_log[]">
                    <input type="hidden" value="<?= $m['uj_fin1_kog_log'] ?>" name="uj_fin1_kog_log[]">
                    <input type="hidden" value="<?= $m['uj_fin1_psi_log'] ?>" name="uj_fin1_psi_log[]">
                    
                    <input type="hidden" value="<?= $m['uj_mid2_kog_log'] ?>" name="uj_mid2_kog_log[]">
                    <input type="hidden" value="<?= $m['uj_mid2_psi_log'] ?>" name="uj_mid2_psi_log[]">
                    <input type="hidden" value="<?= $m['uj_fin2_kog_log'] ?>" name="uj_fin2_kog_log[]">
                    <input type="hidden" value="<?= $m['uj_fin2_psi_log'] ?>" name="uj_fin2_psi_log[]">
                    <?php
                        if($cek_agama == 1){
                          $ag = $m['agama_nama'];
                          if($ag != $ag_temp){
                            echo '
                            <tr class="table-warning">
                              <td colspan="10" align="center">
                                <b>'.$ag.'</b>
                              </td>
                            </tr>';
                          }
                          $ag_temp = $ag;
                        }
                    ?>
                    <tr>
                      <td>
                        <input type="hidden" value="<?= $m['uj_id']; ?>" name="uj_id[]">
                        <?= $m['sis_no_induk']; ?>
                      </td>
                      <td style='width:250px;'>
                        <?php
                          echo $m['sis_nama_depan']." ".$m['sis_nama_bel'];
                        ?>
                      </td>
                      <td><input type="number" onfocus='this.select();' id="kin" required class='kin mk<?= $nomor ?>' style='width: 47px;' name="uj_mid1_kog[]" value="<?= $m['uj_mid1_kog'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' id="kin2" required class='kin2 fk<?= $nomor ?>' style='width: 47px;' name="uj_fin1_kog[]" value="<?= $m['uj_fin1_kog'] ?>" max="100"></td>
                      <td><div class='a<?= $nomor ?>'></div></td>
                      <td><input type="number" onfocus='this.select();' id="kin3" required class='kin3 mkx<?= $nomor ?>' style='width: 47px;' name="uj_mid1_psi[]" value="<?= $m['uj_mid1_psi'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' id="kin4" required class='kin4 fkx<?= $nomor ?>' style='width: 47px;' name="uj_fin1_psi[]" value="<?= $m['uj_fin1_psi'] ?>" max="100"></td>
                      <td><div class='b<?= $nomor ?>'></div></td>

                      <td><input type="number" onfocus='this.select();' id="kin5" required class='kin5 mkxy<?= $nomor ?>' style='width: 47px;' name="uj_mid2_kog[]" value="<?= $m['uj_mid2_kog'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' id="kin6" required class='kin6 fkxy<?= $nomor ?>' style='width: 47px;' name="uj_fin2_kog[]" value="<?= $m['uj_fin2_kog'] ?>" max="100"></td>
                      <td><div class='c<?= $nomor ?>'></td>
                      <td><input type="number" onfocus='this.select();' id="kin7" required class='kin7 mkxyz<?= $nomor ?>' style='width: 47px;' name="uj_mid2_psi[]" value="<?= $m['uj_mid2_psi'] ?>" max="100"></td>
                      <td><input type="number" onfocus='this.select();' id="kin8" required class='kin8 fkxyz<?= $nomor ?>' style='width: 47px;' name="uj_fin2_psi[]" value="<?= $m['uj_fin2_psi'] ?>" max="100"></td>
                      <td><div class='d<?= $nomor ?>'></td>
                    </tr>
                  <?php $nomor++; endforeach; ?>
                </tbody>
              </table>
              
              <?php
                if(!empty($siswa_baru)){
                  $dis = "disabled";
                }else{
                  $dis = "";
                }
              ?>

              <button type="submit" <?= $dis ?> class="btn btn-success mt-2">
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
