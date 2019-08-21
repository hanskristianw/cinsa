<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
              <div class="p-5 overflow-auto">
                <?php if(!empty($afektif_all)): ?>
                  <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4"><b><u>Affective Score Report <?= return_nama_bulan($bulan_id); ?> <?= $afektif_all[0]['kelas_nama'] ?></u></b></h1>
                  </div>
                  <?php echo '<div class="alert alert-primary alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <div class="text-center">
                    <strong>INFO:</strong> <br> A>=7.65 B>=6.3 C>=4.95 D<4.95 <br><br>
                    <strong>SCORE:</strong> <br>
                    1: '.$k_afek['k_afek_instruksi_1'].'<br>
                    2: '.$k_afek['k_afek_instruksi_2'].'<br>
                    3: '.$k_afek['k_afek_instruksi_3'].'

                    <br></br><strong>INDICATOR:</strong> <br>
                    1: '.$k_afek['k_afek_1'].'<br>
                    2: '.$k_afek['k_afek_2'].'<br>
                    3: '.$k_afek['k_afek_3'].'
                    </div>
                </div>'; ?>

                  <?= $this->session->flashdata('message'); ?>

                  <table class="table table-sm table-bordered">
                    <thead>
                      <tr>
                        <th>Reg Num</th>
                        <th>Name</th>
                        <?php 
                          foreach ($mapel_header as $m){
                            echo "<th class='text-center' colspan='2'>".$m['mapel_sing']."</th>";
                          }
                        ?>
                        <th class='text-center' colspan='2'>Mean</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      
                      $rekap_nilai = array();
                      $tampung_nama_siswa = array();
                      foreach($afektif_all as $m) : 
                        $snb = $m['sis_nama_bel'];
                        $total_nilai = 0;
                        $pembagi_total = 0;
                      ?>
                        <tr>
                          <td style='width: 80px;'><?= $m['sis_no_induk'] ?></td>
                          <td><?php 
                                array_push($tampung_nama_siswa,$m['sis_nama_depan']);
                                echo ucwords(strtolower($m['sis_nama_depan']))." "; if(strlen($snb) > 0){echo $snb[0];}
                              ?>
                          </td>
                          <?php
                            foreach ($mapel_header as $s){
                              if(!$m[$s['mapel_sing']])
                                echo "<td class='text-center' colspan='2'>-</td>";
                              else{
                                $red = "";
                                $red_total = "";
                                if(return_abjad_afek(round($m[$s['mapel_sing']],2)) == "D" || return_abjad_afek(round($m[$s['mapel_sing']],2)) == "C"){
                                  $red = "table-danger";
                                }
                                $total_nilai += round($m[$s['mapel_sing']],2);
                                $pembagi_total += 1;
                                echo "<td class='text-center $red'>".round($m[$s['mapel_sing']],2)."</td>";
                                echo "<td class='text-center $red'>".return_abjad_afek(round($m[$s['mapel_sing']],2))."</td>";
                              }
                            }

                            array_push($rekap_nilai,round($total_nilai/$pembagi_total,2));
                            
                            if(return_abjad_afek(round($total_nilai/$pembagi_total,2)) == "D" || return_abjad_afek(round($total_nilai/$pembagi_total,2)) == "C"){
                              $red_total = "table-danger";
                            }
                          ?>
                          
                          <td class='text-center <?= $red_total ?>' ><?= round($total_nilai/$pembagi_total,2) ?></td>
                          <td class='text-center <?= $red_total ?>' ><?= return_abjad_afek(round($total_nilai/$pembagi_total,2)) ?></td>
                        </tr>
                        
                      <?php 
                      
            
                        endforeach; 
                        
                        $tertinggi = max($rekap_nilai);
                        $index_siswa = array();
                        echo "<tr style='border: 3px solid #ddd; border-top: 3px double #ddd;;'><td><b>Nilai Tertinggi<b></td><td style='text-align:center;vertical-align:middle' colspan= ".(count($mapel_header)*2+4).">";
                        for($j=0;$j<count($rekap_nilai);$j++){
                            if($tertinggi==$rekap_nilai[$j]){
                                array_push($index_siswa,$j);
                            }
                        }
                        for($k=0;$k<count($index_siswa);$k++){
                            echo $tampung_nama_siswa[$index_siswa[$k]];
                            echo "(".$tertinggi.")";
                            if($k != count($index_siswa)-1){
                                echo ", ";
                            }
                            else{
                                echo ".";
                            }
                        }
                        echo "</tr>";
                      ?>
                    </tbody>
                  </table>
                  <hr>
              <?php 
                else:
                  echo '<h1 class="text-center text-danger">--NO DATA AVAILABLE--</h1>';
                endif; ?>
              </div>
            </div>
        </div>
        </div>
    </div>

</div>
