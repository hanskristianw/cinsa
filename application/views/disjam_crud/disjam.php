<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
            </div>
            <div class="p-2"><?= $this->session->flashdata('message'); ?></div>

            <table class="table table-hover table-bordered table-sm">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th style='width: 8%' >Status</th>
                  <th style='width: 8%' >Mapel</th>
                  <?php 
                    $kelas_id = array();
                  foreach ($kelas_all as $m) : 
                    array_push($kelas_id, $m['kelas_id']);
                    echo "<th style='width: 5%'>".ucfirst(strtolower ($m['kelas_nama']))."</th>";
                  ?>
                  <?php endforeach ?>
                  <th style='width: 5%' >Tot</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; $temp=""; foreach ($kr_all as $m) : 
                  // $mapel_id_dis = explode(",",$m['mapel_id_dis']);
                  $beban_jam = explode(",",$m['beban_jam']);
                  $kelas_id_ajar = explode(",",$m['kelas_id']);
                ?>
                  <tr>
                  <?php 
                    $initial = $m['kr_id'];
                    if ($temp == $initial): ?>
                      <td></td>
                      <td></td>
                      <td></td>
                  <?php 
                    else: ?>
                      <td><?php echo $no; $no++; ?></td>
                      <td><?= $m['kr_nama_depan'] ." ".$m['kr_nama_belakang'] ?></td>
                      <td><?= $m['st_nama'] ?></td>
                  <?php 
                    endif; 
                    
                    $next = $m['kr_id'];
                    $temp = $next;
                  ?>

                    <td><?= $m['mapel_nama'] ?></td>
                    <?php
                      for($j=0;$j<count($kelas_id);$j++){
                        echo "<td>";
                        for($k=0;$k<count($kelas_id_ajar);$k++){
                          if($kelas_id[$j]==$kelas_id_ajar[$k]){
                            echo $beban_jam[$k];
                          }
                        }
                        echo "</td>";
                      }
                    ?>
                    <td><?= array_sum($beban_jam) ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>