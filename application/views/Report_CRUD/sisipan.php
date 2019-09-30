<div class="container">


  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div id="print_area">
            <?php

              //var_dump($sis_arr);
              for($i=0;$i<count($sis_arr);$i++):
                $nomor = 1;
                $siswa = return_raport_mid($sis_arr[$i], $semester);

                //var_dump($sis_arr[$i]);

                $tanggal_arr = explode('-', $kepsek['sk_mid']);
                $tahun = $tanggal_arr[0];
                $bulan = return_nama_bulan($tanggal_arr[1]);
                $tanggal = $tanggal_arr[2];

                if(isset($siswa[0]['sis_nama_depan'])):

            ?>
              <hr style="height:5px; visibility:hidden;" />



              <br><br><br>
              <div id='textbox'>
                <p class='alignleft'>

                  STUDENT'S NAME &nbsp&nbsp&nbsp&nbsp&nbsp&emsp;&emsp;&emsp;:&nbsp<?= $siswa[0]['sis_nama_depan'].' '.$siswa[0]['sis_nama_bel'] ?><br>
                  STUDENT ID &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&emsp;&emsp;&emsp;:&nbsp<?= $siswa[0]['sis_no_induk'] ?><br>
                </p>
                <p class='alignright'>
                  GRADE &nbsp&nbsp&nbsp&nbsp&emsp;&emsp;&emsp;&thinsp;:&nbsp<?= $siswa[0]['kelas_nama'] ?><br>
                  SEMESTER &nbsp&emsp;&thinsp;&emsp;: <?php if($semester==1)echo "Odd";else echo "Even"; ?><br>
                </p>
              </div>

              <div style='clear: both;'></div>
              <table style='margin-top: 5px;' class='rapot'>
                <thead>
                    <tr>
                        <th rowspan='4'>NO.</th>
                        <th rowspan='4' style='width: 190px; padding: 0px 0px 0px 5px;'>SUBJECT</th>
                        <th rowspan='4' style='width: 60px; padding: 0px 0px 0px 5px;'>PASSING <br>GRADE</th>
                        <th colspan='15' style='padding: 0px 0px 0px 5px;'>PROGRESS REPORT</th>
                    </tr>
                    <tr>
                        <th colspan='12'>FORMATIVE</th>
                        <th rowspan='3' style='width: 80px;'>AFFECTIVE</th>
                        <th rowspan='2' colspan='2'>SUMMATIVE</th>
                    </tr>
                    <tr>
                        <th colspan='6'>COGNITIVE</th>
                        <th colspan='6'>PSYCHOMOTOR</th>
                    </tr>
                    <tr>
                        <th>Q1</th>
                        <th>A1</th>
                        <th>T1</th>
                        <th>Q2</th>
                        <th>A2</th>
                        <th>T2</th>
                        <th>Q1</th>
                        <th>A1</th>
                        <th>T1</th>
                        <th>Q2</th>
                        <th>A2</th>
                        <th>T2</th>
                        <th>COG</th>
                        <th>PSY</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($siswa as $m) :
                      if($semester==1)$komen_mid=$m['d_s_komen_sis'];else $komen_mid=$m['d_s_komen_sis2'];
                      if($semester==1)$d_s_sick=$m['d_s_sick'];else $d_s_sick=$m['d_s_sick2'];
                      if($semester==1)$d_s_absenin=$m['d_s_absenin'];else $d_s_absenin=$m['d_s_absenin2'];
                      if($semester==1)$d_s_absenex=$m['d_s_absenex'];else $d_s_absenex=$m['d_s_absenex2'];
                  ?>
                    <tr>
                      <td class='nomor'><?= $nomor ?></td>
                      <td style='padding: 0px 0px 0px 5px; margin: 0px;'>
                        <?php
                          if($m['mk_nama']){
                            echo $m['mk_nama'];
                          }else{
                            echo $m['mapel_nama'];
                          }
                        ?>
                      </td>
                      <td class='kkm' style='padding: 0px 0px 0px 5px; margin: 0px;'><?= $m['mapel_kkm'] ?></td>
                      <?= returnQATastd($m['kq'],$m['ka'],$m['kt'],$m['pq'],$m['pa'],$m['pt'],$m['minggu1'],$m['minggu2'],$m['minggu3'],$m['minggu4'],$m['minggu5'],$m['uj_mid1_kog'],$m['uj_mid1_psi'],$m['uj_mid2_kog'],$m['uj_mid2_psi'],$semester); ?>
                    </tr>
                  <?php
                    $nomor++;
                    endforeach;
                  ?>
                  <tr>
                    <?php
                      if($checkSsp){
                        echo "<td class='nomor'>".($nomor)."</td>";
                        echo returnNilaiSspSisipan($sis_arr[$i], $semester);
                      }
                    ?>
                  </tr>
                  <tr>
                    <td class='kkm' colspan='2'>Homeroom Teacher's Comment</td>
                    <td colspan='16' cellpadding='20' style='padding: 0px 0px 0px 5px;'> <?= $komen_mid ?></td>
                  </tr>
                  <tr>
                    <td style='height:0px; padding: 0px 0px 0px 0px;' class='kkm' colspan='18'>ATTENDANCE RECORD</td>
                  </tr>
                  <tr>
                    <td style='height:0px; padding: 0px 0px 0px 5px;' colspan='18'>1. Sick &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp&nbsp&nbsp&thinsp;: <?= $d_s_sick ?> days</td>
                  </tr>
                  <tr>
                    <td style='height:0px; padding: 0px 0px 0px 5px;' colspan='18'>2. Absent (Including Excuse)&nbsp&nbsp&thinsp;: <?= $d_s_absenin ?> days</td>
                  </tr>
                  <tr>
                    <td style='height:0px; padding: 0px 0px 0px 5px;' colspan='18'>3. Absent (Excluding Excuse)&nbsp;&thinsp;: <?= $d_s_absenex ?> days</td>
                  </tr>
                </tbody>
              </table>
              <div style='font-size: 10px !important'>&emsp;&emsp;*)Q = Quiz; &nbsp A = Assignment; &nbsp T=Test;</div>
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

            <p class='aligncenter_bawah'>Acknowledged by<br>Principal<br><br><br><br><b><?= $kepsek['kr_gelar_depan'].$kepsek['kr_nama_depan'].' '.$kepsek['kr_nama_belakang']." ".$kepsek['kr_gelar_belakang'] ?></b></p>

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
