<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">

            <?= $this->session->flashdata('message'); ?>

            <div id="print_area">
            <?php foreach($kelas_all as $n): 
              $siswa = show_siswa_by_sis_arr($sis_arr);

              $mapel_ajar = show_mapel_header_summary_urut_raport($n['kelas_id']);

              //var_dump($mapel_ajar);
            ?>
              <?php foreach($siswa as $s): ?>
              <br><br>
              <h6 style='text-align: center; font-family:Cambria; font-size:18px;'><b>LAPORAN PENILAIAN HASIL BELAJAR SISWA</b></h6>
              <br>
              <div id='textbox'>
                <p class='alignleft_induk'>
                    NAMA PESERTA DIDIK &emsp;: <?= $s['sis_nama_depan']." ".$s['sis_nama_bel'] ?><br>
                    NOMOR INDUK &emsp;&emsp;&thinsp;&nbsp&nbsp&nbsp&nbsp&emsp;&thinsp;: <?= $s['sis_no_induk'] ?>
                </p>
                <p class='alignright'>
                    NISN &nbsp&nbsp&nbsp&emsp;&thinsp;&emsp;: <?= $s['sis_nisn'] ?><br>
                    <?php 
                      $program = explode(" ", $n['kelas_nama']);
                      if(isset($program[1]))
                        echo "PROGRAM ST ".$program[1];
                    ?>
                </p>
              </div>
              <div style='clear: both;'></div>

              <table class='induk mt-3'>
                <tr>
                  <th rowspan='5'>No</th>
                  <th>Tahun Pelajaran</th>
                  <th colspan='5'><?= $n['t_nama'] ?></th>
                  <th colspan='5'><?= $n['t_nama'] ?></th>
                </tr>
                <tr>
                  <td style='text-align: right;'>Kelas&nbsp</td>
                  <td colspan='5' style='text-align: center;'><?= $program[0] ?></td>
                  <td colspan='5' style='text-align: center;'><?= $program[0] ?></td>
                </tr>
                <tr>
                  <td style='text-align: right;'>Semester&nbsp</td>
                  <td colspan='5' style='text-align: center;'>1</td>
                  <td colspan='5' style='text-align: center;'>2</td>
                </tr>
                <tr>
                  <td style='text-align: right;'>Nilai&nbsp</td>
                  <td style='text-align: center;' rowspan='2'>KKM</td>
                  <td style='text-align: center;'>Penge<br>tahuan</td>
                  <td style='text-align: center;'>Ketram<br>pilan<br></td>
                  <td style='text-align: center;'>Final</td>
                  <td style='text-align: center;'>Sikap</td>
                  <td style='text-align: center;' rowspan='2'>KKM</td>
                  <td style='text-align: center;'>Penge<br>tahuan</td>
                  <td style='text-align: center;'>Ketram<br>pilan</td>
                  <td style='text-align: center;'>Final</td>
                  <td style='text-align: center;'>Sikap</td>
                </tr>
                <tr>
                  <td style='text-align: right;'>Mata Pelajaran&nbsp</td>
                  <td style='text-align: center;'>Angka</td>
                  <td style='text-align: center;'>Angka</td>
                  <td style='text-align: center;'>Angka</td>
                  <td style='text-align: center;'>Predikat</td>
                  <td style='text-align: center;'>Angka</td>
                  <td style='text-align: center;'>Angka</td>
                  <td style='text-align: center;'>Angka</td>
                  <td style='text-align: center;'>Predikat</td>
                </tr>
                <?php 
                  $no = 1;
                  foreach($mapel_ajar as $m): 
                    $nil_fin = return_raport_fin_mapel($s['d_s_id'], 1, $n['kelas_jenj_id'], $m['mapel_id'], $t_id);

                    $for_kog = $nil_fin['for_kog'];
                    $for_psi = $nil_fin['for_psi'];
                    $sum_kog_sem1 = $nil_fin['sum_kog_sem1'];
                    $sum_psi_sem1 = $nil_fin['sum_psi_sem1'];
                    $sum_kog_sem2 = $nil_fin['sum_kog_sem2'];
                    $sum_psi_sem2 = $nil_fin['sum_psi_sem2'];

                    //PENGETAHUAN 
                    //formative 70
                    if (isset($nil_fin['persen_forma_peng']))
                      $persen_forma_peng = $nil_fin['persen_forma_peng'];
                    else
                      $persen_forma_peng = 70;

                    //summative 30
                    if (isset($nil_fin['persen_summa_peng']))
                      $persen_summa_peng = $nil_fin['persen_summa_peng'];
                    else
                      $persen_summa_peng = 30;

                    //KETRAMPILAN
                    //formative 70
                    if (isset($nil_fin['persen_forma_ket']))
                      $persen_forma_ket = $nil_fin['persen_forma_ket'];
                    else
                      $persen_forma_ket = 70;

                    //summative 30
                    if (isset($nil_fin['persen_summa_ket']))
                      $persen_summa_ket = $nil_fin['persen_summa_ket'];
                    else
                      $persen_summa_ket = 30;

                    //AKHIR
                    //pengetahuan 50 ketrampilan 50
                    if (isset($nil_fin['persen_peng_akhir']))
                      $persen_peng_akhir = $nil_fin['persen_peng_akhir'];
                    else
                      $persen_peng_akhir = 50;

                    if (isset($nil_fin['persen_ket_akhir']))
                      $persen_ket_akhir = $nil_fin['persen_ket_akhir'];
                    else
                      $persen_ket_akhir = 50;

                    $kognitif = round($for_kog * $persen_forma_peng / 100 + $sum_kog_sem1 * $persen_summa_peng / 100);
                    $psikomotor = round($for_psi * $persen_forma_ket / 100 + $sum_psi_sem1 * $persen_summa_ket / 100);

                    $n_akhir = round($kognitif * $persen_peng_akhir / 100 + $psikomotor * $persen_ket_akhir / 100);

                    //SEMESTER 2
                    $nil_fin2 = return_raport_fin_mapel($s['d_s_id'], 2, $n['kelas_jenj_id'], $m['mapel_id'], $t_id);
                    $for_kog2 = $nil_fin2['for_kog'];
                    $for_psi2 = $nil_fin2['for_psi'];
                    $kognitif2 = round($for_kog2 * $persen_forma_peng / 100 + $sum_kog_sem2 * $persen_summa_peng / 100);
                    $psikomotor2 = round($for_psi2 * $persen_forma_ket / 100 + $sum_psi_sem2 * $persen_summa_ket / 100);
                    $n_akhir2 = round($kognitif2 * $persen_peng_akhir / 100 + $psikomotor2 * $persen_ket_akhir / 100);
                ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $m['mapel_nama'] ?></td>
                    <!-- SEMESTER 1 -->
                    <td style='text-align: center;'><?= $m['mapel_kkm'] ?></td>
                    <td style='text-align: center;'><?= $kognitif ?></td>
                    <td style='text-align: center;'><?= $psikomotor ?></td>
                    <td style='text-align: center;'><?= $n_akhir ?></td>
                    <td style='text-align: center;'><?= return_abjad_afek($nil_fin['total']) ?></td>
                    <!-- SEMESTER 2 -->
                    <td style='text-align: center;'><?= $m['mapel_kkm'] ?></td>
                    <td style='text-align: center;'><?= $kognitif2 ?></td>
                    <td style='text-align: center;'><?= $psikomotor2 ?></td>
                    <td style='text-align: center;'><?= $n_akhir2 ?></td>
                    <td style='text-align: center;'><?= return_abjad_afek($nil_fin2['total']) ?></td>
                  </tr>
                <?php 
                  $no++;
                  endforeach;
                ?>
                <tr>
                  <td colspan='2' style='text-align: center;'>Pengembangan Diri</td>
                  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td colspan='2' style='padding: 0px 0px 0px 5px; text-align: left;'>Extrakurikuler</td>
                  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <?php
                  $ssp = returnSSPSiswa($s['d_s_id']);
                  $nossp = 1;
                  foreach($ssp as $ss): 
                ?>
                <tr>
                  <td><?= $nossp ?></td>
                  <td><?= $ss['ssp_nama'] ?></td>
                  <?php 
                    $sspsem1 = returnnilSSPSiswa($s['d_s_id'],1,$ss['ssp_id']);
                    $sspsem2 = returnnilSSPSiswa($s['d_s_id'],2,$ss['ssp_id']);
                  ?>
                  <td colspan="5" style='text-align: center;'><?= return_abjad_base4($sspsem1['total']); ?></td>
                  <td colspan="5" style='text-align: center;'><?= return_abjad_base4($sspsem2['total']); ?></td>
                </tr>
                <?php $nossp++; endforeach;?>
                <tr>
                  <td><?= $nossp ?></td>
                  <td>PRAMUKA (SCOUT)</td>
                  <td colspan="5" style='text-align: center;'><?= return_abjad_base4($s['d_s_scout_nilai']) ?></td>
                  <td colspan="5" style='text-align: center;'><?= return_abjad_base4($s['d_s_scout_nilai2']) ?></td>
                </tr>
                <tr>
                  <td colspan='2' style='padding: 0px 0px 0px 5px; text-align: left;'>Keikutsertaan Dalam Organisasi/Kegiatan Sekolah</td>
                  <td colspan='5'></td>
                  <td colspan='5'></td>
                </tr>
                <tr>
                  <td colspan='2' style='padding: 0px 0px 0px 5px; text-align: left;'>Ketidakhadiran</td>
                  <td colspan='5'></td>
                  <td colspan='5'></td>
                </tr>
                <tr>
                <td>1</td>
                  <td style='padding: 0px 0px 0px 5px;'>SAKIT</td>
                  <td colspan='5' style='text-align: center;'><?= $nil_fin['d_s_sick'] ?></td>
                  <td colspan='5' style='text-align: center;'><?= $nil_fin2['d_s_sick2'] ?></td>
                </tr>

                <tr>
                  <td>2</td>
                  <td style='padding: 0px 0px 0px 5px;'>IJIN</td>
                  <td colspan='5' style='text-align: center;'><?= $nil_fin['d_s_absenin'] ?></td>
                  <td colspan='5' style='text-align: center;'><?= $nil_fin2['d_s_absenin2'] ?></td>
                </tr>

                <tr>
                  <td>3</td>
                  <td style='padding: 0px 0px 0px 5px;'>TANPA KETERANGAN</td>
                  <td colspan='5' style='text-align: center;'><?= $nil_fin['d_s_absenex'] ?></td>
                  <td colspan='5' style='text-align: center;'><?= $nil_fin2['d_s_absenex2'] ?></td>
                </tr>
                <tr>
                  <td colspan='2' style='padding: 0px 0px 0px 5px;'>Akhlak Mulia dan Kepribadian</td>
                  <td colspan='5'></td>
                  <td colspan='5'></td>
                </tr>
                <?php
                  $karakter = returnNilaiKarakter($s['d_s_id'],1);

                  $nok = 1;
                  
                  foreach($karakter as $k): 
                    if($k['karakter_id']):
                ?>
                <tr>
                  <td><?= $nok ?></td>
                  <td style='padding: 0px 0px 0px 5px;'><?= $k['karakter_nama'] ?></td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_afek($k['total']) ?></td>
                  <?php
                    $k_nil = returnNilaiKarakterbyID($s['d_s_id'], 2, $k['karakter_id']);
                  ?>
                  <td colspan='5' style='text-align: center;'><?= $k_nil['total'] ?></td>
                </tr>
                <?php $nok++; endif; endforeach; ?>
                <tr>
                  <td><?= $nok ?></td>
                  <td style='padding: 0px 0px 0px 5px;'>PHYSICAL FITNESS AND HEALTHFUL HABIT</td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['pfhf_sem1']) ?></td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['pfhf_sem2']) ?></td>
                </tr>
                <tr>
                  <td><?= $nok+1 ?></td>
                  <td style='padding: 0px 0px 0px 5px;'>MORAL BEHAVIOUR</td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['mb_sem1']) ?></td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['mb_sem2']) ?></td>
                </tr>
                <tr>
                  <td><?= $nok+2 ?></td>
                  <td style='padding: 0px 0px 0px 5px;'>EMOTIONAL AWARENESS</td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['emo_sem1']) ?></td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['emo_sem2']) ?></td>
                </tr>
                <tr>
                  <td><?= $nok+3 ?></td>
                  <td style='padding: 0px 0px 0px 5px;'>SPIRITUALITY</td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['spirit_sem1']) ?></td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['spirit_sem2']) ?></td>
                </tr>
                <tr>
                  <td><?= $nok+4 ?></td>
                  <td style='padding: 0px 0px 0px 5px;'>SOCIAL SKILL</td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['ss_sem1']) ?></td>
                  <td colspan='5' style='text-align: center;'><?= return_abjad_base4($nil_fin['ss_sem2']) ?></td>
                </tr>
                <tr>
                  <td colspan='2' style='text-align: center; padding: 10px 10px 10px 5px; font-size: 15px !important;'><b>STATUS AKHIR TAHUN</b></td>
                  <td colspan='10' style='text-align: left; padding: 0px 0px 0px 35px; font-size: 12px !important;'><u>Naik  ke</u><br>Tinggal di</td>
                </tr>
              </table>

              <div id='textbox'>
                <p class='alignleft_bawah_induk'>
                <br>Mengetahui,<br>
                Kepala Sekolah<br><br><br><br>
                <b><?= $kepsek['kr_gelar_depan'] . $kepsek['kr_nama_depan'] . ' ' . $kepsek['kr_nama_belakang'] . " " . $kepsek['kr_gelar_belakang'] ?></b>
                </p>
                <p class='alignright_bawah'>
                <br>Surabaya,<br>Wali Kelas<br><br><br><br>
                <b><?= $walkel['kr_gelar_depan'] . $walkel['kr_nama_depan'] . ' ' . $walkel['kr_nama_belakang'] . " " . $walkel['kr_gelar_belakang'] ?></b>
                </p>
              </div>
              <div style='clear: both;'></div>
              <p style="page-break-after: always;"></p>
              
              <?php endforeach;?>
            <?php endforeach;?>
            </div>
            
            <input type="button" name="export_excel" id="export_excel" class="btn btn-primary" value="Export To Excel">
            <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success" value="Print">
          </div>
        </div>
      </div>
    </div>
  </div>

</div>