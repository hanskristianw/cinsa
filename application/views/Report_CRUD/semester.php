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
            
              //var_dump($kelas_jenj_id);
              for($i=0;$i<count($sis_arr);$i++):

                //echo $kelas_jenj_id['kelas_jenj_id']."<br>";

                $tanggal_arr = explode('-', $kepsek['sk_fin']);
                $tahun = $tanggal_arr[0];
                $bulan = return_nama_bulan($tanggal_arr[1]);
                $tanggal = $tanggal_arr[2];
                
                $siswa = return_raport_fin($sis_arr[$i], $semester, $kelas_jenj_id['kelas_jenj_id']);
                if(isset($siswa[0]['sis_nama_depan'])):

                  echo"<p class='judul'>ACADEMIC ACHIEVEMENT<br>Nation Star Academy Senior High School</p>";
            
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
                if($ssp_siswa):
              ?>


              <p class='judul'>SHARPENING STUDENT'S POTENTIAL</p>
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
                    <td>SSP</td>
                    
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
                </tbody>
              </table>

              <div style='clear: both;'></div>
              <p style="page-break-after: always;">&nbsp;</p>
            <?php
              endif;
            ?>
              
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
