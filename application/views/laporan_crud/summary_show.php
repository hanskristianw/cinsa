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
                  <tr>
                    <td colspan="2"><br><b><u>Klik pada mapel untuk melihat guru pengajar</u></b></td>
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
                    <th style='width: 120px;'>Category/Subject</th>

                    <?php 
                      $mapel_kelas = show_mapel_header_summary($m['kelas_id']);
                      $arr_mapel_id = array();
                      foreach($mapel_kelas as $n) :
                    ?>
                      <th colspan='2'> 
                        <a class='link-afek' rel="<?= $n['mapel_id'] ?>" rel2="<?= $m['kelas_id'] ?>"  href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                          <?= $n['mapel_sing'] ?>
                        </a>
                      </th>
                      <?php 
                        array_push($arr_mapel_id, $n['mapel_id']);
                      ?>
                    <?php endforeach ?>
                  </tr>
                  <tr>
                    <th style='width: 120px;'>Semester</th>
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
                          
                          echo "<td style='padding: 0px 0px 0px 5px;width: 30px;".$kuning."'>
                                <a class='link-cog1' rel='".$arr_mapel_id[$i]."' rel2='".$m['kelas_id']."' rel3='1' href='javascript:void(0)'>".$sem1['jumlah']."</a>
                                </td>";
                        }

                        if($sem2['jumlah']==0)
                          echo "<td style='background-color:#d94a02;width: 30px;'></td>";
                        else{
                          if($sem2['jumlah'] % $m['jumlah_murid'] != 0)
                            $kuning = "background-color:#e9ed55;";
                          else
                            $kuning = "";

                          echo "<td style='padding: 0px 0px 0px 5px;width: 30px;".$kuning."'>
                                <a class='link-cog1' rel='".$arr_mapel_id[$i]."' rel2='".$m['kelas_id']."' rel3='1' href='javascript:void(0)'>".$sem2['jumlah']."</a>
                                </td>";
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
                            $kuning = "background-color:#e9ed55;";
                          else
                            $kuning = "";


                        if($uj['jumlah']==0)
                          echo "<td style='background-color:#d94a02;width: 30px;' colspan='2'></td>";
                        else{
                          echo "<td style='text-align:center;".$kuning."' colspan='2'><a class='link-uj' rel='".$arr_mapel_id[$i]."' rel2='".$m['kelas_id']."' href='javascript:void(0)'>".$uj['jumlah']."</a>
                          </td>";
                        }
                      }
                    ?>
                  </tr>
                  <?php foreach($bulan_aktif as $o) : ?>
                    <tr>
                      <td style='padding: 0px 0px 0px 5px;'>Afektif <?= return_nama_bulan($o['k_afek_bulan_id']) ?></td>
                      <?php 
                        for($i=0;$i<count($arr_mapel_id);$i++){
                          $af = show_af_count($o['k_afek_id'],$arr_mapel_id[$i],$m['kelas_id']);
                          //$af = show_mid_final_count($arr_mapel_id[$i],$m['kelas_id']);
                          if($af['jumlah'] % $m['jumlah_murid'] != 0)
                            $kuning = "background-color:#e9ed55;";
                          else
                            $kuning = "";

                          if($af['jumlah']==0)
                            echo "<td style='text-align:center;background-color:#d94a02;' colspan='2'></td>";
                          else
                            echo "<td style='text-align:center;".$kuning."' colspan='2'>".$af['jumlah']."</td>";
                        }
                      ?>
                    </tr>
                  <?php endforeach ?>
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

