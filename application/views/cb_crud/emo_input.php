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

            <?php echo '<div style="font-size:12px;" class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>INFO:</strong> Press SAVE button below
                </div>';


            function cetak_opt($nama, $dipilih)
            {
              $afek_nilai = ["A", "B", "C", "D"];
              $opt = "<select name=" . $nama . " style='font-size:12px;'>";
              $_s = "selected";
              for ($i = 4; $i >= 1; $i--) {
                if ($dipilih == $i) {
                  $opt .= "<option value='" . ($i) . "' " . $_s . ">" . $afek_nilai[4 - $i] . "</option>";
                } else {
                  $opt .= "<option value='" . ($i) . "'>" . $afek_nilai[4 - $i] . "</option>";
                }
              }
              $opt .= "</select>";
              echo $opt;
            }

            ?>

            <div id="notif"></div>

            <div style='text-align: center;'>
              <label><u>Indicator Emotional Awareness</u></label>
            </div>
            <table class="rapot mb-3">
              <thead>
                <tr>
                  <th>Indicator</th>
                  <th>Nama</th>
                  <th>Desc A</th>
                  <th>Desc B</th>
                  <th>Desc C</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>1</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['emo_ind_1'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_1a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_1b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_1c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>2</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['emo_ind_2'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_2a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_2b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_2c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>3</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['emo_ind_3'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_3a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_3b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['emo_ind_3c'] ?></td>
                </tr>
              </tbody>
            </table>


            <div style='text-align: center;'>
              <label><u>Indicator Spirituality</u></label>
            </div>
            <table class="rapot mb-3">
              <thead>
                <tr>
                  <th>Indicator</th>
                  <th>Nama</th>
                  <th>Desc A</th>
                  <th>Desc B</th>
                  <th>Desc C</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>1</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['spr_ind_1'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_1a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_1b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_1c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>2</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['spr_ind_2'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_2a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_2b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_2c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>3</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['spr_ind_3'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_3a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_3b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['spr_ind_3c'] ?></td>
                </tr>
              </tbody>
            </table>

            <form class="" action="<?= base_url('cb_CRUD/save_emo'); ?>" method="post">
              <table class="table table-bordered table-hover table-sm mr-5">
                <thead>
                  <tr>
                    <th style='font-size:12px;' rowspan="3">Num</th>
                    <th style='font-size:12px;' rowspan="3">Name</th>
                    <th style='font-size:12px;' class="text-center" colspan="6">Emotional Skill</th>
                    <th style='font-size:12px;' class="text-center" colspan="6">Spirituality</th>
                  </tr>
                  <tr>
                    <th style='font-size:12px;' class="text-center" colspan="3">Sem 1</th>
                    <th style='font-size:12px;' class="text-center" colspan="3">Sem 2</th>
                    <th style='font-size:12px;' class="text-center" colspan="3">Sem 1</th>
                    <th style='font-size:12px;' class="text-center" colspan="3">Sem 2</th>
                  </tr>
                  <tr>
                    <th style='font-size:12px;' class="text-center">Ind 1</th>
                    <th style='font-size:12px;' class="text-center">Ind 2</th>
                    <th style='font-size:12px;' class="text-center">Ind 3</th>
                    <th style='font-size:12px;' class="text-center">Ind 1</th>
                    <th style='font-size:12px;' class="text-center">Ind 2</th>
                    <th style='font-size:12px;' class="text-center">Ind 3</th>

                    <th style='font-size:12px;' class="text-center">Ind 1</th>
                    <th style='font-size:12px;' class="text-center">Ind 2</th>
                    <th style='font-size:12px;' class="text-center">Ind 3</th>
                    <th style='font-size:12px;' class="text-center">Ind 1</th>
                    <th style='font-size:12px;' class="text-center">Ind 2</th>
                    <th style='font-size:12px;' class="text-center">Ind 3</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                  foreach ($siswa_all as $m) :
                    ?>

                    <tr>
                      <td style='width:50px; font-size:11px;'>
                        <input type="hidden" value="<?= $m['d_s_id']; ?>" name="d_s_id[]">
                        <?= $m['sis_no_induk']; ?>
                      </td>
                      <td style='width:210px; font-size:12px;'> <?= $m['sis_nama_depan'] . " " . $m['sis_nama_bel']; ?> </td>

                      <td class="text-center"><?php cetak_opt("emo_aware_ex[]", $m['emo_aware_ex']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_so[]", $m['emo_aware_so']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ne[]", $m['emo_aware_ne']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ex2[]", $m['emo_aware_ex2']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_so2[]", $m['emo_aware_so2']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ne2[]", $m['emo_aware_ne2']); ?></td>


                      <td class="text-center"><?php cetak_opt("spirit_coping[]", $m['spirit_coping']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_emo[]", $m['spirit_emo']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_grate[]", $m['spirit_grate']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_coping2[]", $m['spirit_coping2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_emo2[]", $m['spirit_emo2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_grate2[]", $m['spirit_grate2']); ?></td>
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
