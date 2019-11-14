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
                    <td><b>Formative</b></td><td>: total nilai harian (Quiz, Tes, Ass) / jumlah topik terisi </td>
                  </tr>
                  <tr>
                    <td><b>Summative</b></td><td>: UTS x persentase + UAS x persentase </td>
                  </tr>
                  <tr>
                    <td><b>Nilai Kognitif</b></td><td>: (formative x % formative pengetahuan) + (summative x % summative pengetahuan)</td>
                  </tr>
                  <tr>
                    <td><b>Nilai Psikomotor</b></td><td>: (formative x % formative ketrampilan) + (summative x % summative ketrampilan)</td>
                  </tr>
                  <tr>
                    <td><b>Nilai Akhir</b></td><td>: (kognitif x % pengetahuan akhir) + (ketrampilan x % ketrampilan akhir)</td>
                  </tr>
                </table>

                
            </div>

            <div id="print_area">
            
            <?php
              function returnNamaSemester($angka){
                if($angka == 1)
                  return "1 (Odd)";
                else
                  return "2 (Even)";
              }

              function grading($grading_akhir){
                if($grading_akhir >16)
                  return "EXCELLENT";
                elseif($grading_akhir >=11)
                  return "GOOD";
                elseif($grading_akhir >=0)
                  return "SATISFACTORY";
                elseif($grading_akhir >=-10)
                  return "UNSATISFACTORY";
                else
                  return "POOR";
              }
              
              function return_his_her($jk){
                if($jk == 1)
                  return "his";
                elseif($jk == 2)
                  return "her";
              }

              function return_he_she($jk){
                if($jk == 1)
                  return "he";
                elseif($jk == 2)
                  return "she";
              }

              //var_dump($kelas_jenj_id);
              for($i=0;$i<count($sis_arr);$i++):

                //echo $sis_arr[$i]."<br>";

                $tanggal_arr = explode('-', $kepsek['sk_fin']);
                $tahun = $tanggal_arr[0];
                $bulan = return_nama_bulan($tanggal_arr[1]);
                $tanggal = $tanggal_arr[2];
                
                $siswa = return_raport_fin($sis_arr[$i], $semester, $kelas_jenj_id['kelas_jenj_id']);

                //var_dump($siswa);

                if(isset($siswa[0]['sis_nama_depan'])):

                  echo"<p class='judul'>ACADEMIC ACHIEVEMENT<br>Nation Star Academy ".$kepsek['sk_nickname']."</p>";
            
            ?>
              <table style="width:100%; font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">
                  <tr>
                    <td style="width:80px;">NAME</td>
                    <td style="width:60%;">: <?= $siswa[0]['sis_nama_depan']." ".$siswa[0]['sis_nama_bel'] ?></td>
                    <td style="width:100px;">SEMESTER</td>
                    <td>: <?= returnNamaSemester($semester) ?></td>
                  </tr>
                  <tr>
                    <td>ID NUMBER</td>
                    <td>: <?= $siswa[0]['sis_no_induk'] ?></td>
                    <td>SCHOOL YEAR</td>
                    <td>: <?= $t['t_nama'] ?></td>
                  </tr>
                  <tr>
                    <td>CLASS</td>
                    <td>: <?= $siswa[0]['kelas_nama'] ?> </td>
                    <?php 
                      $program = explode(" ", $siswa[0]['kelas_nama']);
                      if(isset($program[1])):
                    ?>
                    <td>PROGRAM</td>
                    <td>: <?= $program[1] ?></td>
                    <?php endif; ?>
                  </tr>
              </table>
              <hr style="height:5px; visibility:hidden;" />
              
              <!-- HALAMAN 1 Kognitif Psikomotor -->
              <table class='rapot'>
                <thead>
                  <tr>
                    <th rowspan='2'>NO.</th>
                    <th rowspan='2'>SUBJECT</th>
                    <th rowspan='2'>PASSING <br>GRADE</th>
                    <th colspan='5'>ACHIEVEMENT REPORT</th>
                    </tr>
                    <tr>
                    <th>Cognitive</th>
                    <th>Psychomotor</th>
                    <th>Affective</th>
                    <th>Final <br>Score</th>
                    <th>Grading</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $nomor_hal1 = 1;
                  foreach($siswa as $m) :
                ?>
                  <tr>
                    <td class='nomor'><?= $nomor_hal1 ?></td>
                    <td style='padding: 2px 0px 0px 5px;width:200px;height:10px;'><?= $m['mapel_nama'] ?></td>
                    <td style='width:60px;' class='kkm'><?= $m['mapel_kkm'] ?></td>

                <?php 
                  $for_kog = $m['for_kog'];
                  $for_psi = $m['for_psi'];
                  $sum_kog_sem1 = $m['sum_kog_sem1'];
                  $sum_psi_sem1 = $m['sum_psi_sem1'];
                  $sum_kog_sem2 = $m['sum_kog_sem2'];
                  $sum_psi_sem2 = $m['sum_psi_sem2'];
  
                  //PENGETAHUAN 
                  //formative 70
                  if($m['persen_forma_peng'])
                    $persen_forma_peng = $m['persen_forma_peng'];
                  else
                    $persen_forma_peng = 70;
                    
                  //summative 30
                  if($m['persen_summa_peng'])
                    $persen_summa_peng = $m['persen_summa_peng'];
                  else
                    $persen_summa_peng = 30;

                  //KETRAMPILAN
                  //formative 70
                  if($m['persen_forma_ket'])
                    $persen_forma_ket = $m['persen_forma_ket'];
                  else
                    $persen_forma_ket = 70;

                  //summative 30
                  if($m['persen_summa_ket'])
                    $persen_summa_ket = $m['persen_summa_ket'];
                  else
                    $persen_summa_ket = 30;

                  //AKHIR
                  //pengetahuan 50 ketrampilan 50
                  if($m['persen_peng_akhir'])
                    $persen_peng_akhir = $m['persen_peng_akhir'];
                  else
                    $persen_peng_akhir = 50;

                  if($m['persen_ket_akhir'])
                    $persen_ket_akhir = $m['persen_ket_akhir'];
                  else
                    $persen_ket_akhir = 50;
  
                  if($semester == 1){
                    $kognitif = round($for_kog * $persen_forma_peng/100 + $sum_kog_sem1 * $persen_summa_peng/100);
                    $psikomotor = round($for_psi * $persen_forma_ket/100 + $sum_psi_sem1 * $persen_summa_ket/100);
                    
                    $n_akhir = round($kognitif * $persen_peng_akhir/100 + $psikomotor * $persen_ket_akhir/100);
                  }elseif($semester == 2){
                    $kognitif = round($for_kog * $persen_forma_peng/100 + $sum_kog_sem2 * $persen_summa_peng/100);
                    $psikomotor = round($for_psi * $persen_forma_ket/100 + $sum_psi_sem2 * $persen_summa_ket/100);
                    
                    $n_akhir = round($kognitif * $persen_peng_akhir/100 + $psikomotor * $persen_ket_akhir/100);
                  }
                ?>
                    <td class='biasa' style='width:80px;'><?= $kognitif ?></td>
                    <td class='biasa' style='width:80px;'><?= $psikomotor ?></td>
                    <td class='biasa' style='width:60px;'><?= return_abjad_afek($m['total']) ?></td>
                    <td class='biasa'><?= $n_akhir ?></td>
                    <td class='biasa'><?= grading($n_akhir - $m['mapel_kkm']) ?></td>
                  </tr>
                <?php 
                  $nomor_hal1++;
                  endforeach; 
                ?>
                </tbody>
              </table>

              <div id='textbox'>
                <p class='alignleft_bawah'>
                <br>Acknowledged by<br>
                Parents / Guardian<br><br><br><br>
                ............................................
                </p>

                <p class='alignright_bawah'>
                <br>Surabaya, <?= $bulan.' '.$tanggal.', '.$tahun ?><br>
                Homeroom Teacher<br><br><br><br>
                <b><?= $walkel['kr_gelar_depan'].$walkel['kr_nama_depan'].' '.$walkel['kr_nama_belakang']." ".$walkel['kr_gelar_belakang'] ?></b><br>
                </p>
              </div>
              <div style='clear: both;'></div>

              <p class='aligncenter_bawah'>Acknowleged by<br>Principal<br><br><br><br><b><?= $kepsek['kr_gelar_depan'].$kepsek['kr_nama_depan'].' '.$kepsek['kr_nama_belakang']." ".$kepsek['kr_gelar_belakang'] ?></b></p>
              <p style="page-break-after: always;">&nbsp;</p>

                  
              <!-- HALAMAN 2 SSP -->
              <?php 
                $ssp_siswa = returnNilaiSspFinal($sis_arr[$i],$semester);
                if($ssp_siswa && $checkSsp):
              ?>


              <p class='judul'><?= $kepsek['sk_ex_nama'] ?></p>
              <table style="width:100%; font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">
                  <tr>
                    <td style="width:80px;">NAME</td>
                    <td style="width:60%;">: <?= $siswa[0]['sis_nama_depan']." ".$siswa[0]['sis_nama_bel'] ?></td>
                    <td style="width:100px;">SEMESTER</td>
                    <td>: <?= returnNamaSemester($semester) ?></td>
                  </tr>
                  <tr>
                    <td>ID NUMBER</td>
                    <td>: <?= $siswa[0]['sis_no_induk'] ?></td>
                    <td>SCHOOL YEAR</td>
                    <td>: <?= $t['t_nama'] ?></td>
                  </tr>
                  <tr>
                    <td>CLASS</td>
                    <td>: <?= $siswa[0]['kelas_nama'] ?></td>
                    <td><?= $kepsek['sk_ex_abr'] ?></td>
                    
                    <td>: <?= $ssp_siswa[0]['ssp_nama'] ?></td>
                  </tr>
              </table>
              
              <hr style="height:5px; visibility:hidden;" />

              <table class='rapot'>
                <thead>
                    <tr>
                    <th style='width: 35px; padding: 0px 0px 0px 0px;'>NO </th>
                    <th style='width: 200px;'>CRITERIA</th>
                    <th style='width: 50px;'>GRADE</th>
                    <th style='width: 350px;'>DESCRIPTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                  $nomor_hal2 = 1;
                  $total = 0;
                  $guru_ssp = returnGuruSsp($sis_arr[$i]);
                  foreach($ssp_siswa as $m) :
                ?>
                  <tr>
                    <td class='nomor'><?= $nomor_hal2 ?></td>
                    <td style='padding: 0px 5px 0px 5px;'><?= $m['ssp_topik_nama'] ?></td>
                    <td style='text-align: center;'><?= return_abjad_base4($m['ssp_nilai_angka']) ?></td>
                    <td style='padding: 0px 5px 0px 5px;'>
                      <?php
                        $total += $m['ssp_nilai_angka'];
                        if(return_abjad_base4($m['ssp_nilai_angka']) == "A"){
                          echo $m['ssp_topik_a'];
                        }elseif(return_abjad_base4($m['ssp_nilai_angka']) == "B"){
                          echo $m['ssp_topik_b'];
                        }elseif(return_abjad_base4($m['ssp_nilai_angka']) == "C"){
                          echo $m['ssp_topik_b'];
                        }else{
                          echo "-";
                        }
                      ?>
                    </td>
                  </tr>
                <?php
                  $nomor_hal2++; 
                  endforeach; 
                ?>
                
                  <tr>
                    <td style='text-align: center; font-weight:bold; height: 50px;' colspan='2'>FINAL SCORE</td>
                    <td style='text-align: center; font-weight:bold;' colspan='2'><?= return_abjad_base4($total/($nomor_hal2-1)) ?></td>
                  </tr>
                </tbody>
              </table>

              <div id='textbox'>
                  <p class='alignright_bawah'>
                  <br>Surabaya, <?= $bulan.' '.$tanggal.', '.$tahun ?><br>
                  <?= $kepsek['sk_ex_abr'] ?> Teacher<br><br><br><br>
                  <b><?= $guru_ssp['kr_gelar_depan'].$guru_ssp['kr_nama_depan'].' '.$guru_ssp['kr_nama_belakang']." ".$guru_ssp['kr_gelar_belakang'] ?></b><br>
                  </p>
              </div>

              <div style='clear: both;'></div>
              <p style="page-break-after: always;">&nbsp;</p>
            <?php
              endif;
            ?>

            <!-- HALAMAN 3 Character Building -->
            <?php 
              $cb_siswa = returnNilaiCB($sis_arr[$i],$semester);
              if($cb_siswa):
            ?>
              <p class='judul'>CHARACTER BUILDING</p>
              <table style="width:100%; font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">
                  <tr>
                    <td style="width:80px;">NAME</td>
                    <td style="width:60%;">: <?= $siswa[0]['sis_nama_depan']." ".$siswa[0]['sis_nama_bel'] ?></td>
                    <td style="width:100px;">SEMESTER</td>
                    <td>: <?= returnNamaSemester($semester) ?></td>
                  </tr>
                  <tr>
                    <td>ID NUMBER</td>
                    <td>: <?= $siswa[0]['sis_no_induk'] ?></td>
                    <td>SCHOOL YEAR</td>
                    <td>: <?= $t['t_nama'] ?></td>
                  </tr>
                  <tr>
                    <td>CLASS</td>
                    <td>: <?= $siswa[0]['kelas_nama'] ?></td>
                    <?php 
                      $program = explode(" ", $siswa[0]['kelas_nama']);
                      if(isset($program[1])):
                    ?>
                    <td>PROGRAM</td>
                    <td>: <?= $program[1] ?></td>
                    <?php endif; ?>
                  </tr>
              </table>
              <br>
              <table class='rapot'>
                <thead>
                    <tr>
                    <th style='width: 35px; padding: 0px 0px 0px 0px;'>NO </th>
                    <th style='width: 200px;'>TOPIC</th>
                    <th style='width: 50px;'>GRADE</th>
                    <th style='width: 350px;'>DESCRIPTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                  $nomor_hal3 = 1;
                  $total_cb = 0;
                  //$guru_CB = returnGuruCB($sis_arr[$i]);

                  foreach($cb_siswa as $m) :
                ?>
                  <tr>
                    <td class='nomor'><?= $nomor_hal3 ?></td>
                    <td style='padding: 0px 5px 0px 5px;'><?= $m['topik_cb_nama'] ?></td>
                    <td style='text-align: center;'><?= return_abjad_base4($m['nilai']) ?></td>
                    <td style='padding: 0px 5px 0px 5px;'>
                      <?php
                        $total_cb += $m['nilai'];
                        $temp_desc_cb = "";
                        if(return_abjad_base4($m['nilai']) == "A"){
                          //rubah nama jadi nama siswa
                          $temp_desc_cb = str_replace("{s}", ucfirst(strtolower($siswa[0]['sis_nama_depan'])), $m['topik_cb_a']);
                          //rubah his her huruf kecil
                          $temp_desc_cb = str_replace("{his/her}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                          //rubah his her huruf besar
                          $temp_desc_cb = str_replace("{HIS/HER}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);
                          //rubah he she huruf kecil
                          $temp_desc_cb = str_replace("{he/she}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                          //rubah he she huruf besar
                          $temp_desc_cb = str_replace("{HE/SHE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);

                          echo $temp_desc_cb;
                        }elseif(return_abjad_base4($m['nilai']) == "B"){
                          $temp_desc_cb = str_replace("{s}", ucfirst(strtolower($siswa[0]['sis_nama_depan'])), $m['topik_cb_b']);
                          //rubah his her huruf kecil
                          $temp_desc_cb = str_replace("{his/her}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                          //rubah his her huruf besar
                          $temp_desc_cb = str_replace("{HIS/HER}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);
                          //rubah he she huruf kecil
                          $temp_desc_cb = str_replace("{he/she}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                          //rubah he she huruf besar
                          $temp_desc_cb = str_replace("{HE/SHE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);

                          echo $temp_desc_cb;
                        }elseif(return_abjad_base4($m['nilai']) == "C"){
                          $temp_desc_cb = str_replace("{s}", ucfirst(strtolower($siswa[0]['sis_nama_depan'])), $m['topik_cb_c']);
                          //rubah his her huruf kecil
                          $temp_desc_cb = str_replace("{his/her}", return_his_her($siswa[0]['sis_jk']), $temp_desc_cb);
                          //rubah his her huruf besar
                          $temp_desc_cb = str_replace("{HIS/HER}", ucfirst(return_his_her($siswa[0]['sis_jk'])), $temp_desc_cb);
                          //rubah he she huruf kecil
                          $temp_desc_cb = str_replace("{he/she}", return_he_she($siswa[0]['sis_jk']), $temp_desc_cb);
                          //rubah he she huruf besar
                          $temp_desc_cb = str_replace("{HE/SHE}", ucfirst(return_he_she($siswa[0]['sis_jk'])), $temp_desc_cb);

                          echo $temp_desc_cb;
                        }else{
                          echo "-";
                        }
                      ?>
                    </td>
                  </tr>
                <?php
                  $nomor_hal3++; 
                  endforeach; 
                ?>

                  <tr>
                      <td style='text-align: center; font-weight:bold; height: 50px;' colspan='2'>FINAL SCORE</td>
                      <td style='text-align: center; font-weight:bold; height: 50px;' colspan='2'><?= return_abjad_base4($total_cb/($nomor_hal3-1)) ?></td>
                  </tr>
                </tbody>
              </table>
              
              <div id='textbox'>
                <p class='alignright_bawah'>
                <br>Surabaya, <?= $bulan.' '.$tanggal.', '.$tahun ?><br>
                CB Teacher<br><br><br><br>
                <b><?= $guru_cb['kr_gelar_depan'].$guru_cb['kr_nama_depan'].' '.$guru_cb['kr_nama_belakang']." ".$guru_cb['kr_gelar_belakang'] ?></b><br>
                </p>
              </div>

              <div style='clear: both;'></div>
              <p style="page-break-after: always;">&nbsp;</p>
            <?php
              endif;
            ?>

              <table style="width:100%; font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">
                  <tr>
                    <td style="width:80px;">NAME</td>
                    <td style="width:60%;">: <?= $siswa[0]['sis_nama_depan']." ".$siswa[0]['sis_nama_bel'] ?></td>
                    <td style="width:100px;">SEMESTER</td>
                    <td>: <?= returnNamaSemester($semester) ?></td>
                  </tr>
                  <tr>
                    <td>ID NUMBER</td>
                    <td>: <?= $siswa[0]['sis_no_induk'] ?></td>
                    <td>SCHOOL YEAR</td>
                    <td>: <?= $t['t_nama'] ?></td>
                  </tr>
                  <tr>
                    <td>CLASS</td>
                    <td>: <?= $siswa[0]['kelas_nama'] ?></td>
                    <?php 
                      $program = explode(" ", $siswa[0]['kelas_nama']);
                      if(isset($program[1])):
                    ?>
                    <td>PROGRAM</td>
                    <td>: <?= $program[1] ?></td>
                    <?php endif; ?>
                  </tr>
              </table>
              <hr style="height:5px; visibility:hidden;" />
              <table class='rapot_rangkuman'>
                <thead>
                  <tr>
                    <th style='width: 30px; height: 15px; padding: 0px 0px 0px 0px;'>NO </th>
                    <th style='width: 185px; height: 15px; padding: 0px 0px 0px 5px;'>AFFECTIVE</th>
                    <th style='height: 15px;'>DESCRIPTION</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $siswa_karakter = returnNilaiKarakter($sis_arr[$i],$semester);
                    $nomor_karakter = 1;
                    foreach($siswa_karakter as $k):
                      if($k['karakter_id']):
                        $kata_karakter_afek = "";
                        if(return_abjad_afek($k['total'])=="A")
                          $kata_karakter_afek = $k['karakter_a'];
                        elseif(return_abjad_afek($k['total'])=="B")
                          $kata_karakter_afek = $k['karakter_b'];
                        elseif(return_abjad_afek($k['total'])=="C")
                          $kata_karakter_afek = $k['karakter_c'];
                  ?>
                    <tr>
                      <td style='text-align: center;'><?= $nomor_karakter ?></td>
                      <td style='padding: 5px 5px 5px 5px;'><?= $k['karakter_nama'] ?></td>
                      <td style='padding: 5px 5px 5px 10px;'><?= ucfirst(strtolower($siswa[0]['sis_nama_depan']))." ".$kata_karakter_afek ?></td>
                    </tr>
                  <?php 
                      $nomor_karakter++;
                      endif;
                    endforeach;
                    //$siswa_karakter = returnNilaiKarakter($sis_arr[$i],$semester);
                  ?>
                </tbody>
              </table>
              <br>
              <table class='rapot_rangkuman'>
                <thead>
                  <tr>
                    <th style='width: 30px; height: 15px; padding: 0px 0px 0px 0px;'>NO </th>
                    <th style='width: 185px; height: 15px; padding: 0px 0px 0px 5px;'>LIFE SKILLS</th>
                    <th>GRADE</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php 
                      $pfhf_nilai = 0;
                      if($semester == 1)
                        $pfhf_nilai = $siswa[0]['pfhf_sem1'];
                      elseif($semester == 2)
                        $pfhf_nilai = $siswa[0]['pfhf_sem2'];
                    ?>
                    <td style='text-align: center;'>1</td>
                    <td style='padding: 0px 0px 0px 5px;'>Physical Fitness and Healthful Habit</td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= return_abjad_base4($pfhf_nilai) ?></b></td>
                  </tr>
                  <tr>
                    <?php 
                      $mb_nilai = 0;
                      if($semester == 1)
                        $mb_nilai = $siswa[0]['mb_sem1'];
                      elseif($semester == 2)
                        $mb_nilai = $siswa[0]['mb_sem2'];
                    ?>
                    <td style='text-align: center;'>2</td>
                    <td style='padding: 0px 0px 0px 5px;'>Moral Behavior</td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= return_abjad_base4($mb_nilai) ?></b></td>
                  </tr>
                  <tr>
                    <?php 
                      $emo_nilai = 0;
                      if($semester == 1)
                        $emo_nilai = $siswa[0]['emo_sem1'];
                      elseif($semester == 2)
                        $emo_nilai = $siswa[0]['emo_sem2'];
                    ?>
                    <td style='text-align: center;'>3</td>
                    <td style='padding: 0px 0px 0px 5px;'>Emotional Awareness</td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= return_abjad_base4($emo_nilai) ?></b></td>
                  </tr>
                  <tr>
                    <?php 
                      $spirit_nilai = 0;
                      if($semester == 1)
                        $spirit_nilai = $siswa[0]['spirit_sem1'];
                      elseif($semester == 2)
                        $spirit_nilai = $siswa[0]['spirit_sem2'];
                    ?>
                    <td style='text-align: center;'>4</td>
                    <td style='padding: 0px 0px 0px 5px;'>Spirituality</td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= return_abjad_base4($spirit_nilai) ?></b></td>
                  </tr>
                  <tr>
                    <?php 
                      $ss_nilai = 0;
                      if($semester == 1)
                        $ss_nilai = $siswa[0]['ss_sem1'];
                      elseif($semester == 2)
                        $ss_nilai = $siswa[0]['ss_sem2'];
                    ?>
                    <td style='text-align: center;'>5</td>
                    <td style='padding: 0px 0px 0px 5px;'>Social Skill</td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= return_abjad_base4($ss_nilai) ?></b></td>
                  </tr>
                </tbody>
              </table>

              <?php 
                $no_self_d = 1;
                if(isset($total_cb))
                  $nilai_cb = return_abjad_base4($total_cb/($nomor_hal3-1));
                else
                  $nilai_cb = "NO DATA";

                if(isset($total)){
                  $nilai_ssp = return_abjad_base4($total/($nomor_hal2-1));
                  $nama_ssp = $ssp_siswa[0]['ssp_nama'];
                }
                else{
                  $nilai_ssp = "NO DATA";
                  $nama_ssp = "NO SSP DATA";
                }
              ?>
              <div class='sub_judul mt-1'>SELF DEVELOPMENT</div>
              <table class='rapot_rangkuman'>
                <tbody>
                  <tr>
                    <td style='text-align: center; width: 30px; padding: 0px 0px 0px 0px;'><?= $no_self_d ?></td>
                    <td style='width: 185px; padding: 0px 0px 0px 5px;'>Character Building</td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= $nilai_cb ?></b></td>
                  </tr>
                  <?php 
                    if($checkSsp):
                      $no_self_d++;
                  ?>
                  <tr>
                    <td style='text-align: center;'><?= $no_self_d ?></td>
                    <td style='padding: 0px 0px 0px 5px;'><?= $nama_ssp ?></td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= $nilai_ssp ?></b></td>
                  </tr>
                  <?php 
                    endif;
                  ?>
                  <?php 
                    if($checkScout):
                      $no_self_d++;
                      if($semester == 1)
                        $scout_nilai = $siswa[0]['d_s_scout_nilai'];
                      elseif($semester == 2)
                        $scout_nilai = $siswa[0]['d_s_scout_nilai2'];
                  ?>
                  <tr>
                    <td style='text-align: center;'><?= $no_self_d ?></td>
                    <td style='padding: 0px 0px 0px 5px;'>Scout</td>
                    <td style='padding: 0px 0px 0px 10px;'><b><?= return_abjad_base4($scout_nilai) ?></b></td>
                  </tr>
                  <?php 
                    endif;
                  ?>
                </tbody>
              </table>

              <div class='sub_judul mt-1'>ATTENDANCE RECORD</div>
              <table class='rapot_rangkuman'>
                <tbody>
                  <tr>
                    <td style='text-align: center; width: 30px; padding: 0px 0px 0px 0px;'>1</td>
                    <td style='width: 185px; padding: 0px 0px 0px 5px;'>Sick</td>
                    <?php 
                      $sick = "";
                      if($semester == 1)
                        $sick = $siswa[0]['d_s_sick'];
                      elseif($semester == 2)
                        $sick = $siswa[0]['d_s_sick2'];

                      if($sick == "0")
                        $sick = "-";
                    ?>
                    <td style='padding: 0px 0px 0px 10px;'><?= $sick ?> day(s)</td>
                  </tr>
                  <tr>
                    <td style='text-align: center;'>2</td>
                    <td style='padding: 0px 0px 0px 5px;'>Absent (Including Excuse)</td>
                    <?php 
                      $absenin = "";
                      if($semester == 1)
                        $absenin = $siswa[0]['d_s_absenin'];
                      elseif($semester == 2)
                        $absenin = $siswa[0]['d_s_absenin2'];

                      if($absenin == "0")
                        $absenin = "-";
                    ?>
                    <td style='padding: 0px 0px 0px 10px;'><?= $absenin ?> day(s)</td>
                  </tr
                  <tr>
                    <td style='text-align: center;'>3</td>
                    <td style='padding: 0px 0px 0px 5px;'>Absent (Excluding Excuse)</td>
                    <?php 
                      $absenex = "";
                      if($semester == 1)
                        $absenex = $siswa[0]['d_s_absenex'];
                      elseif($semester == 2)
                        $absenex = $siswa[0]['d_s_absenex2'];

                      if($absenex == "0")
                        $absenex = "-";
                    ?>
                    <td style='padding: 0px 0px 0px 10px;'><?= $absenex ?> day(s)</td>
                  </tr>
                  <tr>
                    <td style='padding: 0px 0px 0px 5px;' colspan = 2><b>Homeroom Teacher's Comment</b></td>
                    <?php 
                      $komen = "";
                      if($semester == 1)
                        $komen = $siswa[0]['d_s_komen_sem'];
                      elseif($semester == 2)
                        $komen = $siswa[0]['d_s_komen_sem2'];
                    ?>
                    <td style='padding: 5px 5px 5px 5px;'><?= $komen ?></td>
                  </tr>
                  <tr>
                    <td style='padding: 0px 0px 0px 5px;' colspan = 2><b>Special Note</b></td>
                    <td style='padding: 5px 5px 5px 5px;'></td>
                  </tr>
                  <tr>
                    <td style='padding: 0px 0px 0px 5px;' colspan = 2><b>Note</b></td>
                    <td style='padding: 5px 5px 5px 5px;'></td>
                  </tr>
                </tbody>
              </table>
              <div id='textbox'>
                <p class='alignleft_bawah'>
                <br>Acknowledged by<br>
                Parents / Guardian<br><br><br><br>
                ............................................
                </p>
                <p class='alignright_bawah'>
                <br>Surabaya, <?= $bulan.' '.$tanggal.', '.$tahun ?><br>
                Principal<br><br><br><br>
                <b><?= $kepsek['kr_gelar_depan'].$kepsek['kr_nama_depan'].' '.$kepsek['kr_nama_belakang']." ".$kepsek['kr_gelar_belakang'] ?></b><br>
                </p>
              </div>
              <div style='clear: both;'></div>
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
