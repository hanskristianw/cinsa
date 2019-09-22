<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u><?= $mapel['mapel_sing'] ?> Grade Report</u></h1>
            </div>


            <?= $this->session->flashdata('message'); ?>


                <?php
                  //var_dump($topik);
                  foreach ($topik as $m) :
                    $nilai = show_laporan($m['topik_id'],$kelas_id);
                    echo "<div class='mb-2'><b><u>".$nilai[0]['topik_nama']."</u></b></div>";
                ?>
                  <table class="rapot mb-4">
                    <thead>
                      <tr>
                        <th rowspan="2" style='width: 60px;'>Reg Number</th>
                        <th rowspan="2" style='width: 250px;'>Name</th>
                        <th colspan="3">Cognitive</th>
                        <th colspan="3">Psychomotor</th>
                      </tr>
                      <tr>
                        <th>Quiz(<?= $nilai[0]['kog_quiz_persen'] ?>%)</th>
                        <th>Test(<?= $nilai[0]['kog_test_persen'] ?>%)</th>
                        <th>Ass(<?= $nilai[0]['kog_ass_persen'] ?>%)</th>
                        <th>Quiz(<?= $nilai[0]['psi_quiz_persen'] ?>%)</th>
                        <th>Test(<?= $nilai[0]['psi_test_persen'] ?>%)</th>
                        <th>Ass(<?= $nilai[0]['psi_ass_persen'] ?>%)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($nilai as $n) :
                      ?>
                        <tr>
                          <td style='padding: 0px 0px 0px 5px;'><?= $n['sis_no_induk'] ?></td>
                          <td style='padding: 0px 0px 0px 5px;'><?= $n['sis_nama_depan'].' '.$n['sis_nama_bel'] ?></td>
                          <td style='text-align:center;'><?= $n['kog_quiz'] ?></td>
                          <td style='text-align:center;'><?= $n['kog_test'] ?></td>
                          <td style='text-align:center;'><?= $n['kog_ass'] ?></td>
                          <td style='text-align:center;'><?= $n['psi_quiz'] ?></td>
                          <td style='text-align:center;'><?= $n['psi_test'] ?></td>
                          <td style='text-align:center;'><?= $n['psi_ass'] ?></td>
                        </tr>
                      <?php
                        endforeach
                      ?>
                    </tbody>
                  </table>
                <?php
                  endforeach
                ?>

                <?php
                  if($ujian):
                ?>
                <div class='mb-2'><b><u>Mid and Final</u></b></div>
                <table class="rapot">
                  <thead>
                    <tr>
                      <th rowspan="4" style='width: 60px;'>Reg Number</th>
                      <th rowspan="4" style='width: 250px;'>Name</th>
                    </tr>
                    <tr>
                      <th colspan="4">Odd Semester</th>
                      <th colspan="4">Even Semester</th>
                    </tr>
                    <tr>
                      <th colspan="2">Mid</th>
                      <th colspan="2">Final</th>
                      <th colspan="2">Mid</th>
                      <th colspan="2">Final</th>
                    </tr>
                    <tr>
                      <th>Cog</th>
                      <th>Psy</th>
                      <th>Cog</th>
                      <th>Psy</th>

                      <th>Cog</th>
                      <th>Psy</th>
                      <th>Cog</th>
                      <th>Psy</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($ujian as $z) : ?>
                      <tr>
                        <td style='padding: 0px 0px 0px 5px;'><?= $z['sis_no_induk'] ?></td>
                        <td style='padding: 0px 0px 0px 5px;'><?= $z['sis_nama_depan'].' '.$z['sis_nama_bel'] ?></td>

                        <td style='text-align:center;'><?= $z['uj_mid1_kog'] ?></td>
                        <td style='text-align:center;'><?= $z['uj_mid1_psi'] ?></td>
                        <td style='text-align:center;'><?= $z['uj_fin1_kog'] ?></td>
                        <td style='text-align:center;'><?= $z['uj_fin1_psi'] ?></td>

                        <td style='text-align:center;'><?= $z['uj_mid2_kog'] ?></td>
                        <td style='text-align:center;'><?= $z['uj_mid2_psi'] ?></td>
                        <td style='text-align:center;'><?= $z['uj_fin2_kog'] ?></td>
                        <td style='text-align:center;'><?= $z['uj_fin2_psi'] ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
                <?php
                  endif;
                ?>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
