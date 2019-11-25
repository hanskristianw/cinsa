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
              <label><u>Indikator Sosial Skill</u></label>
            </div>
            <table class="rapot mb-3">
              <thead>
                <tr>
                  <th>Indikator</th>
                  <th>Nama</th>
                  <th>Desc A</th>
                  <th>Desc B</th>
                  <th>Desc C</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>1</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['ss_ind_1'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_1a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_1b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_1c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>2</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['ss_ind_2'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_2a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_2b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_2c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>3</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['ss_ind_3'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_3a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_3b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_3c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>4</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['ss_ind_4'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_4a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_4b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['ss_ind_4c'] ?></td>
                </tr>
              </tbody>
            </table>


            <div style='text-align: center;'>
              <label><u>Indikator Physical Fitness & Healthfull Habit</u></label>
            </div>
            <table class="rapot mb-3">
              <thead>
                <tr>
                  <th>Indikator</th>
                  <th>Nama</th>
                  <th>Desc A</th>
                  <th>Desc B</th>
                  <th>Desc C</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>1</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['pf_ind_1'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_1a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_1b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_1c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>2</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['pf_ind_2'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_2a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_2b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_2c'] ?></td>
                </tr>
                <tr>
                  <td style='padding: 0px 5px 0px 5px; width: 60px;'>3</td>
                  <td style='padding: 0px 5px 0px 5px; width: 150px;'><?= $emo_spr_desc['pf_ind_3'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_3a'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_3b'] ?></td>
                  <td style='padding: 0px 5px 0px 5px;'><?= $emo_spr_desc['pf_ind_3c'] ?></td>
                </tr>
              </tbody>
            </table>

            <form class="" action="<?= base_url('cb_CRUD/save_habit'); ?>" method="post">
              <table class="table table-bordered table-hover table-sm mr-5">
                <thead>
                  <tr>
                    <th style='font-size:12px;' rowspan="3">Num</th>
                    <th style='font-size:12px;' rowspan="3">Name</th>
                    <th style='font-size:12px;' class="text-center" colspan="8">
                      <a class='link-ss' href='javascript:void(0)'>Social Skill</a>
                    </th>
                    <th style='font-size:12px;' class="text-center" colspan="8"><a class='link-pf' href='javascript:void(0)'>Physical Fitness<br>and Healthful Habit</a></th>
                  </tr>
                  <tr>
                    <th style='font-size:12px;' class="text-center" colspan="4">Sem 1</th>
                    <th style='font-size:12px;' class="text-center" colspan="4">Sem 2</th>
                    <th style='font-size:12px;' class="text-center" colspan="3">Sem 1</th>
                    <th style='font-size:12px;' class="text-center" colspan="3">Sem 2</th>
                  </tr>
                  <tr>
                    <th style='font-size:12px;' class="text-center">Ind 1</th>
                    <th style='font-size:12px;' class="text-center">Ind 2</th>
                    <th style='font-size:12px;' class="text-center">Ind 3</th>
                    <th style='font-size:12px;' class="text-center">Ind 4</th>
                    <th style='font-size:12px;' class="text-center">Ind 1</th>
                    <th style='font-size:12px;' class="text-center">Ind 2</th>
                    <th style='font-size:12px;' class="text-center">Ind 3</th>
                    <th style='font-size:12px;' class="text-center">Ind 4</th>

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
                      <td style='width:210px; font-size:12px;'>
                        <?php
                          echo $m['sis_nama_depan'] . " " . $m['sis_nama_bel'];
                          ?>
                      </td>

                      <td class="text-center"><?php cetak_opt("ss_relationship[]", $m['ss_relationship']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_cooperation[]", $m['ss_cooperation']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_conflict[]", $m['ss_conflict']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_self_a[]", $m['ss_self_a']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_relationship2[]", $m['ss_relationship2']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_cooperation2[]", $m['ss_cooperation2']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_conflict2[]", $m['ss_conflict2']); ?></td>
                      <td class="text-center"><?php cetak_opt("ss_self_a2[]", $m['ss_self_a2']); ?></td>


                      <td class="text-center"><?php cetak_opt("pfhf_absent[]", $m['pfhf_absent']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_uks[]", $m['pfhf_uks']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_tardiness[]", $m['pfhf_tardiness']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_absent2[]", $m['pfhf_absent2']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_uks2[]", $m['pfhf_uks2']); ?></td>
                      <td class="text-center"><?php cetak_opt("pfhf_tardiness2[]", $m['pfhf_tardiness2']); ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <button type="submit" class="btn btn-sm btn-success mt-2" id="btn-save">
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
