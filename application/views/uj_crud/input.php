<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Mid and Final Score <?= $kelas['kelas_nama'] . $mapel['mapel_nama'] ?></u></h1>
            </div>

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>ALERT:</strong> No grade found, use SAVE BUTTON below to save grade
                </div>'; ?>


            <form class="" action="<?= base_url('Uj_CRUD/save_input'); ?>" method="post" id="sub_uj" >
              <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
              <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
              <table class="table table-hover table-sm">
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
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
                    <td>Mid(%)</td>
                    <td>Final(%)</td>
                  </tr>
                  <?php
                    $opt = "";
                    for($i=0;$i<=100;$i++){
                        if($i!=50){
                          $opt .= "<option value='".$i."'>".$i."</option>";
                        }else{
                          $opt .= "<option value='".$i."' selected>".$i."</option>";
                        }
                    }
                  ?>

                  <tr>
                    <td><select name="uj_mid1_kog_persen" id="uj_mid1_kog_persen"><?= $opt ?></select></td>
                    <td><select name="uj_mid1_psi_persen" id="uj_mid1_psi_persen"><?= $opt ?></select></td>
                    <td><select name="uj_fin1_kog_persen" id="uj_fin1_kog_persen"><?= $opt ?></select></td>
                    <td><select name="uj_fin1_psi_persen" id="uj_fin1_psi_persen"><?= $opt ?></select></td>

                    <td><select name="uj_mid2_kog_persen" id="uj_mid2_kog_persen"><?= $opt ?></select></td>
                    <td><select name="uj_mid2_psi_persen" id="uj_mid2_psi_persen"><?= $opt ?></select></td>
                    <td><select name="uj_fin2_kog_persen" id="uj_fin2_kog_persen"><?= $opt ?></select></td>
                    <td><select name="uj_fin2_psi_persen" id="uj_fin2_psi_persen"><?= $opt ?></select></td>
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
                        <input type="hidden" value="<?= $m['sis_id']; ?>" name="sis_id[]">
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
              <button type="submit" class="btn btn-success mt-2">
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
