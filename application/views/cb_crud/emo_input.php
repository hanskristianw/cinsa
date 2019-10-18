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
                      <tr><td><strong><u>Emotional Skill</u></strong></td> <td><strong><u>Spirituality</u></strong></td></tr>
                      <tr><td>Expressive</td><td>Coping Adversities</td></tr>
                      <tr><td>Self Control</td><td>Emotional Resilience</td></tr>
                      <tr><td>Negative Emotions</td><td>Grateful</td></tr>
                      <tr><td></td><td>Reflective</td></tr>
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

            <form class="" action="<?= base_url('cb_CRUD/save_emo'); ?>" method="post">
              <table class="table table-bordered table-hover table-sm mr-5">
                <thead>
                  <tr>
                    <th rowspan="3">Reg Num</th>
                    <th rowspan="3">Name</th>
                    <th class="text-center" colspan="6">Emotional Skill</th>
                    <th class="text-center" colspan="8">Spirituality</th>
                  </tr>
                  <tr>
                    <th class="text-center" colspan="3">Sem 1</th>
                    <th class="text-center" colspan="3">Sem 2</th>
                    <th class="text-center" colspan="4">Sem 1</th>
                    <th class="text-center" colspan="4">Sem 2</th>
                  </tr>
                  <tr>
                    <th class="text-center">Expr</th>
                    <th class="text-center">Self</th>
                    <th class="text-center">Neg</th>
                    <th class="text-center">Expr</th>
                    <th class="text-center">Self</th>
                    <th class="text-center">Neg</th>

                    <th class="text-center">Cop</th>
                    <th class="text-center">Emo</th>
                    <th class="text-center">Grate</th>
                    <th class="text-center">Refl</th>
                    <th class="text-center">Cop</th>
                    <th class="text-center">Emo</th>
                    <th class="text-center">Grate</th>
                    <th class="text-center">Refl</th>

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

                      <td class="text-center"><?php cetak_opt("emo_aware_ex[]",$m['emo_aware_ex']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_so[]",$m['emo_aware_so']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ne[]",$m['emo_aware_ne']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ex2[]",$m['emo_aware_ex2']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_so2[]",$m['emo_aware_so2']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ne2[]",$m['emo_aware_ne2']); ?></td>

                      
                      <td class="text-center"><?php cetak_opt("spirit_coping[]",$m['spirit_coping']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_emo[]",$m['spirit_emo']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_grate[]",$m['spirit_grate']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_ref[]",$m['spirit_ref']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_coping2[]",$m['spirit_coping2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_emo2[]",$m['spirit_emo2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_grate2[]",$m['spirit_grate2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_ref2[]",$m['spirit_ref2']); ?></td>
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
