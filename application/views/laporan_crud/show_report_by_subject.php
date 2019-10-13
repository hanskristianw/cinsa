<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center mb-4">
              <?php
                $bulan_nama = "";
                $bulan_nama_angka = "";
                for($i=0;$i<count($bulan_id);$i++){
                  $bulan_nama_angka .= $bulan_id[$i];
                  $bulan_nama .= return_nama_bulan($bulan_id[$i]);
              
                  if($i != count($bulan_id)-1){
                    $bulan_nama .= ", ";
                    $bulan_nama_angka .= ", ";
                  }
                }
              ?>
              <h1 class="h4 text-gray-900"><u><b>Rata-Rata Nilai Afektif</b></u></h1>
              <h1 class="h4 text-gray-900"><u><b>Bulan <?= $bulan_nama ?></b></u></h1>
            </div>
            <div class="alert alert-secondary alert-dismissible fade show">
                <button class="close" data-dismiss="alert" type="button">
                    <span>&times;</span>
                </button>
                <table class="mt-3">
                  <tr>
                    <td style='width: 100px; height: 40px;'><b>Range Nilai</b></td>
                    <td>&rarr; <?= "A>=7.65 &nbsp B>=6.3 &nbsp C>=4.95 &nbsp D<4.95" ?> </td>
                  </tr>
                  <tr>
                    <td style='width: 100px; height: 40px;'><div style="height: 30px; width: 30px; background-color:#f2aab4;"></td>
                    <td>&rarr; Nilai <=C</td>
                  </tr>
                  <tr>
                    <td><div style="height: 30px; width: 30px; background-color:#f8ff00;"></td>
                    <td>&rarr; Tidak ada nilai, hubungi guru pengajar</td>
                  </tr>
                  <tr>
                    <td colspan="2"><br><b>Rata - rata didapat dari total nilai / jumlah mapel YANG SUDAH mengisi</b></td>
                  </tr>
                  <tr>
                    <td colspan="2"><br><b><u>Klik pada MAPEL untuk melihat guru pengajar, dan NILAI untuk melihat detail nilai</u></b></td>
                  </tr>
                </table>
            </div>

            <?= $this->session->flashdata('message'); ?>
              <div id="print_area">
              <?php foreach($kelas_all as $m) : 
              ?>
              <label style="font-family: 'Times New Roman', Times, serif; font-size:22px;"><u><?= $m['kelas_nama'] ?></u> 
              (<?= $m['jumlah_murid'] ?> siswa)</label>
              <table class="rapot">
                <thead>
                  <tr>
                    <th style='width: 60px;'>No Induk</th>
                    <th style='width: 120px;'>Nama Siswa</th>

                    <?php 
                      $mapel_kelas = show_mapel_header_summary($m['kelas_id']);
                      $arr_mapel_id = array();
                      foreach($mapel_kelas as $n) :
                    ?>
                      <th style='width: 30px;' colspan="2"> 
                        <a class='link-afek' rel="<?= $n['mapel_id'] ?>" rel2="<?= $m['kelas_id'] ?>"  href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                          <?= $n['mapel_sing'] ?>
                        </a>
                      </th>
                      <?php 
                        array_push($arr_mapel_id, $n['mapel_id']);
                      ?>
                    <?php endforeach ?>
                    <th colspan="2">Mean</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $siswa = show_siswa_by_kelas($m['kelas_id']);
                    $rata_total = 0;
                    $rekap_nilai = array();
                    $tampung_nama_siswa = array();
                    foreach($siswa as $n) : 
                  ?>
                    <tr>
                      <td style='padding: 0px 0px 0px 5px;'><?= $n['sis_no_induk'] ?></td>
                      <?php
                        array_push($tampung_nama_siswa,$n['sis_nama_depan']);
                        $bel = "";
                        if(isset($n['sis_nama_bel'][0]))
                          $bel = $n['sis_nama_bel'][0];
                        else
                          $bel = "";
                      ?>
                      <td style='padding: 0px 0px 0px 5px;'><?= $n['sis_nama_depan'] .' '. $bel ?></td>

                      <?php
                        $rata = 0;
                        $jum_mapel = 0;
                        for($i=0;$i<count($arr_mapel_id);$i++){
                          //siswa id dan mapel id, bulan id
                          $nilai_siswa = hitung_afek_siswa_perbulan($bulan_id, $n['d_s_id']);
                          $flag = 0;
                          $red = "";
                          foreach($nilai_siswa as $z){
                            if($z['afektif_mapel_id'] == $arr_mapel_id[$i]){
                              if(return_abjad_afek(round($z['total'],2)) == "D" || return_abjad_afek(round($z['total'],2)) == "C"){
                                $red = "background-color:#f2aab4;";
                              }else{
                                $red = "";
                              }
                              echo "<td style='text-align:center;".$red."'>
                                    <a class='link-detail' rel='".$arr_mapel_id[$i]."' rel2='".$n['d_s_id']."' rel3='".$bulan_nama_angka."' href='javascript:void(0)' data-toggle='myModal2' data-target='#myModal2'>".$z['total']."</a></td>";
                              echo "<td style='text-align:center;".$red."'>".return_abjad_afek(round($z['total'],2))."</td>";
                              $rata += round($z['total'],2);
                              $jum_mapel += 1;
                              $flag = 1;
                            }
                          }
                          if($flag == 0){
                            echo "<td style='text-align:center;background-color:#e9ed55;' colspan='2'></td>";
                          }
                          //echo "<td>".$n['d_s_id']."</td>";
                        }
                        
                        //RATA-RATA
                        if($jum_mapel != 0){
                          $r = round($rata/$jum_mapel,2);
                          $rata_total += $r;
                          array_push($rekap_nilai,$r);
                          echo "<td style='text-align:center;'>".$r."</td>";
                          echo "<td style='text-align:center;'>".return_abjad_afek($r)."</td>";
                        }else{
                          echo "<td style='text-align:center;'>0</td>";
                          echo "<td style='text-align:center;'>D</td>";
                        }
                      ?>
                    </tr>
                  <?php endforeach; 
                    if(count($rekap_nilai)>0){
                      $tertinggi = max($rekap_nilai);
                    }
                    $index_siswa = array();
                  ?>
                  <tr style='border: 3px solid #ddd; border-top: 3px double #ddd; height: 50px; text-align:center; vertical-align:middle;'>
                    <td colspan="<?= count($arr_mapel_id)*2 +2 ?>">Nilai Tertinggi: 
                        
                      <?php 
                        if(count($rekap_nilai)>0){
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
                        }
                        else{
                          echo " - ";
                        }
                      ?>
                    
                    </td>
                    <td style='border: 3px solid #ddd; border-top: 3px double #ddd;' colspan="2"><?= round($rata_total/$m['jumlah_murid'],2) ?></td>
                  </tr>
                </tbody>
              </table>
              <br>
              <?php endforeach ?>
              </div>

              <input type="button" name="export_excel" id="export_excel" class="btn btn-success mt-2 ml-2" value="Export To Excel">
              <!-- <input type="button" id="print_rekap" class="btn btn-primary mt-2 ml-2" value="Print"> -->
              
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script type = "text/javascript">
  $(document).ready(function () {
    function roundToTwo(num) {
      return +(Math.round(num + "e+2")  + "e-2");
    }

    function returnnamabulan(num) {
      var kata ="";
      if(num == 1){
        kata = 'January';
      }else if(num == 2){
        kata = 'February';
      }else if(num == 3){
        kata = 'March';
      }else if(num == 4){
        kata = 'April';
      }else if(num == 5){
        kata = 'May';
      }else if(num == 6){
        kata = 'June';
      }else if(num == 7){
        kata = 'July';
      }else if(num == 8){
        kata = 'August';
      }else if(num == 9){
        kata = 'September';
      }else if(num == 10){
        kata = 'October';
      }else if(num == 11){
        kata = 'November';
      }else if(num == 12){
        kata = 'December';
      }else{
        kata = '';
      }

      return kata;
    }

    $(".link-afek").on('click', function () {
      var mapel_id = $(this).attr("rel");
      var kelas_id = $(this).attr("rel2");
      $("#judul_modal").html("Guru Pengajar");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_pengajar_by_mapel",
        data: {
          'mapel_id': mapel_id,
          'kelas_id': kelas_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Teacher--</b></div>';
          } else {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
              if (data[i].kr_nama_depan) {
                html += data[i].kr_nama_depan + " " + data[i].kr_nama_belakang + "<br>";
              }
            }
          }

          $('#isi_modal').html(html);
          $("#myModal").show();
        }
      });

    });

    $(".link-detail").on('click', function () {
      var mapel_id = $(this).attr("rel");
      var d_s_id = $(this).attr("rel2");
      var bulan_id = $(this).attr("rel3");

      //alert(bulan_id);
      $("#judul_modal").html("Detail nilai afektif");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_detail_nilai_afek",
        data: {
          'mapel_id': mapel_id,
          'd_s_id': d_s_id,
          'bulan_id': bulan_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Teacher--</b></div>';
          } else {
            var html = '';
            var i;
              html += "<table class='rapot'>";
              html += "<thead>";
              html += "<tr>";
              html += "<th rowspan='2'>Bulan</th>";
              html += "<th colspan='3'>Minggu1</th>";
              html += "<th colspan='3'>Minggu2</th>";
              html += "<th colspan='3'>Minggu3</th>";
              html += "<th colspan='3'>Minggu4</th>";
              html += "<th colspan='3'>Minggu5</th>";
              html += "<th rowspan='2'>Mean</th>";
              html += "</tr>";
              html += "<tr>";
              html += "<th>i1</th>";
              html += "<th>i2</th>";
              html += "<th>i3</th>";
              html += "<th>i1</th>";
              html += "<th>i2</th>";
              html += "<th>i3</th>";
              html += "<th>i1</th>";
              html += "<th>i2</th>";
              html += "<th>i3</th>";
              html += "<th>i1</th>";
              html += "<th>i2</th>";
              html += "<th>i3</th>";
              html += "<th>i1</th>";
              html += "<th>i2</th>";
              html += "<th>i3</th>";
              html += "</tr>";
              html += "</thead>";
              html += "<tbody>";
              var total = 0;
            for (i = 0; i < data.length; i++) {

              html += "<tr>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnnamabulan(data[i].k_afek_bulan_id) + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu1a1 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu1a2 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu1a3 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu2a1 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu2a2 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu2a3 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu3a1 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu3a2 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu3a3 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu4a1 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu4a2 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu4a3 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu5a1 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu5a2 + "</td>";
              html += "<td style='text-align:center;'>"+data[i].afektif_minggu5a3 + "</td>";
              var rata = roundToTwo(data[i].jumlah);
              html += "<td style='text-align:center;'>"+ rata + "</td>";
              html += "</tr>";
              
              total += roundToTwo(rata);

            }
              html += "<tr>";
              html += "<td style='text-align:center;' colspan='16'>Rata-rata</td>";
              html += "<td style='text-align:center;'>"+ roundToTwo(total/data.length) + "</td>";
              html += "</tr>";
              html += "</tbody>";
              html += "</table>";
          }

          $('#isi_modal').html(html);
          $("#myModal").show();
        }
      });

    });


  });
</script>