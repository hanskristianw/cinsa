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
              <h1 class="h4 text-gray-900"><u><b>Rata-Rata Nilai Afektif Berdasarkan Bulan</b></u></h1>
              <h1 class="h4 text-gray-900"><u><b><?= $bulan_nama ?></b></u></h1>
            </div>
            <div class="alert alert-secondary alert-dismissible fade show">
                <button class="close" data-dismiss="alert" type="button">
                    <span>&times;</span>
                </button>
                <table>
                  <tr>
                    <td style='width: 100px; height: 40px;'><b>Range Nilai</b></td>
                    <td>&rarr; <?= "A>=7.65 &nbsp B>=6.3 &nbsp C>=4.95 &nbsp D<4.95" ?> </td>
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
                    <th style='width: 50px; padding: 0px 0px 5px 0px;'>No</th>
                    <th style='width: 200px;'>Nama Siswa</th>
                    <?php 
                      for($i=0;$i<count($bulan_id);$i++){
                        $nama_kriteria = return_nama_kriteria_afektif($bulan_id[$i],$t_id,$sk_id);
                        echo "<th>".$nama_kriteria['k_afek_topik_nama']."<br>(".$nama_kriteria['bulan_nama'].")</th>";
                      } 
                    ?>
                    <th>Mean</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $siswa = show_siswa_by_kelas($m['kelas_id']);
                    foreach($siswa as $n) : 
                      $total = 0;
                      $pembagi = 0;
                  ?>
                      <tr>
                        <td style='padding: 0px 0px 0px 5px;'><?= $n['sis_no_induk'] ?></td>
                        <td style='padding: 0px 0px 0px 5px;'><?= $n['sis_nama_depan'] .' '. $n['sis_nama_bel'] ?></td>
                        <?php 
                          for($i=0;$i<count($bulan_id);$i++){
                            $nil = return_nilai_afek_perbulan($bulan_id[$i],$n['d_s_id']);
                            if($nil['rata']){
                              echo "<td style='text-align: center;'>".$nil['rata']."(".return_abjad_afek($nil['rata']).")"."</td>";
                              $total += $nil['rata'];
                              $pembagi++;
                            }
                            else
                              echo "<td style='text-align: center;'>-</td>";
                          } 
                          //echo "<td>".$n['d_s_id']."</td>";
                        ?>
                        <?php if($pembagi!=0):?>
                          <td style='text-align: center;'><?= round($total/$pembagi,2)."(".return_abjad_afek(round($total/$pembagi,2)).")" ?></td>
                        <?php else:?>
                          <td style='text-align: center;'>-</td>
                        <?php endif; ?>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
              <br>
              <?php endforeach; ?>
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
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnnamabulan(data[i].k_afek_bulan_id) + "<br>("+data[i].k_afek_topik_nama+")</td>";
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