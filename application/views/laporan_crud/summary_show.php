<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center mb-4">
              <h1 class="h4 text-gray-900"><u><b>Laporan Pengumpulan Nilai</b></u></h1>
            </div>
            <div class="alert alert-secondary alert-dismissible fade show">
                <button class="close" data-dismiss="alert" type="button">
                    <span>&times;</span>
                </button>
                <strong><u>Penjelasan warna dan angka:</u></strong><br>
                <table class="mt-3">
                  <tr>
                    <td style='width: 80px; height: 40px;'><div style="height: 30px; width: 30px; background-color:#d94a02;"></td>
                    <td>&rarr; Tidak ada nilai</td>
                  </tr>
                  <tr>
                    <td><div style="height: 30px; width: 30px; background-color:#f8ff00;"></td>
                    <td>&rarr; Ada siswa yang belum mendapat nilai di kelas tersebut/ ada nilai ganda</td>
                  </tr>
                  <tr>
                    <td style='width: 60px; height: 40px;'><b>Angka</b></td>
                    <td>&rarr; Jumlah nilai pada kelas tersebut</td>
                  </tr>
                </table>
            </div>

            <?= $this->session->flashdata('message'); ?>
            
              <?php foreach($kelas_all as $m) : ?>
              <label style="font-family: 'Times New Roman', Times, serif; font-size:22px;"><u><?= $m['kelas_nama'] ?></u> 
              (<?= $m['jumlah_murid'] ?> siswa)</label>
              <table class="rapot">
                <thead>
                  <tr>
                    <th style='width: 120px;' rowspan='2'>Category/Subject</th>

                    <?php 
                      $mapel_kelas = show_mapel_header_summary($m['kelas_id']);
                      $arr_mapel_id = array();
                      foreach($mapel_kelas as $n) :
                    ?>
                      <th colspan='2'><?= $n['mapel_sing'] ?></th>
                      <?php 
                        array_push($arr_mapel_id, $n['mapel_id']);
                      ?>
                    <?php endforeach ?>
                  </tr>
                  <tr>
                    <?php foreach($mapel_kelas as $n) : ?>
                      <th>1</th>
                      <th>2</th>
                    <?php endforeach ?>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style='padding: 0px 0px 0px 5px;'>Cog Psy</td>
                    <?php 
                      for($i=0;$i<count($arr_mapel_id);$i++){
                        $sem1 = show_cog_count($arr_mapel_id[$i],$m['kelas_id'],1);
                        $sem2 = show_cog_count($arr_mapel_id[$i],$m['kelas_id'],2);

                        if($sem1['jumlah']==0)
                          echo "<td style='background-color:#d94a02;width: 30px;'></td>";
                        else{
                          if($sem1['jumlah'] % $m['jumlah_murid'] != 0)
                            $kuning = "background-color:#e9ed55;";
                          else
                            $kuning = "";
                          echo "<td style='padding: 0px 0px 0px 5px;width: 30px;".$kuning."'>".$sem1['jumlah']."</td>";
                        }

                        if($sem2['jumlah']==0)
                          echo "<td style='background-color:#d94a02;width: 30px;'></td>";
                        else{
                          if($sem2['jumlah'] % $m['jumlah_murid'] != 0)
                            $kuning = "background-color:#e9ed55";
                          else
                            $kuning = "";
                          echo "<td style='padding: 0px 0px 0px 5px;width: 30px;".$kuning."'>".$sem2['jumlah']."</td>";
                        }
                      }
                    ?>
                  </tr>
                  <tr>
                    <td style='padding: 0px 0px 0px 5px;'>Mid & FInal</td>
                    <?php 
                      for($i=0;$i<count($arr_mapel_id);$i++){
                        $uj = show_mid_final_count($arr_mapel_id[$i],$m['kelas_id']);

                        if($uj['jumlah'] % $m['jumlah_murid'] != 0)
                            $kuning = "background-color:#e9ed55";
                          else
                            $kuning = "";


                        if($uj['jumlah']==0)
                          echo "<td style='background-color:#d94a02;width: 30px;' colspan='2'></td>";
                        else{
                          echo "<td style='text-align:center;".$kuning."' colspan='2'>".$uj['jumlah']."</td>";
                        }
                      }
                    ?>
                  </tr>
                </tbody>
              </table>
              <br>
              <?php endforeach ?>

              

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
