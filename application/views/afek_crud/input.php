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
            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>ALERT:</strong> No grade found, use SAVE BUTTON below to save grade
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

            <form class="" action="<?= base_url('Afek_CRUD/save_input'); ?>" method="post" id="formafek" >
              <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
              <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
              <input type="hidden" value="<?= $k_afek_id ?>" name="k_afek_id">
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th colspan="3">Week 1 <select class="form-control form-control-sm mb-2 option_minggu1" name="option_minggu1" id="option_minggu1">
                                                <option value="1">Active</option>
                                                <option value="0">Not Active</option>
                                            </select>
                    </th>
                    <th colspan="3">Week 2<select class="form-control form-control-sm mb-2 option_minggu2" name="option_minggu2" id="option_minggu2">
                                                <option value="1">Active</option>
                                                <option value="0">Not Active</option>
                                            </select>
                    </th>
                    <th colspan="3">Week 3<select class="form-control form-control-sm mb-2 option_minggu3" name="option_minggu3" id="option_minggu3">
                                                <option value="1">Active</option>
                                                <option value="0">Not Active</option>
                                            </select>
                    </th>
                    <th colspan="3">Week 4<select class="form-control form-control-sm mb-2 option_minggu4" name="option_minggu4" id="option_minggu4">
                                                <option value="1">Active</option>
                                                <option value="0">Not Active</option>
                                            </select>
                    </th>
                    <th colspan="3">Week 5<select class="form-control form-control-sm mb-2 option_minggu5" name="option_minggu5" id="option_minggu5">
                                                <option value="1">Active</option>
                                                <option value="0">Not Active</option>
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
                            <td colspan="18" align="center">
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
                      <?php
                        //minggu 1
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a1 $i' name='minggu1a1[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a2 $i' name='minggu1a2[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a3 $i' name='minggu1a3[]' value='1' min='1' max='3'></td>";

                        //minggu 2
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a1 $i' name='minggu2a1[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a2 $i' name='minggu2a2[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a3 $i' name='minggu2a3[]' value='1' min='1' max='3'></td>";

                        //minggu 3
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a1 $i' name='minggu3a1[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a2 $i' name='minggu3a2[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a3 $i' name='minggu3a3[]' value='1' min='1' max='3'></td>";

                        //minggu 4
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a1 $i' name='minggu4a1[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a2 $i' name='minggu4a2[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a3 $i' name='minggu4a3[]' value='1' min='1' max='3'></td>";

                        //minggu 5
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a1 $i' name='minggu5a1[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a2 $i' name='minggu5a2[]' value='1' min='1' max='3'></td>";
                        echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a3 $i' name='minggu5a3[]' value='1' min='1' max='3'></td>";

                      ?>
                      <td class="text-center">
                        <div class='t<?=$i?>'>

                        </div>
                      </td>
                    </tr>
                  <?php $i++; endforeach ?>
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
