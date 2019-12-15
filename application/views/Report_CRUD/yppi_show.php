<div class="container">


  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">

            <div id="print_area">

              <?php
              function returnNamaSemester($angka)
              {
                if ($angka == 1)
                  return "1 (Ganjil)";
                else
                  return "2 (Genap)";
              }

              //var_dump($kelas_jenj_id);
              for ($i = 0; $i < count($sis_arr); $i++) :

                //echo $sis_arr[$i]."<br>".$kelas_jenj_id['kelas_jenj_id'];

                $tanggal_arr = explode('-', $kepsek['sk_fin']);
                $tahun = $tanggal_arr[0];
                $bulan = return_nama_bulan_indo($tanggal_arr[1]);
                $tanggal = $tanggal_arr[2];

                $siswa = return_detail_siswa($sis_arr[$i]);

              ?>
                  <div style="font-family:Cambria, sans-serif;font-size:22px;text-align: center;">
                    <b>YAYASAN PENDIDIKAN DAN PENGAJARAN INDONESIA <br><?= $kepsek["sk_nickname"] ?></b>
                  </div>
                  <div style="font-family:Cambria, sans-serif;font-size:20px;text-align: center;">
                    <b>TAHUN AJARAN  <?= $t['t_nama'] ?></b>
                  </div>
                  <br>
                  <div style="font-family:Cambria, sans-serif;font-size:15px;text-align: center;">
                    SELF DEVELOPMENT REPORT (CHARACTER BUILDING)
                  </div>
                  <hr style="height:25px; visibility:hidden;" />

                  <?php

                    $cb_siswa = returnNilaiCB($sis_arr[$i], $semester);
                    
                    //var_dump($cb_siswa);
                    if ($cb_siswa) :
                  ?>
                    <table style="width:100%; font-weight:bold;font-family:Cambria, sans-serif;font-size:13px;">
                      <tr>
                        <td style="width:100px;">Nama</td>
                        <td style="width:60%;">: <?= $siswa[0]['sis_nama_depan'] . " " . $siswa[0]['sis_nama_bel'] ?></td>
                        <td style="width:80px;">Kelas</td>
                        <td>: <?= $siswa[0]['kelas_nama'] ?></td>
                      </tr>
                      <tr>
                        <td>Nomor Induk</td>
                        <td>: <?= $siswa[0]['sis_no_induk'] ?></td>
                        <td>Semester</td>
                        <td>: <?= returnNamaSemester($semester) ?></td>
                      </tr>
                    </table>
                    <br>
                    <table class='rapot'>
                      <thead>
                        <tr>
                          <th style='width: 30px; padding: 0px 0px 0px 0px;'>No </th>
                          <th>Topik</th>
                          <th style='width: 50px;'>Nilai</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $nomor_hal3 = 1;
                          $total_cb = 0;
                          //$guru_CB = returnGuruCB($sis_arr[$i]);

                          foreach ($cb_siswa as $m) :
                          $total_cb += $m['nilai'];
                        ?>
                          <tr>
                            <td class='nomor'><?= $nomor_hal3 ?></td>
                            <td style='padding: 0px 5px 0px 5px;'><?= $m['topik_cb_nama'] ?></td>
                            <td style='text-align: center;'><?= return_abjad_base4($m['nilai']) ?></td>
                          </tr>
                        <?php
                          $nomor_hal3++;
                          endforeach;
                        ?>

                        <tr>
                          <td style='text-align: center; font-weight:bold; height: 50px;' colspan='2'>NILAI AKHIR</td>
                          <td style='text-align: center; font-weight:bold; height: 50px;' colspan='2'><?= return_abjad_base4($total_cb / ($nomor_hal3 - 1)) ?></td>
                        </tr>
                      </tbody>
                    </table>

                    <div id='textbox'>
                      <p class='alignright_bawah'>
                        <br>Surabaya, <?= $tanggal . ' ' . $bulan . ', ' . $tahun ?><br>
                        Guru BK<br><br><br><br>
                        <b><?= $guru_cb['kr_gelar_depan'] . $guru_cb['kr_nama_depan'] . ' ' . $guru_cb['kr_nama_belakang'] . " " . $guru_cb['kr_gelar_belakang'] ?></b><br>
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
