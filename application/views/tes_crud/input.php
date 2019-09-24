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

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>ALERT:</strong> No grade found, use SAVE BUTTON below to save grade
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
            
            <div id="notif"></div>

            <form class="" action="<?= base_url('Tes_CRUD/save_input'); ?>" method="post" id="formcogpsy" >
              <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
              <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
              <input type="hidden" value="<?= $topik_id ?>" name="topik_id">
              <table class="table table-hover table-sm">
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
                  <?php
                    $opt = "";
                    for($i=0;$i<=100;$i++){
                        if($i!=33){
                          $opt .= "<option value='".$i."'>".$i."</option>";
                        }else{
                          $opt .= "<option value='".$i."' selected>".$i."</option>";
                        }
                    }
                    $opt2 = "";
                    for($i=0;$i<=100;$i++){
                        if($i!=34){
                          $opt2 .= "<option value='".$i."'>".$i."</option>";
                        }else{
                          $opt2 .= "<option value='".$i."' selected>".$i."</option>";
                        }
                    }
                  ?>

                  <tr>
                    <td><select name="kog_quiz_persen" id="kog_quiz_persen"><?= $opt2 ?></select></td>
                    <td><select name="kog_test_persen" id="kog_test_persen"><?= $opt ?></select></td>
                    <td><select name="kog_ass_persen" id="kog_ass_persen"><?= $opt ?></select></td>

                    <td><select name="psi_quiz_persen" id="psi_quiz_persen"><?= $opt2 ?></select></td>
                    <td><select name="psi_test_persen" id="psi_test_persen"><?= $opt ?></select></td>
                    <td><select name="psi_ass_persen" id="psi_ass_persen"><?= $opt ?></select></td>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    $ag_temp = "xxx";
                    foreach ($siswa_all as $m) :

                      if($cek_agama == 1){
                        $ag = $m['agama_nama'];
                        if($ag != $ag_temp ){
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
              <button type="submit" class="btn btn-success mt-2" id="btn-save">
                  <i class="fa fa-save"></i>
                  Save All
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
