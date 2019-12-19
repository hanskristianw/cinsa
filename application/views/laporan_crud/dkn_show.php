<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-3 overflow-auto">

            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
            </div>

            <div class="alert alert-info alert-dismissible fade show mb-4">
              <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
              </button>
              <strong>INFO: </strong>
              Untuk melakukan export ke excel tekan tombol di bawah halaman, lalu besarkan kolom pada excel, jika tidak data hanya akan tampil # (pagar)
            </div>

            <?= $this->session->flashdata('message'); ?>

            <div id="print_area">
            <?php foreach($kelas_all as $n): 
              $siswa = show_siswa_by_kelas($n['kelas_id']);

              $mapel_ajar = show_mapel_header_summary_order_by_mapel_urutan($n['kelas_id']);

              //var_dump($mapel_ajar);
            ?>

              <h6><?= $n['kelas_nama'] ?></h6>
              <table class="dkn">
                <thead>
                  <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Sem</th>
                  <?php foreach($mapel_ajar as $m) : ?>
                    <th><?= $m['mapel_kkm'] ?></th>
                    <th colspan="3"><?= $m['mapel_sing'] ?></th>
                  <?php endforeach; ?>
                    <th colspan="3">Total</th>
                    <th rowspan="2">R</th>
                  </tr>
                  <tr>
                  <?php foreach($mapel_ajar as $m) : ?>
                    <th>C</th>
                    <th>P</th>
                    <th>F</th>
                    <th>A</th>
                  <?php endforeach; ?>
                    <th>C</th>
                    <th>P</th>
                    <th>F</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $no1 = 1;
                  $no2 = 1;
                  foreach($siswa as $o) :
                    //$uts_uas = showutsuas();
                  $nama = explode(" ", $o['sis_nama_bel']);
                  $total_kog = 0;
                  $total_psi = 0;
                  $total_f = 0;

                  $total_kog2 = 0;
                  $total_psi2 = 0;
                  $total_f2 = 0;
                  if($nama[0])
                   $nama = $o['sis_nama_depan']." ".$nama[0];
                  else
                   $nama = $o['sis_nama_depan'];
                ?>
                  <tr>
                    <td rowspan="2" style="text-align: center; width: 30px;"><?= $o['sis_no_induk'] ?></td>
                    <td rowspan="2" style="text-align: center; width: 170px;"><?= $nama ?></td>
                    <td style='text-align: center;'>1</td>
                    <?php foreach($mapel_ajar as $m) : 
                      $nil_fin = return_raport_fin_mapel($o['d_s_id'], 1, $n['kelas_jenj_id'], $m['mapel_id']);

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
                      $total_kog += $kognitif;
                      $total_psi += $psikomotor;
                      $total_f += $n_akhir;
                    ?>
                    <!-- Cog -->
                    <td style='width: 18px; text-align: center;'><?= $kognitif ?></td>
                    
                    <!-- Psy -->

                    <td style='width: 18px; text-align: center;'><?= $psikomotor ?></td>
                    
                    <!-- Fin -->
                      
                    <td style='width: 18px; text-align: center;'><?= $n_akhir ?></td>
                      
                    <!-- Aff -->

                    <td style='width: 18px; text-align: center;'><?= return_abjad_afek($nil_fin['total']) ?></td>


                    <?php endforeach; ?>

                    <!-- total cog -->
                    <td style='text-align: center;'><?= $total_kog ?></td>
                    <td style='text-align: center;'><?= $total_psi ?></td>
                    <td style='text-align: center;'><?= $total_f ?></td>
                    <td style='text-align: center;'><div class="semester1" id="<?= $no1 ?>" rel="<?= $total_f ?>"></div></td>
                  </tr>
                  <tr>
                    <td style='text-align: center;'>2</td>
                    <?php foreach($mapel_ajar as $m) : 
                      $nil_fin = return_raport_fin_mapel($o['d_s_id'], 2, $n['kelas_jenj_id'], $m['mapel_id']);

                      $for_kog = $nil_fin['for_kog'];
                      $for_psi = $nil_fin['for_psi'];
                      $sum_kog_sem1 = $nil_fin['sum_kog_sem1'];
                      $sum_psi_sem1 = $nil_fin['sum_psi_sem1'];
                      $sum_kog_sem2 = $nil_fin['sum_kog_sem2'];
                      $sum_psi_sem2 = $nil_fin['sum_psi_sem2'];

                      //PENGETAHUAN 
                      //formative 70
                      if ($nil_fin['persen_forma_peng'])
                        $persen_forma_peng = $nil_fin['persen_forma_peng'];
                      else
                        $persen_forma_peng = 70;

                      //summative 30
                      if ($nil_fin['persen_summa_peng'])
                        $persen_summa_peng = $nil_fin['persen_summa_peng'];
                      else
                        $persen_summa_peng = 30;

                      //KETRAMPILAN
                      //formative 70
                      if ($nil_fin['persen_forma_ket'])
                        $persen_forma_ket = $nil_fin['persen_forma_ket'];
                      else
                        $persen_forma_ket = 70;

                      //summative 30
                      if ($nil_fin['persen_summa_ket'])
                        $persen_summa_ket = $nil_fin['persen_summa_ket'];
                      else
                        $persen_summa_ket = 30;

                      //AKHIR
                      //pengetahuan 50 ketrampilan 50
                      if ($nil_fin['persen_peng_akhir'])
                        $persen_peng_akhir = $nil_fin['persen_peng_akhir'];
                      else
                        $persen_peng_akhir = 50;

                      if ($nil_fin['persen_ket_akhir'])
                        $persen_ket_akhir = $nil_fin['persen_ket_akhir'];
                      else
                        $persen_ket_akhir = 50;

                      $kognitif = round($for_kog * $persen_forma_peng / 100 + $sum_kog_sem2 * $persen_summa_peng / 100);
                      $psikomotor = round($for_psi * $persen_forma_ket / 100 + $sum_psi_sem2 * $persen_summa_ket / 100);

                      $n_akhir = round($kognitif * $persen_peng_akhir / 100 + $psikomotor * $persen_ket_akhir / 100);

                      $total_kog2 += $kognitif;
                      $total_psi2 += $psikomotor;
                      $total_f2 += $n_akhir;
                    ?>
                      <!-- Cog -->
                      <td style='width: 18px; text-align: center;'><?= $kognitif ?></td>
                      
                      <!-- Psy -->

                      <td style='width: 18px; text-align: center;'><?= $psikomotor ?></td>
                      
                      <!-- Fin -->
                        
                      <td style='width: 18px; text-align: center;'><?= $n_akhir ?></td>
                        
                      <!-- Aff -->

                      <td style='width: 18px; text-align: center;'><?= return_abjad_afek($nil_fin['total']) ?></td>


                    <?php endforeach; ?>
                    
                    <!-- total cog -->
                    <td style='text-align: center;'><?= $total_kog2 ?></td>
                    <td style='text-align: center;'><?= $total_psi2 ?></td>
                    <td style='text-align: center;'><?= $total_f2 ?></td>
                    <td style='text-align: center;'><div id="<?= $no2 ?>" class="semester2" rel="<?= $total_f2 ?>"></div></td>
                  </tr>
                <?php   
                  $no1++;
                  $no2++;
                  endforeach;
                ?>
                </tbody>
              </table>
              
              <br>
            <?php endforeach;?>
            </div>
            
            <input type="button" name="export_excel" id="export_excel" class="btn btn-success mt-2" value="Export To Excel">

          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<script type="text/javascript">
  $(document).ready(function() {
    function sortNumber(a, b) {
      return b - a;
    }

    var nilai_arr = [];
    $(".semester1").each(function() {
      nilai_arr.push($(this).attr('rel'));
    });
    //console.log(nilai_arr);

    var nilai_arr_urut;
    nilai_arr_urut = nilai_arr.sort(sortNumber);
    //console.log(nilai_arr_urut);
    
    $(".semester1").each(function() {
      var rank = nilai_arr.indexOf($(this).attr('rel'));
      $(this).html(rank+1);
      //console.log(rank);
    });

    var nilai_arr2 = [];
    $(".semester2").each(function() {
      nilai_arr2.push($(this).attr('rel'));
    });

    var nilai_arr_urut2;
    nilai_arr_urut2 = nilai_arr2.sort(sortNumber);
    //console.log(nilai_arr_urut2);
    
    $(".semester2").each(function() {
      var rank2 = nilai_arr_urut2.indexOf($(this).attr('rel'));
      $(this).html(rank2+1);
    });
  });
</script>