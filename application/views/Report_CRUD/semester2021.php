<style>
.grid-logo {
  display: grid;
  grid-template-columns: 20% 80%;
  grid-column-gap: 2%;
  padding-right: 1%;
  margin-bottom: 30px;
}
</style>

<div class="container">


  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="alert alert-success alert-dismissible fade show mb-4">
              <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
              </button>

              <h4><u><b>Perhitungan nilai akhir</b></u></h4>
              <div style="font-family:Cambria, sans-serif;font-size:12px;" class="mb-2">* Masing - masing persentase mapel dapat diset secara dinamis oleh wakakur di menu master - percentage</div>

              <table>
                <tr>
                  <td><b>Formative</b></td>
                  <td>: SUM (Quiz x Persen, Tes x Persen, Ass x Persen) / jumlah topik terisi </td>
                </tr>
                <tr>
                  <td><b>Summative</b></td>
                  <td>: UTS x persentase + UAS x persentase </td>
                </tr>
                <tr>
                  <td><b>Nilai Kognitif</b></td>
                  <td>: (formative x % formative pengetahuan) + (summative x % summative pengetahuan)</td>
                </tr>
                <tr>
                  <td><b>Nilai Psikomotor</b></td>
                  <td>: (formative x % formative ketrampilan) + (summative x % summative ketrampilan)</td>
                </tr>
              </table>


            </div>

            <div class="alert alert-info alert-dismissible fade show">
              <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
              </button>
              <h4><u><b>Harap Diperhatikan:</b></u></h4>
              <ul>
                <li>Klik nilai cognitive, psychomotor untuk melihat detail perhitungan</li>
              </ul>
            </div>

            <div id="print_area">

              <?php
              function returnNamaSemester($angka)
              {
                if ($angka == 1)
                  return "1 (Odd)";
                else
                  return "2 (Even)";
              }

              function grading($grading_akhir)
              {
                if ($grading_akhir > 16)
                  return "EXCELLENT";
                elseif ($grading_akhir >= 11)
                  return "GOOD";
                elseif ($grading_akhir >= 0)
                  return "SATISFACTORY";
                elseif ($grading_akhir >= -10)
                  return "UNSATISFACTORY";
                else
                  return "POOR";
              }

              function return_her_him($jk)
              {
                if ($jk == 1)
                  return "him";
                elseif ($jk == 2)
                  return "her";
              }

              function return_his_her($jk)
              {
                if ($jk == 1)
                  return "his";
                elseif ($jk == 2)
                  return "her";
              }

              function return_he_she($jk)
              {
                if ($jk == 1)
                  return "he";
                elseif ($jk == 2)
                  return "she";
              }

              for ($i = 0; $i < count($sis_arr); $i++) :

                //echo $sis_arr[$i]."<br>".$kelas_jenj_id['kelas_jenj_id'];

                $tanggal_arr = explode('-', $kepsek['sk_fin']);
                $tahun = $tanggal_arr[0];
                $bulan = return_nama_bulan($tanggal_arr[1]);
                $tanggal = $tanggal_arr[2];
                $huruf = 66;

                $siswa = return_raport_fin($sis_arr[$i], $semester, $kelas_jenj_id['kelas_jenj_id'], $t_id);

                //var_dump($siswa);

                if (isset($siswa[0]['sis_nama_depan'])) :

              ?>
                  <div class="grid-logo mb-4">
                    <div style="text-align:center;">
                      <img src="<?= base_url('assets/img/') ?>nsa2.jpeg" alt="NSA Student"
                       style="opacity: 1; max-width: 60px;height: auto;-moz-border-radius: 0px;-webkit-border-radius: 0px;border-radius: 0px;">
                    </div>

                    <div style="text-align: left;" class="sekolah">
                      <div style="display: inline-block; text-align: center;">
                        <p class='judul mt-4'>NATION STAR ACADEMY <?= strtoupper($kepsek['sk_nickname']) ?><br>REPORT CARD</p>
                      </div>
                    </div>
                  </div>

                  <table class="atas" style="width:100%; margin-top: 30px;font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">
                    <tr>
                      <td style="width:10%">NAME</td>
                      <td style="width:60%;">: <?= $siswa[0]['sis_nama_depan'] . " " . $siswa[0]['sis_nama_bel'] ?></td>
                      <td style="width:10%">SEMESTER</td>
                      <td style="width:20%">: <?= returnNamaSemester($semester) ?></td>
                    </tr>
                    <tr>
                      <td>ID</td>
                      <td>: <?= $siswa[0]['sis_no_induk'] ?></td>
                      <td>YEAR</td>
                      <td>: <?= $t['t_nama'] ?></td>
                    </tr>
                    <tr>
                      <td>CLASS</td>
                      <td>: <?= $siswa[0]['kelas_nama'] ?> </td>
                      <?php
                          $program = explode(" ", $siswa[0]['kelas_nama']);
                          if (isset($program[1])) :
                            ?>
                        <td>PROGRAM</td>
                        <td>: <?= $program[1] ?></td>
                      <?php endif; ?>
                    </tr>
                  </table>

                  <hr style="height:5px; visibility:hidden;" />

                  <!-- HALAMAN 1 Kognitif Psikomotor -->

                  <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">A. AFFECTIVE</label>
                  <table class='rapot'>
                    <thead>
                      <tr>
                        <th style='width: 40px; height: 15px;'>NO </th>
                        <th style='width: 200px; height: 15px;'>ASPECT</th>
                        <th>GRADE</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <?php
                        $spirit_nilai = 0;
                        if ($semester == 1)
                          $spirit_nilai = $siswa[0]['spirit_sem1'];
                        elseif ($semester == 2)
                          $spirit_nilai = $siswa[0]['spirit_sem2'];
                        ?>
                        <td style='text-align: center;height: 20px;'>1</td>
                        <td style='padding: 0px 5px 0px 5px;height: 10px;'>Spirituality</td>
                        <td style='text-align: center;height: 10px;'><b><?= return_abjad_base4($spirit_nilai) ?></b></td>
                      </tr>
                      <tr>
                        <?php
                        $ss_nilai = 0;
                        if ($semester == 1)
                          $ss_nilai = $siswa[0]['ss_sem1'];
                        elseif ($semester == 2)
                          $ss_nilai = $siswa[0]['ss_sem2'];
                        ?>
                        <td style='text-align: center;height: 20px;'>2</td>
                        <td style='padding: 0px 5px 0px 5px;height: 10px;'>Social Skill</td>
                        <td style='text-align: center;height: 10px;'><b><?= return_abjad_base4($ss_nilai) ?></b></td>
                      </tr>
                    </tbody>
                  </table>
                  <hr style="height:5px; visibility:hidden;" />

                  <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">B. COGNITIVE AND PSYCHOMOTOR</label>
                  <table class='rapot'>
                    <thead>
                      <tr>
                        <th style='width:40px;' rowspan='2'>NO.</th>
                        <th style='width:200px;' rowspan='2'>SUBJECT</th>
                        <th style='width:60px;' rowspan='2'>PASSING <br>GRADE</th>
                        <th colspan='2'>Cognitive</th>
                        <th colspan='2'>Psychomotor</th>
                      </tr>
                      <tr>
                        <th>Score</th>
                        <th>Remarks</th>
                        <th>Score</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $nomor_hal1 = 1;
                      foreach ($siswa as $m) :
                      ?>
                        <tr>
                          <td class='nomor'><?= $nomor_hal1 ?></td>
                          <td style='padding: 0px 5px 0px 5px;height:10px;'><?= $m['mapel_nama'] ?></td>
                          <td class='kkm'><?= $m['mapel_kkm'] ?></td>

                          <?php
                          $for_kog = $m['for_kog'];
                          $for_psi = $m['for_psi'];
                          $sum_kog_sem1 = $m['sum_kog_sem1'];
                          $sum_psi_sem1 = $m['sum_psi_sem1'];
                          $sum_kog_sem2 = $m['sum_kog_sem2'];
                          $sum_psi_sem2 = $m['sum_psi_sem2'];

                          //PENGETAHUAN
                          //formative 70
                          if (isset($m['persen_forma_peng']))
                            $persen_forma_peng = $m['persen_forma_peng'];
                          else
                            $persen_forma_peng = 70;

                          //summative 30
                          if (isset($m['persen_summa_peng']))
                            $persen_summa_peng = $m['persen_summa_peng'];
                          else
                            $persen_summa_peng = 30;

                          //KETRAMPILAN
                          //formative 70
                          if (isset($m['persen_forma_ket']))
                            $persen_forma_ket = $m['persen_forma_ket'];
                          else
                            $persen_forma_ket = 70;

                          //summative 30
                          if (isset($m['persen_summa_ket']))
                            $persen_summa_ket = $m['persen_summa_ket'];
                          else
                            $persen_summa_ket = 30;

                          //AKHIR
                          //pengetahuan 50 ketrampilan 50
                          if (isset($m['persen_peng_akhir']))
                            $persen_peng_akhir = $m['persen_peng_akhir'];
                          else
                            $persen_peng_akhir = 50;

                          if (isset($m['persen_ket_akhir']))
                            $persen_ket_akhir = $m['persen_ket_akhir'];
                          else
                            $persen_ket_akhir = 50;

                          if ($semester == 1) {
                            $kognitif = round($for_kog * $persen_forma_peng / 100 + $sum_kog_sem1 * $persen_summa_peng / 100);
                            $psikomotor = round($for_psi * $persen_forma_ket / 100 + $sum_psi_sem1 * $persen_summa_ket / 100);

                            $n_akhir = round($kognitif * $persen_peng_akhir / 100 + $psikomotor * $persen_ket_akhir / 100);
                          } elseif ($semester == 2) {
                            $kognitif = round($for_kog * $persen_forma_peng / 100 + $sum_kog_sem2 * $persen_summa_peng / 100);
                            $psikomotor = round($for_psi * $persen_forma_ket / 100 + $sum_psi_sem2 * $persen_summa_ket / 100);

                            $n_akhir = round($kognitif * $persen_peng_akhir / 100 + $psikomotor * $persen_ket_akhir / 100);
                          }
                          ?>
                          <td class='biasa' style='width:50px;'>
                            <a class='link-kog' style="text-decoration : none; color: inherit;" rel="<?= $m['mapel_id'] ?>" rel2="<?= $sis_arr[$i] ?>" rel3="<?= $semester ?>" rel4="<?= $persen_forma_peng ?>" rel5="<?= $persen_summa_peng ?>" href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                              <?= $kognitif ?>
                            </a>
                          </td>
                          <td class='biasa' style="padding: 0px 5px 0px 5px;"><?= grading($kognitif - $m['mapel_kkm']) ?></td>
                          <td class='biasa' style='width:50px;'>
                            <a class='link-psi' style="text-decoration : none; color: inherit;" rel="<?= $m['mapel_id'] ?>" rel2="<?= $sis_arr[$i] ?>" rel3="<?= $semester ?>" rel4="<?= $persen_forma_ket ?>" rel5="<?= $persen_summa_ket ?>" href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                              <?= $psikomotor ?>
                            </a>
                          </td>
                          <td class='biasa' style="padding: 0px 5px 0px 5px;"><?= grading($psikomotor - $m['mapel_kkm']) ?></td>
                        </tr>
                      <?php
                        $nomor_hal1++;
                      endforeach;
                      ?>
                    </tbody>
                  </table>

                  <?php if($ssphalaman == 1): ?>
                    <p style="page-break-after: always;">&nbsp;</p>
                  <?php endif; ?>

                  <?php
                  $ssp_siswa = returnNilaiSspFinal($sis_arr[$i], $semester);
                  $total = 0;
                  $nomor_hal2 = 1;
                  if ($ssp_siswa && $checkSsp) :
                    $huruf += 1;
                  ?>

                    <?php if($ssphalaman == 0): ?>
                      <hr style="height:5px; visibility:hidden;" />
                    <?php endif; ?>
                    <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;"><?= chr($huruf) ?>. <?= $kepsek['sk_ex_nama'] ?></label>

                    <table class='rapot'>
                      <thead>
                        <tr>
                          <th style='width: 40px;'>NO </th>
                          <th style='width: 200px;'>COURSE</th>
                          <th style='width: 60px;'>GRADE</th>
                          <th>COURSE UNIT</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $guru_ssp = returnGuruSsp($sis_arr[$i]);
                        foreach ($ssp_siswa as $m) :
                        ?>
                          <tr>
                            <td class='nomor'><?= $nomor_hal2 ?></td>
                            <td style='padding: 0px 5px 0px 5px;'><?= $m['ssp_topik_nama'] ?></td>
                            <td style='text-align: center;'><?= return_abjad_base4($m['ssp_nilai_angka']) ?></td>
                            <td style='padding: 0px 5px 0px 5px;'>
                              <?php
                              $total += $m['ssp_nilai_angka'];
                              if (return_abjad_base4($m['ssp_nilai_angka']) == "A") {
                                echo $m['ssp_topik_a'];
                              } elseif (return_abjad_base4($m['ssp_nilai_angka']) == "B") {
                                echo $m['ssp_topik_b'];
                              } elseif (return_abjad_base4($m['ssp_nilai_angka']) == "C") {
                                echo $m['ssp_topik_b'];
                              } else {
                                echo "-";
                              }
                              ?>
                            </td>
                          </tr>
                        <?php
                          $nomor_hal2++;
                        endforeach;
                        ?>
                      </tbody>
                    </table>

                    <?php if($ssphalaman == 1): ?>
                      <hr style="height:5px; visibility:hidden;" />
                    <?php endif; ?>

                  <?php
                  endif;
                  ?>

                  <?php if($ssphalaman == 0): ?>
                    <p style="page-break-after: always;">&nbsp;</p>
                  <?php endif; ?>

                  <!-- HALAMAN 2 CHARACTER BUILDING -->

                  <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;"><?= chr($huruf+1) ?>. CHARACTER BUILDING</label>

                  <table class='rapot'>
                    <thead>
                      <tr>
                        <th style='width: 40px; height: 15px; padding: 0px 0px 0px 0px;'>NO </th>
                        <th style='width: 200px; height: 15px; padding: 0px 0px 0px 5px;'>ASPECT</th>
                        <th style='width: 60px; height: 15px; padding: 0px 0px 0px 5px;'>GRADE</th>
                        <th style='height: 15px;'>DESCRIPTOR</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $siswa_karakter = returnNilaiKarakter($sis_arr[$i], $semester);
                      $nomor_karakter = 1;
                      foreach ($siswa_karakter as $k) :
                        if ($k['karakter_id']) :
                          $kata_karakter_afek = "";
                          if (return_abjad_afek($k['total']) == "A")
                            $kata_karakter_afek = $k['karakter_a'];
                          elseif (return_abjad_afek($k['total']) == "B")
                            $kata_karakter_afek = $k['karakter_b'];
                          elseif (return_abjad_afek($k['total']) == "C")
                            $kata_karakter_afek = $k['karakter_c'];
                      ?>
                          <tr>
                            <td style='text-align: center;'><?= $nomor_karakter ?></td>
                            <td style='padding: 5px 5px 5px 5px;'><?= ucfirst(strtolower($k['karakter_nama'])) ?></td>
                            <td style='text-align: center;'><?= return_abjad_afek($k['total']) ?></td>
                            <td style='padding: 5px 5px 5px 5px;'><?= ucfirst(strtolower($siswa[0]['sis_nama_depan'])) . " " . $kata_karakter_afek ?></td>
                          </tr>
                      <?php
                          $nomor_karakter++;
                        endif;
                      endforeach;
                      //$siswa_karakter = returnNilaiKarakter($sis_arr[$i],$semester);
                      ?>
                      <?php
                        $cb_siswa = returnNilaiCB($sis_arr[$i], $semester);
                        if ($cb_siswa) :
                      ?>
                        <?php
                          foreach ($cb_siswa as $m) :
                        ?>
                          <tr>
                            <td class='nomor'><?= $nomor_karakter ?></td>
                            <td style='padding: 0px 5px 0px 5px;'><?= $m['topik_cb_nama'] ?></td>
                            <td style='text-align: center;'><?= return_abjad_base4($m['nilai']) ?></td>
                            <td style='padding: 5px 5px 5px 5px;'>
                              <?php
                              $temp_desc_cb = "";
                              if (return_abjad_base4($m['nilai']) == "A") {
                                //rubah nama jadi nama siswa
                                $temp_desc_cb = str_replace("{s}", ucfirst(strtolower($siswa[0]['sis_nama_depan'])), $m['topik_cb_a']);

                                //rubah his her huruf kecil
                                $temp_desc_cb = str_replace("{his/her}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah his her huruf besar
                                $temp_desc_cb = str_replace("{HIS/HER}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah his her huruf kecil
                                $temp_desc_cb = str_replace("{her/his}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah his her huruf besar
                                $temp_desc_cb = str_replace("{HER/HIS}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);

                                //rubah he she huruf kecil
                                $temp_desc_cb = str_replace("{he/she}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah he she huruf besar
                                $temp_desc_cb = str_replace("{HE/SHE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah he she huruf kecil
                                $temp_desc_cb = str_replace("{she/he}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah he she huruf besar
                                $temp_desc_cb = str_replace("{SHE/HE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);

                                //rubah himher huruf kecil
                                $temp_desc_cb = str_replace("{her/him}", return_her_him($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah himher huruf besar
                                $temp_desc_cb = str_replace("{HER/HIM}", ucfirst(return_her_him($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah himher huruf kecil
                                $temp_desc_cb = str_replace("{him/her}", return_her_him($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah himher huruf besar
                                $temp_desc_cb = str_replace("{HIM/HER}", ucfirst(return_her_him($siswa[0]['sis_jk'])), $temp_desc_cb);

                                echo $temp_desc_cb;
                              } elseif (return_abjad_base4($m['nilai']) == "B") {
                                $temp_desc_cb = str_replace("{s}", ucfirst(strtolower($siswa[0]['sis_nama_depan'])), $m['topik_cb_b']);

                                //rubah his her huruf kecil
                                $temp_desc_cb = str_replace("{his/her}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah his her huruf besar
                                $temp_desc_cb = str_replace("{HIS/HER}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah his her huruf kecil
                                $temp_desc_cb = str_replace("{her/his}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah his her huruf besar
                                $temp_desc_cb = str_replace("{HER/HIS}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);

                                //rubah he she huruf kecil
                                $temp_desc_cb = str_replace("{he/she}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah he she huruf besar
                                $temp_desc_cb = str_replace("{HE/SHE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah he she huruf kecil
                                $temp_desc_cb = str_replace("{she/he}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah he she huruf besar
                                $temp_desc_cb = str_replace("{SHE/HE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);

                                //rubah herself himher huruf kecil
                                $temp_desc_cb = str_replace("{her/him}", return_her_him($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah herself himher huruf besar
                                $temp_desc_cb = str_replace("{HER/HIM}", ucfirst(return_her_him($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah himher huruf kecil
                                $temp_desc_cb = str_replace("{him/her}", return_her_him($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah himher huruf besar
                                $temp_desc_cb = str_replace("{HIM/HER}", ucfirst(return_her_him($siswa[0]['sis_jk'])), $temp_desc_cb);

                                echo $temp_desc_cb;
                              } elseif (return_abjad_base4($m['nilai']) == "C") {
                                $temp_desc_cb = str_replace("{s}", ucfirst(strtolower($siswa[0]['sis_nama_depan'])), $m['topik_cb_c']);

                                //rubah his her huruf kecil
                                $temp_desc_cb = str_replace("{his/her}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah his her huruf besar
                                $temp_desc_cb = str_replace("{HIS/HER}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah his her huruf kecil
                                $temp_desc_cb = str_replace("{her/his}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah his her huruf besar
                                $temp_desc_cb = str_replace("{HER/HIS}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);

                                //rubah he she huruf kecil
                                $temp_desc_cb = str_replace("{he/she}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah he she huruf besar
                                $temp_desc_cb = str_replace("{HE/SHE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah he she huruf kecil
                                $temp_desc_cb = str_replace("{she/he}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah he she huruf besar
                                $temp_desc_cb = str_replace("{SHE/HE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);

                                //rubah herself himher huruf kecil
                                $temp_desc_cb = str_replace("{her/him}", return_her_him($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah herself himher huruf besar
                                $temp_desc_cb = str_replace("{HER/HIM}", ucfirst(return_her_him($siswa[0]['sis_jk'])), $temp_desc_cb);
                                //rubah himher huruf kecil
                                $temp_desc_cb = str_replace("{him/her}", return_her_him($siswa[0]['sis_jk']), $temp_desc_cb);
                                //rubah himher huruf besar
                                $temp_desc_cb = str_replace("{HIM/HER}", ucfirst(return_her_him($siswa[0]['sis_jk'])), $temp_desc_cb);

                                echo $temp_desc_cb;
                              } else {
                                echo "-";
                              }
                              ?>
                            </td>
                          </tr>
                        <?php
                            $nomor_karakter++;
                          endforeach;
                        ?>

                      <?php
                      endif;
                      ?>

                    </tbody>
                  </table>

                  <p style="page-break-after: always;">&nbsp;</p>

                  <!-- HALAMAN 3 ATTENDANCE-->

                  <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;"><?= chr($huruf+2) ?>. ATTENDANCE RECORD</label>
                  <table class='rapot'>
                    <tbody>
                      <tr>
                        <td style='text-align: center; width: 40px; padding: 0px 0px 0px 0px;height: 15px;'>1</td>
                        <td style='width: 200px; padding: 0px 0px 0px 5px;height: 15px;'>Sick</td>
                        <?php
                        $sick = "";
                        if ($semester == 1)
                          $sick = $siswa[0]['d_s_sick'];
                        elseif ($semester == 2)
                          $sick = $siswa[0]['d_s_sick2'];

                        if ($sick == "0")
                          $sick = "-";
                        ?>
                        <td style='padding: 0px 0px 0px 10px;height: 15px;'><?= $sick ?> day(s)</td>
                      </tr>
                      <tr>
                        <td style='text-align: center;height: 15px;'>2</td>
                        <td style='padding: 0px 0px 0px 5px;height: 15px;'>Absent (Including Excuse)</td>
                        <?php
                        $absenin = "";
                        if ($semester == 1)
                          $absenin = $siswa[0]['d_s_absenin'];
                        elseif ($semester == 2)
                          $absenin = $siswa[0]['d_s_absenin2'];

                        if ($absenin == "0")
                          $absenin = "-";
                        ?>
                        <td style='padding: 0px 0px 0px 10px;height: 15px;'><?= $absenin ?> day(s)</td>
                      </tr>
                      <tr>
                        <td style='text-align: center;height: 15px;'>3</td>
                        <td style='padding: 0px 0px 0px 5px;height: 15px;'>Absent (Excluding Excuse)</td>
                        <?php
                        $absenex = "";
                        if ($semester == 1)
                          $absenex = $siswa[0]['d_s_absenex'];
                        elseif ($semester == 2)
                          $absenex = $siswa[0]['d_s_absenex2'];

                        if ($absenex == "0")
                          $absenex = "-";
                        ?>
                        <td style='padding: 0px 0px 0px 10px;height: 15px;'><?= $absenex ?> day(s)</td>
                      </tr>

                    </tbody>
                  </table>

                  <hr style="height:5px; visibility:hidden;" />

                  <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;"><?= chr($huruf+3) ?>. HOMEROOM TEACHER’S COMMENT</label>
                  <?php
                  $komen = "";
                  if ($semester == 1)
                    $komen = $siswa[0]['d_s_komen_sem'];
                  elseif ($semester == 2)
                    $komen = $siswa[0]['d_s_komen_sem2'];
                  ?>
                  <br>
                  <table class='rapot'>
                    <tbody>
                      <tr>
                        <td style="padding: 10px 5px 10px 5px;"><?= $komen ?></td>
                      </tr>
                    </tbody>
                  </table>

                  <?php if ($semester == 2) :

                    $kata = "";
                    if ($akhir == 1) {
                      if ($siswa[0]['d_s_naik'] == 1) {
                        $kata = "Retained in Grade " . $sekarang;
                      } else {
                        $kata = "PASS";
                      }
                    } else {
                      if ($siswa[0]['d_s_naik'] == 1) {
                        $kata = "Retained in Grade " . $sekarang;
                      } else {
                        $kata = "Promoted to Grade " . $nama_berikutnya;
                      }
                    }

                  ?>

                  <br><br>
                  <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;"><?= chr($huruf+4) ?>. NOTE</label>
                  <br>
                  <label style="font-weight:bold;font-family:Cambria, sans-serif;font-size:14px;padding: 0px 0px 0px 15px;"><?= $kata ?></label>

                  <?php endif; ?>
                  <br><br><br><br>



                  <div id='textbox'>
                    <p class='alignleft_bawah'>
                      <br><br><br>
                      Parents / Guardian<br><br><br><br><br><br>
                      ............................................
                    </p>
                    <p class='alignright_bawah'>
                      <br>Surabaya, <?= $bulan . ' ' . $tanggal . ', ' . $tahun ?><br>
                      Homeroom Teacher,<br><br><br><br><br><br>
                      <b><?= $walkel['kr_gelar_depan'] . $walkel['kr_nama_depan'] . ' ' . $walkel['kr_nama_belakang'] . " " . $walkel['kr_gelar_belakang'] ?></b><br>
                    </p>
                  </div>
                  <div style='clear: both;'></div>
                  <div id='textbox'>
                    <p class='aligncenter_bawah'>
                      Principal<br><br><br><br><br><br>
                      <b><?= $kepsek['kr_gelar_depan'] . $kepsek['kr_nama_depan'] . ' ' . $kepsek['kr_nama_belakang'] . " " . $kepsek['kr_gelar_belakang'] ?></b><br>
                    </p>
                  </div>

                  <p style="page-break-after: always;">&nbsp;</p>
              <?php
                endif;
              endfor;
              ?>
            </div>
            <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success" value="Print">
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<script type="text/javascript">
  $(document).ready(function() {

    $(".link-kog").on('click', function() {
      var mapel_id = $(this).attr("rel");
      var d_s_id = $(this).attr("rel2");
      var semester = $(this).attr("rel3");

      var persen_forma_peng = $(this).attr("rel4");
      var persen_summa_peng = $(this).attr("rel5");

      $("#judul_modal").html("Detail Nilai Pengetahuan");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      //alert(mapel_id);
      $.ajax({
        type: "post",
        url: base_url + "API/get_formative_by_mapel",
        data: {
          'mapel_id': mapel_id,
          'd_s_id': d_s_id,
          'semester': semester,
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
          } else {
            var html = '';
            var html2 = "";
            var i;
            html += "<label><u>Formative</u></label>"
            html += "<table class='rapot'>";
            html += "<tr>"
            html += "<th>Nama</th>";
            html += "<th>Quiz x %</th>";
            html += "<th>Test x %</th>";
            html += "<th>Ass x %</th>";
            html += "<th>Total</th>";
            html += "</tr>"
            var total_akhir = 0;
            for (i = 0; i < data.length; i++) {
              html += "<tr>"
              html += "<td style='width: 180px; padding: 0px 0px 0px 5px;'>" + data[i].topik_nama + "</td>";

              var total = 0;
              var hasil_quiz = data[i].kog_quiz * data[i].kog_quiz_persen / 100;
              var hasil_test = data[i].kog_test * data[i].kog_test_persen / 100;
              var hasil_ass = data[i].kog_ass * data[i].kog_ass_persen / 100;
              total += hasil_quiz + hasil_test + hasil_ass;
              var roundtotal = Math.round(total);
              total_akhir += roundtotal;
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].kog_quiz + "x" + data[i].kog_quiz_persen / 100 + " = " + hasil_quiz + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].kog_test + "x" + data[i].kog_test_persen / 100 + " = " + hasil_test + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].kog_ass + "x" + data[i].kog_ass_persen / 100 + " = " + hasil_ass + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + total + "~ " + roundtotal + "</td>";
              html += "</tr>"
            }

            var total_akhir_forma = total_akhir / data.length;
            var roundtotal_akhir_forma = Math.round(total_akhir_forma);

            html += "<tr>"
            html += "<td style='padding: 0px 0px 0px 5px;'>Formative</td>";
            html += "<td colspan='4' style='padding: 0px 0px 0px 5px;'>" + total_akhir_forma + "~ " + roundtotal_akhir_forma + "</td>";
            html += "</tr>"
            html += "</table>";

            $.ajax({
              type: "post",
              url: base_url + "API/get_summative_by_mapel",
              data: {
                'mapel_id': mapel_id,
                'd_s_id': d_s_id,
              },
              async: true,
              dataType: 'json',
              success: function(data) {
                if (data.length == 0) {
                  html2 += '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
                } else {
                  var i;
                  html2 += "<label class='mt-3'><u>Summative</u></label>"
                  html2 += "<table class='rapot'>";
                  html2 += "<tr>"
                  html2 += "<th>PTS x %</th>";
                  html2 += "<th>PAS x %</th>";
                  html2 += "</tr>"
                  var total_akhir_sum = 0;
                  for (i = 0; i < data.length; i++) {
                    if (semester == 1) {
                      var hasil_pts = data[i].uj_mid1_kog * data[i].uj_mid1_kog_persen / 100;
                      var hasil_pas = data[i].uj_fin1_kog * data[i].uj_fin1_kog_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid1_kog + "x" + data[i].uj_mid1_kog_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin1_kog + "x" + data[i].uj_fin1_kog_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    } else if (semester == 2) {
                      var hasil_pts = data[i].uj_mid2_kog * data[i].uj_mid2_kog_persen / 100;
                      var hasil_pas = data[i].uj_fin2_kog * data[i].uj_fin2_kog_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid2_kog + "x" + data[i].uj_mid2_kog_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin2_kog + "x" + data[i].uj_fin2_kog_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    }

                  }

                  total_akhir_sum = hasil_pts + hasil_pas;

                  var roundtotal_akhir_sum = Math.round(total_akhir_sum);
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>Total</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + total_akhir_sum + " ~" + roundtotal_akhir_sum + "</td>";
                  html2 += "</tr>"

                  html2 += "</table>";

                  var akhir_kognitif = roundtotal_akhir_forma * persen_forma_peng / 100 + roundtotal_akhir_sum * persen_summa_peng / 100;
                  var akhir_forma = roundtotal_akhir_forma * persen_forma_peng / 100;
                  var akhir_summa = roundtotal_akhir_sum * persen_summa_peng / 100;

                  var roundakhir_kognitif = Math.round(akhir_kognitif);

                  html2 += "<table class='rapot mt-3'>";
                  html2 += "<tr>"
                  html2 += "<th>"
                  html2 += "Formative x % formative"
                  html2 += "</th>"
                  html2 += "<th>"
                  html2 += "Summative x % Summative"
                  html2 += "</th>"
                  html2 += "</tr>"
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_forma + "x" + persen_forma_peng / 100 + "= " + akhir_forma + "</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_sum + "x" + persen_summa_peng / 100 + "= " + akhir_summa + "</td>";
                  html2 += "</tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;' colspan='2'>Nilai Akhir Kognitif: " + akhir_kognitif + " ~" + roundakhir_kognitif + "</td>";
                  html2 += "</tr>"
                  html2 += "</table>";
                }

                //console.log(html2);

                $('#isi_modal').html(html + html2);
                $("#myModal").show();
              }
            });
          }
        }
      });
    });

    $(".link-psi").on('click', function() {
      var mapel_id = $(this).attr("rel");
      var d_s_id = $(this).attr("rel2");
      var semester = $(this).attr("rel3");

      var persen_forma_ket = $(this).attr("rel4");
      var persen_summa_ket = $(this).attr("rel5");

      $("#judul_modal").html("Detail Nilai Ketrampilan");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      //alert(mapel_id);
      $.ajax({
        type: "post",
        url: base_url + "API/get_formative_by_mapel",
        data: {
          'mapel_id': mapel_id,
          'd_s_id': d_s_id,
          'semester': semester,
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
          } else {
            var html = '';
            var html2 = "";
            var i;
            html += "<label><u>Formative</u></label>"
            html += "<table class='rapot'>";
            html += "<tr>"
            html += "<th>Nama</th>";
            html += "<th>Quiz x %</th>";
            html += "<th>Test x %</th>";
            html += "<th>Ass x %</th>";
            html += "<th>Total</th>";
            html += "</tr>"
            var total_akhir = 0;
            for (i = 0; i < data.length; i++) {
              html += "<tr>"
              html += "<td style='width: 180px; padding: 0px 0px 0px 5px;'>" + data[i].topik_nama + "</td>";

              var total = 0;
              var hasil_quiz = data[i].psi_quiz * data[i].psi_quiz_persen / 100;
              var hasil_test = data[i].psi_test * data[i].psi_test_persen / 100;
              var hasil_ass = data[i].psi_ass * data[i].psi_ass_persen / 100;
              total += hasil_quiz + hasil_test + hasil_ass;
              var roundtotal = Math.round(total);
              total_akhir += roundtotal;
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].psi_quiz + "x" + data[i].psi_quiz_persen / 100 + " = " + hasil_quiz + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].psi_test + "x" + data[i].psi_test_persen / 100 + " = " + hasil_test + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].psi_ass + "x" + data[i].psi_ass_persen / 100 + " = " + hasil_ass + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + total + "~ " + roundtotal + "</td>";
              html += "</tr>"
            }

            var total_akhir_forma = total_akhir / data.length;
            var roundtotal_akhir_forma = Math.round(total_akhir_forma);

            html += "<tr>"
            html += "<td style='padding: 0px 0px 0px 5px;'>Formative</td>";
            html += "<td colspan='4' style='padding: 0px 0px 0px 5px;'>" + total_akhir_forma + "~ " + roundtotal_akhir_forma + "</td>";
            html += "</tr>"
            html += "</table>";

            $.ajax({
              type: "post",
              url: base_url + "API/get_summative_by_mapel",
              data: {
                'mapel_id': mapel_id,
                'd_s_id': d_s_id,
              },
              async: true,
              dataType: 'json',
              success: function(data) {
                if (data.length == 0) {
                  html2 += '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
                } else {
                  var i;
                  html2 += "<label class='mt-3'><u>Summative</u></label>"
                  html2 += "<table class='rapot'>";
                  html2 += "<tr>"
                  html2 += "<th>PTS x %</th>";
                  html2 += "<th>PAS x %</th>";
                  html2 += "</tr>"
                  var total_akhir_sum = 0;
                  for (i = 0; i < data.length; i++) {
                    if (semester == 1) {
                      var hasil_pts = data[i].uj_mid1_psi * data[i].uj_mid1_psi_persen / 100;
                      var hasil_pas = data[i].uj_fin1_psi * data[i].uj_fin1_psi_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid1_psi + "x" + data[i].uj_mid1_psi_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin1_psi + "x" + data[i].uj_fin1_psi_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    } else if (semester == 2) {
                      var hasil_pts = data[i].uj_mid2_psi * data[i].uj_mid2_psi_persen / 100;
                      var hasil_pas = data[i].uj_fin2_psi * data[i].uj_fin2_psi_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid2_psi + "x" + data[i].uj_mid2_psi_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin2_psi + "x" + data[i].uj_fin2_psi_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    }

                  }

                  total_akhir_sum = hasil_pts + hasil_pas;

                  var roundtotal_akhir_sum = Math.round(total_akhir_sum);
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>Total</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + total_akhir_sum + " ~" + roundtotal_akhir_sum + "</td>";
                  html2 += "</tr>"

                  html2 += "</table>";

                  var akhir_kognitif = roundtotal_akhir_forma * persen_forma_ket / 100 + roundtotal_akhir_sum * persen_summa_ket / 100;
                  var akhir_forma = roundtotal_akhir_forma * persen_forma_ket / 100;
                  var akhir_summa = roundtotal_akhir_sum * persen_summa_ket / 100;

                  var roundakhir_kognitif = Math.round(akhir_kognitif);

                  html2 += "<table class='rapot mt-3'>";
                  html2 += "<tr>"
                  html2 += "<th>"
                  html2 += "Formative x % formative"
                  html2 += "</th>"
                  html2 += "<th>"
                  html2 += "Summative x % Summative"
                  html2 += "</th>"
                  html2 += "</tr>"
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_forma + "x" + persen_forma_ket / 100 + "= " + akhir_forma + "</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_sum + "x" + persen_summa_ket / 100 + "= " + akhir_summa + "</td>";
                  html2 += "</tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;' colspan='2'>Nilai Akhir Psychomotor: " + akhir_kognitif + " ~" + roundakhir_kognitif + "</td>";
                  html2 += "</tr>"
                  html2 += "</table>";
                }

                //console.log(html2);

                $('#isi_modal').html(html + html2);
                $("#myModal").show();
              }
            });
          }
        }
      });
    });

    $(".link-akhir").on('click', function() {
      var kog = $(this).attr("rel");
      var psi = $(this).attr("rel2");
      var persen_kog = $(this).attr("rel3");
      var persen_psi = $(this).attr("rel4");

      //alert("aaaa");
      var html = '';
      $("#judul_modal").html("Detail Nilai Akhir");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      //alert(mapel_id);
      html += "<label><u>Nilai Akhir</u></label>"
      html += "<table class='rapot'>";
      html += "<tr>"
      html += "<th>Cognitive x % Cog</th>";
      html += "<th>Psychomotor x % Psy</th>";
      html += "<th>NA</th>";
      html += "</tr>"
      html += "<tr>"

      var akhir_kog = kog * (persen_kog / 100);
      var akhir_psi = psi * (persen_psi / 100);

      var na = akhir_kog + akhir_psi;
      var roundna = Math.round(na);

      html += "<td style='padding: 0px 0px 0px 5px;'>" + kog + "x" + persen_kog / 100 + "=" + akhir_kog + "</td>";
      html += "<td style='padding: 0px 0px 0px 5px;'>" + psi + "x" + persen_psi / 100 + "=" + akhir_psi + "</td>";
      html += "<td style='padding: 0px 0px 0px 5px;'>" + akhir_kog + "+" + akhir_psi + "= " + na + "~ " + roundna + "</td>";
      html += "</tr>"
      html += "</table>";

      $('#isi_modal').html(html);
      $("#myModal").show();
    });

  });
</script>
