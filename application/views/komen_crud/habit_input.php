<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900 mb-3"><b><u><?= $title ?></u></b></h4>
              <h4 class="h4 text-gray-900 mb-3"><b><u><?= $siswa_all[0]['kelas_nama'] ?></u></b></h4>
            </div>

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>INFO:</strong> Press SAVE button below
                </div>';

                echo '<div class="alert alert-success alert-dismissible fade show mt-3">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>

                    <table style="width: 100%;">
                      <tr><td><strong><u>Social Skill</u></strong></td> <td><strong><u>Physical Fitness<br>and Healthful Habit</u></strong></td></tr>
                      <tr><td>Relationship</td><td>Absent</td></tr>
                      <tr><td>Cooperation</td><td>UKS</td></tr>
                      <tr><td>Conflict</td><td>Tardy</td></tr>
                      <tr><td>Self-Appraisal</td></tr>
                    </table>
                </div>';
                    

                function cetak_opt($nama, $dipilih){
                  $afek_nilai = ["A","B","C","D"];
                  $opt = "<select name=".$nama.">";
                  $_s = "selected";
                  for($i=4;$i>=1;$i--){
                    if($dipilih == $i){
                      $opt .= "<option value='".($i)."' ".$_s.">".$afek_nilai[4-$i]."</option>";
                    }else{
                      $opt .= "<option value='".($i)."'>".$afek_nilai[4-$i]."</option>";
                    }
                  }
                  $opt .= "</select>";
                  echo $opt;
                }

            ?>

            <div id="notif"></div>

            <form class="" action="<?= base_url('Komen_CRUD/save_habit'); ?>" method="post">
              <table class="table table-bordered table-hover table-sm mr-5">
                <thead>
                  <tr>
                    <th rowspan="3">Reg Num</th>
                    <th rowspan="3">Name</th>
                    <th class="text-center" colspan="8">Social Skill</th>
                    <th class="text-center" colspan="8">Physical Fitness<br>and Healthful Habit</th>
                  </tr>
                  <tr>
                    <th class="text-center" colspan="4">Sem 1</th>
                    <th class="text-center" colspan="4">Sem 2</th>
                    <th class="text-center" colspan="3">Sem 1</th>
                    <th class="text-center" colspan="3">Sem 2</th>
                  </tr>
                  <tr>
                    <th class="text-center">Rel</th>
                    <th class="text-center">Coop</th>
                    <th class="text-center">Con</th>
                    <th class="text-center">Self</th>
                    <th class="text-center">Rel</th>
                    <th class="text-center">Coop</th>
                    <th class="text-center">Con</th>
                    <th class="text-center">Self</th>

                    <th class="text-center">Abst</th>
                    <th class="text-center">UKS</th>
                    <th class="text-center">Tardy</th>
                    <th class="text-center">Abst</th>
                    <th class="text-center">UKS</th>
                    <th class="text-center">Tardy</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                    foreach ($siswa_all as $m) :
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

                      <td class="text-center"><?php cetak_opt("ss_relationship[]",$m['ss_relationship']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_cooperation[]",$m['ss_cooperation']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_conflict[]",$m['ss_conflict']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_self_a[]",$m['ss_self_a']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_relationship2[]",$m['ss_relationship2']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_cooperation2[]",$m['ss_cooperation2']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_conflict2[]",$m['ss_conflict2']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_self_a2[]",$m['ss_self_a2']); ?></td>

                      
                      <td class="text-center"><?php cetak_opt("pfhf_absent[]",$m['pfhf_absent']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_uks[]",$m['pfhf_uks']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_tardiness[]",$m['pfhf_tardiness']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_absent2[]",$m['pfhf_absent2']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_uks2[]",$m['pfhf_uks2']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_tardiness2[]",$m['pfhf_tardiness2']); ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <button type="submit" class="btn btn-success mt-2" id="btn-save">
                  <i class="fa fa-save"></i>
                  Save
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
