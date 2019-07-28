<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900"><b><u><?= $kelas['sk_nama'] ?></u></b></h4>
              <h4 class="h4 text-gray-900"><b><u>Affective <?= $kelas['kelas_nama'] ?></u></b></h4>
              <h4 class="h4 text-gray-900 mb-4"><i><?= $mapel['mapel_nama']." ".$k_afek['k_afek_topik_nama'] ?></i></h4>
              
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
              <form class="" action="<?= base_url('Afek_CRUD/save_new_student'); ?>" method="post" id="sub_uj" >
                <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
                <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
                <input type="hidden" value="<?= $k_afek_id ?>" name="k_afek_id">
                <table class="table table-hover table-sm">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th colspan="3">Week 1</th>
                      <th colspan="3">Week 2</th>
                      <th colspan="3">Week 3</th>
                      <th colspan="3">Week 4</th>
                      <th colspan="3">Week 5</th>
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
                      <?php
                        //minggu 1
                        if($siswa_all[0]['afektif_minggu1a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a1' name='minggu1a1[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a2' name='minggu1a2[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a3' name='minggu1a3[]' value='0' min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a1' name='minggu1a1[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a2' name='minggu1a2[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a3' name='minggu1a3[]' value='3' min='1' max='3'></td>";
                        }
                        //minggu 2
                        if($siswa_all[0]['afektif_minggu2a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a1' name='minggu2a1[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a2' name='minggu2a2[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a3' name='minggu2a3[]' value='0' min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a1' name='minggu2a1[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a2' name='minggu2a2[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a3' name='minggu2a3[]' value='3' min='1' max='3'></td>";
                        }
                        
                        //minggu 3
                        if($siswa_all[0]['afektif_minggu3a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu3 minggu3a1' name='minggu3a1[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu3 minggu3a2' name='minggu3a2[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu3 minggu3a3' name='minggu3a3[]' value='0' min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a1' name='minggu3a1[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a2' name='minggu3a2[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a3' name='minggu3a3[]' value='3' min='1' max='3'></td>";
                        }

                        //minggu 4
                        if($siswa_all[0]['afektif_minggu4a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu4 minggu4a1' name='minggu4a1[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu4 minggu4a2' name='minggu4a2[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu4 minggu4a3' name='minggu4a3[]' value='0' min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a1' name='minggu4a1[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a2' name='minggu4a2[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a3' name='minggu4a3[]' value='3' min='1' max='3'></td>";
                        }

                        //minggu 5
                        if($siswa_all[0]['afektif_minggu5a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu5 minggu5a1' name='minggu5a1[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu5 minggu5a2' name='minggu5a2[]' value='0' min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu5 minggu5a3' name='minggu5a3[]' value='0' min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a1' name='minggu5a1[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a2' name='minggu5a2[]' value='3' min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a3' name='minggu5a3[]' value='3' min='1' max='3'></td>";
                        }
                      ?>
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
            <?php echo '<div class="alert alert-primary alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <div class="text-center">
                    <strong>INFO:</strong> <br> A>=7.65 B>=6.3 C>=4.95 D<4.95 <br><br>
                    <strong>SCORE:</strong> <br>
                    1: '.$sk['sk_instruksi_afek1'].'<br>
                    2: '.$sk['sk_instruksi_afek2'].'<br>
                    3: '.$sk['sk_instruksi_afek3'].'

                    <br></br><strong>INDICATOR:</strong> <br>
                    1: '.$k_afek['k_afek_1'].'<br>
                    2: '.$k_afek['k_afek_2'].'<br>
                    3: '.$k_afek['k_afek_3'].'
                    </div>
                </div>'; ?>
            <div id="notif"></div>

            <?php

              function returnSelected($value) {
                $opt = "";
                if($value > 0){
                  $opt .= '<option value="1" selected>Active</option>
                          <option value="0">Not Active</option>';
                }else{
                  $opt .= '<option value="1">Active</option>
                          <option value="0" selected>Not Active</option>';
                }
                return $opt;
              }
            ?>

            <form class="" action="<?= base_url('Afek_CRUD/save_update'); ?>" method="post" id="formafek" >
              <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
              <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
              <input type="hidden" value="<?= $k_afek_id ?>" name="k_afek_id">
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th colspan="3">Week 1  <select class="form-control form-control-sm mb-2 option_minggu1" name="option_minggu1" id="option_minggu1">
                                              <?= returnSelected($siswa_all[1]['afektif_minggu1a1']); ?>
                                            </select>
                    </th>
                    <th colspan="3">Week 2<select class="form-control form-control-sm mb-2 option_minggu2" name="option_minggu2" id="option_minggu2">
                                              <?= returnSelected($siswa_all[1]['afektif_minggu2a1']); ?>
                                          </select>
                    </th>
                    <th colspan="3">Week 3<select class="form-control form-control-sm mb-2 option_minggu3" name="option_minggu3" id="option_minggu3">
                                              <?= returnSelected($siswa_all[1]['afektif_minggu3a1']); ?>
                                          </select>
                    </th>
                    <th colspan="3">Week 4<select class="form-control form-control-sm mb-2 option_minggu4" name="option_minggu4" id="option_minggu4">
                                              <?= returnSelected($siswa_all[1]['afektif_minggu4a1']); ?>
                                          </select>
                    </th>
                    <th colspan="3">Week 5<select class="form-control form-control-sm mb-2 option_minggu5" name="option_minggu5" id="option_minggu5">
                                              <?= returnSelected($siswa_all[1]['afektif_minggu5a1']); ?>
                                          </select>
                    </th>
                    <th style="vertical-align:top">Result</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    $ag_temp = "xxx";
                    $i = 1;
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
                        <input type="hidden" value="<?= $m['afektif_id'] ?>" name="afektif_id[]">
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
                      <?php
                        //minggu 1
                        if($m['afektif_minggu1a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a1 $i' name='minggu1a1[]' value=".$m['afektif_minggu1a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a2 $i' name='minggu1a2[]' value=".$m['afektif_minggu1a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu1 minggu1a3 $i' name='minggu1a3[]' value=".$m['afektif_minggu1a3']." min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a1 $i' name='minggu1a1[]' value=".$m['afektif_minggu1a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a2 $i' name='minggu1a2[]' value=".$m['afektif_minggu1a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a3 $i' name='minggu1a3[]' value=".$m['afektif_minggu1a3']." min='1' max='3'></td>";
                        }
                        

                        //minggu 2
                        if($m['afektif_minggu2a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu2 minggu2a1 $i' name='minggu2a1[]' value=".$m['afektif_minggu2a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu2 minggu2a2 $i' name='minggu2a2[]' value=".$m['afektif_minggu2a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu2 minggu2a3 $i' name='minggu2a3[]' value=".$m['afektif_minggu2a3']." min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a1 $i' name='minggu2a1[]' value=".$m['afektif_minggu2a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a2 $i' name='minggu2a2[]' value=".$m['afektif_minggu2a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a3 $i' name='minggu2a3[]' value=".$m['afektif_minggu2a3']." min='1' max='3'></td>";
                        }
                        

                        //minggu 3
                        if($m['afektif_minggu3a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu3 minggu3a1 $i' name='minggu3a1[]' value=".$m['afektif_minggu3a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu3 minggu3a2 $i' name='minggu3a2[]' value=".$m['afektif_minggu3a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu3 minggu3a3 $i' name='minggu3a3[]' value=".$m['afektif_minggu3a3']." min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a1 $i' name='minggu3a1[]' value=".$m['afektif_minggu3a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a2 $i' name='minggu3a2[]' value=".$m['afektif_minggu3a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a3 $i' name='minggu3a3[]' value=".$m['afektif_minggu3a3']." min='1' max='3'></td>";
                        }
                        

                        //minggu 4
                        if($m['afektif_minggu4a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu4 minggu4a1 $i' name='minggu4a1[]' value=".$m['afektif_minggu4a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu4 minggu4a2 $i' name='minggu4a2[]' value=".$m['afektif_minggu4a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu4 minggu4a3 $i' name='minggu4a3[]' value=".$m['afektif_minggu4a3']." min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a1 $i' name='minggu4a1[]' value=".$m['afektif_minggu4a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a2 $i' name='minggu4a2[]' value=".$m['afektif_minggu4a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a3 $i' name='minggu4a3[]' value=".$m['afektif_minggu4a3']." min='1' max='3'></td>";
                        }
                        

                        //minggu 5
                        if($m['afektif_minggu5a1'] == 0){
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu5 minggu5a1 $i' name='minggu5a1[]' value=".$m['afektif_minggu5a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu5 minggu5a2 $i' name='minggu5a2[]' value=".$m['afektif_minggu5a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' readonly required style='width: 32px;' class='minggu5 minggu5a3 $i' name='minggu5a3[]' value=".$m['afektif_minggu5a3']." min='1' max='3'></td>";
                        }else{
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a1 $i' name='minggu5a1[]' value=".$m['afektif_minggu5a1']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a2 $i' name='minggu5a2[]' value=".$m['afektif_minggu5a2']." min='1' max='3'></td>";
                          echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a3 $i' name='minggu5a3[]' value=".$m['afektif_minggu5a3']." min='1' max='3'></td>";
                        }
                        

                      ?>
                      <td class="text-center">
                        <div class='t<?=$i?>'>

                        </div>
                      </td>
                    </tr>
                  <?php $i++; endforeach ?>
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