<script type = "text/javascript">
  $(document).ready(function () {
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

    $(".link-cog1").on('click', function () {
      var mapel_id = $(this).attr("rel");
      var kelas_id = $(this).attr("rel2");
      var semester = $(this).attr("rel3");

      $(".modal-dialog").addClass("modal-dialog-custom");
      $(".modal-body").addClass("modal-body-custom");
      
      $("#judul_modal").html("Detail Nilai");
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_cog_by_mapel_kelas_sem",
        data: {
          'mapel_id': mapel_id,
          'kelas_id': kelas_id,
          'semester': semester,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
          } else {
            var html = '';
            var i;
              html += "<table class='rapot'>";
              html += "<thead>";
              html += "<tr>";
              html += "<th rowspan='2'>Nama</th>";
              html += "<th colspan='3'>Kognitif</th>";
              html += "<th colspan='3'>Psikomotor</th>";
              html += "</tr>";
              html += "<tr>";
              html += "<th>Quiz</th>";
              html += "<th>Tes</th>";
              html += "<th>Ass</th>";
              html += "<th>Quiz</th>";
              html += "<th>Tes</th>";
              html += "<th>Ass</th>";
              html += "</tr>";
              html += "</thead>";
              html += "<tbody>";
              var topik = "";
            for (i = 0; i < data.length; i++) {
              
              if(topik != data[i].topik_nama){
                html += "<tr style='text-align:center;background-color:#e9ed55;'>";
                html += "<td style='width: 120px;'><b>"+data[i].topik_nama+"</b></td>";
                html += "<td><b>"+ data[i].kog_quiz_persen+"%</b></td>";
                html += "<td><b>"+ data[i].kog_test_persen+"%</b></td>";
                html += "<td><b>"+ data[i].kog_ass_persen+"%</b></td>";
                html += "<td><b>"+ data[i].psi_quiz_persen+"%</b></td>";
                html += "<td><b>"+ data[i].psi_test_persen+"%</b></td>";
                html += "<td><b>"+ data[i].psi_ass_persen+"%</b></td>";
                html += "</tr>";
              }

              html += "<tr>";
              var nama_bel = "";
              if(data[i].sis_nama_bel[0])
                nama_bel = data[i].sis_nama_bel[0];

              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].sis_nama_depan + " " + nama_bel + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].kog_quiz + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].kog_test + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].kog_ass + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].psi_quiz + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].psi_test + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].psi_ass + "</td>";
              html += "</tr>";

              topik = data[i].topik_nama;
            }
              html += "</tbody>";
              html += "</table>";
          }

          $('#isi_modal').html(html);
          $("#myModal").show();
        }
      });

    });

    $(".link-uj").on('click', function () {
      var mapel_id = $(this).attr("rel");
      var kelas_id = $(this).attr("rel2");

      $(".modal-dialog").addClass("modal-dialog-custom");
      $(".modal-body").addClass("modal-body-custom");
      
      //alert(mapel_id);
      //alert(kelas_id);

      $("#judul_modal").html("Detail Nilai");
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_uj_by_mapel_kelas",
        data: {
          'mapel_id': mapel_id,
          'kelas_id': kelas_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
          } else {
            var html = '';
            var i;
              html += "<table class='rapot'>";
              html += "<thead>";
              html += "<tr>";
              html += "<th rowspan='3'>Nama</th>";
              html += "<th colspan='4'>Semester 1</th>";
              html += "<th colspan='4'>Semester 2</th>";
              html += "</tr>";
              html += "<tr>";
              html += "<th colspan='2'>Kognitif</th>";
              html += "<th colspan='2'>Psikomotor</th>";
              html += "<th colspan='2'>Kognitif</th>";
              html += "<th colspan='2'>Psikomotor</th>";
              html += "</tr>";
              html += "<tr>";
              html += "<th style='width: 40px;'>Mid<br>"+data[0].uj_mid1_kog_persen+"%</th>";
              html += "<th style='width: 40px;'>Final<br>"+data[0].uj_fin1_kog_persen+"%</th>";
              html += "<th style='width: 40px;'>Mid<br>"+data[0].uj_mid1_psi_persen+"%</th>";
              html += "<th style='width: 40px;'>Final<br>"+data[0].uj_fin1_psi_persen+"%</th>";
              html += "<th style='width: 40px;'>Mid<br>"+data[0].uj_mid2_kog_persen+"%</th>";
              html += "<th style='width: 40px;'>Final<br>"+data[0].uj_fin2_kog_persen+"%</th>";
              html += "<th style='width: 40px;'>Mid<br>"+data[0].uj_mid2_psi_persen+"%</th>";
              html += "<th style='width: 40px;'>Final<br>"+data[0].uj_fin2_psi_persen+"%</th>";
              html += "</tr>";
              html += "</thead>";
              html += "<tbody>";
              var topik = "";
            for (i = 0; i < data.length; i++) {

              html += "<tr>";
              var nama_bel = "";
              if(data[i].sis_nama_bel[0])
                nama_bel = data[i].sis_nama_bel[0];

              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].sis_nama_depan + " " + nama_bel + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_mid1_kog + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_fin1_kog + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_mid1_psi + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_fin1_psi + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_mid2_kog + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_fin2_kog + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_mid2_psi + "</td>";
              html += "<td style='text-align:center;'>"+data[i].uj_fin2_psi + "</td>";
              html += "</tr>";
              
            }
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