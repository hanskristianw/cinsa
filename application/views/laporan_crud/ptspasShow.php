<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center mb-4">
              <?php 
                $tanggal_ttd = date('d-m-Y');
                $tanggal_arr = explode("-",$tanggal_ttd); 
              ?>
              <h1 class="h4 text-gray-900"><u><b><?= $title ?></b></u></h1>
            </div>


            <?= $this->session->flashdata('message'); ?>
            
            <div id="print_area">
            <?php 

              foreach($kelas_all as $n) :
                $siswa = show_siswa_by_kelas($n['kelas_id']);
                
                $mapel_kelas = show_mapel_header_summary($n['kelas_id']);
                
                
                //var_dump($semester);
                
            ?>

              <h6><u><?= $n['kelas_nama'] ?></u> (<?= $tanggal_arr[0] .' '. return_nama_bulan_indo($tanggal_arr[1]) .' '.$tanggal_arr[2] ?>)</h6>
              <table class="rapot">
                <thead>
                  <tr>
                    <th rowspan="2">No Induk</th>
                    <th rowspan="2">Nama</th>
                    <?php 
                      foreach($mapel_kelas as $a) : 
                    ?>
                     <th><?= $a['mapel_sing'] ?></th> 
                    
                    <?php endforeach ?>
                    
                    <th rowspan="2">&lt;KKM</th>
                  </tr>
                  <tr>
                    <?php foreach($mapel_kelas as $a) : ?>
                      <th><?= $a['mapel_kkm'] ?></th> 
                    <?php endforeach ?>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  foreach($siswa as $o) :
                    //$uts_uas = showutsuas();
                ?>
                  <tr>
                    <td style="padding: 0px 0px 0px 5px; width: 50px;"><?= $o['sis_no_induk'] ?></td>
                    <td style="padding: 0px 0px 0px 5px; width: 230px;"><?= $o['sis_nama_depan'] .' '. $o['sis_nama_bel'] ?></td>
                    <?php 
                      $dibawah_kkm = 0;
                      foreach($mapel_kelas as $a) :
                        $uts_uas = showutsuas($a['mapel_id'],$o['d_s_id']);
                        $red = "";
                        if($pJenis == 1 && $semester == 1): //UTS SEMESTER 1
                          if(isset($uts_uas['uj_mid1_kog']) && $uts_uas['uj_mid1_kog'] < $a['mapel_kkm']){
                            $red = "background-color:#ffdac9;";
                            $dibawah_kkm++;
                          }
                          elseif(!isset($uts_uas['uj_mid1_kog'])){
                            $red = "background-color:#fcf2a7;";
                          }
                    ?>
                      <td style="text-align: center; <?=$red?> width: 45px;"><?= $uts_uas['uj_mid1_kog'] ?></td> 

                    <?php elseif($pJenis == 1 && $semester == 2): //UTS SEMESTER 2
                        if(isset($uts_uas['uj_mid2_kog']) && $uts_uas['uj_mid2_kog'] < $a['mapel_kkm']){
                          $red = "background-color:#ffdac9;";
                          $dibawah_kkm++;
                        }
                        elseif(!isset($uts_uas['uj_mid2_kog'])){
                          $red = "background-color:#fcf2a7;";
                        }
                    ?>
                      <td style="text-align: center; <?=$red?> width: 45px;"><?= $uts_uas['uj_mid2_kog'] ?></td> 
                      
                    <?php elseif($pJenis == 2 && $semester == 1): //UAS SEMESTER 1
                        if(isset($uts_uas['uj_fin1_kog']) && $uts_uas['uj_fin1_kog'] < $a['mapel_kkm']){
                          $red = "background-color:#ffdac9;";
                          $dibawah_kkm++;
                        }
                        elseif(!isset($uts_uas['uj_fin1_kog'])){
                          $red = "background-color:#fcf2a7;";
                        }
                    ?>
                      <td style="text-align: center; <?=$red?> width: 45px;"><?= $uts_uas['uj_fin1_kog'] ?></td> 

                    <?php elseif($pJenis == 2 && $semester == 2): //UAS SEMESTER 2
                        if(isset($uts_uas['uj_fin2_kog']) && $uts_uas['uj_fin2_kog'] < $a['mapel_kkm']){
                          $red = "background-color:#ffdac9;";
                          $dibawah_kkm++;
                        }
                        elseif(!isset($uts_uas['uj_fin2_kog'])){
                          $red = "background-color:#fcf2a7;";
                        }
                    ?>
                      <td style="text-align: center; <?=$red?> width: 45px;"><?= $uts_uas['uj_fin2_kog'] ?></td> 

                    <?php 
                        endif;
                      endforeach 
                    ?>
                    
                    <td style="text-align: center;"><?= $dibawah_kkm ?></td> 
                  </tr>
                  
                <?php endforeach ?>
                  <tr>
                    <td colspan="2" style="text-align: right; padding: 0px 5px 0px 5px;">RATA-RATA:</td>
                    <?php foreach($mapel_kelas as $a) : 
                      $rMapelKelas = returnRataMapelKelas($a['mapel_id'], $n['kelas_id']);
                      if($pJenis == 1 && $semester == 1)
                        echo "<td style='text-align: center;'>".round($rMapelKelas['ruj_mid1_kog'], 2)."</td>";
                      elseif($pJenis == 1 && $semester == 2)
                        echo "<td style='text-align: center;'>".round($rMapelKelas['ruj_mid2_kog'], 2)."</td>";
                      elseif($pJenis == 2 && $semester == 1)
                        echo "<td style='text-align: center;'>".round($rMapelKelas['ruj_fin1_kog'], 2)."</td>";
                      elseif($pJenis == 2 && $semester == 2)
                        echo "<td style='text-align: center;'>".round($rMapelKelas['ruj_fin2_kog'], 2)."</td>";
                    ?>
                    <?php endforeach ?>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: right; padding: 0px 5px 0px 5px;">&lt;KKM:</td>
                    <?php foreach($mapel_kelas as $a) : 
                      $kMapelKelas = returnKurangKkmKelas($a['mapel_id'], $n['kelas_id'], $pJenis, $semester);
                      echo "<td style='text-align: center;'>".$kMapelKelas['kurang']."</td>";
                    ?>
                    <?php endforeach ?>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              
              <p style="page-break-after: always;">&nbsp;</p>

            <?php endforeach ?>
            </div>
            <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success" value="Print">
            <input type="button" name="export_excel" id="export_excel" class="btn btn-primary ml-2" value="Export To Excel">
              
              
          </div>
        </div>
      </div>
    </div>
  </div>

</div>