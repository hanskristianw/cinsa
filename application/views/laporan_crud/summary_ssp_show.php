<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">

            <?php if($ssp_all): ?>

            <div class="text-center mb-4">
              <h1 class="h4 text-gray-900"><u><b>Rangkuman Nilai</b></u></h1>
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
                    <td>&rarr; Ada siswa yang belum mendapat nilai di kelas tersebut atau ada nilai dan siswa ganda</td>
                  </tr>
                  <tr>
                    <td style='width: 60px; height: 40px;'><b>Angka</b></td>
                    <td>&rarr; Jumlah nilai pada kelas tersebut</td>
                  </tr>
                  <tr>
                    <td colspan="2"><br><b><u>Klik pada nama ssp untuk melihat guru pengajar</u></b></td>
                  </tr>
                  <tr>
                    <td colspan="2"><br><b><u>Klik pada jumlah siswa untuk melihat siswa yang terdaftar</u></b></td>
                  </tr>
                  <tr>
                    <td colspan="2"><br><b><u>Klik pada nilai untuk melihat detail nilai</u></b></td>
                  </tr>
                </table>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>
              
              <?php 
                if(!$ssp_all){
                  echo "<h1 class='text-center mt-3 text-danger'>--Tidak ada SSP pada tahun ini--</h1>";
                }
              
              foreach($ssp_all as $m) : 
                $topik_ssp_all = show_topik_ssp($m['ssp_id']);
                // $arr_mapel_id = array();

                // $lebar_tabel ="";

                // if(count($mapel_kelas)<5){
                //   $lebar_tabel = "style='width:30%';";
                // }
              ?>
              <label style="font-family: 'Times New Roman', Times, serif; font-size:22px;">
                <u>
                  <a class='link-ssp-ajar' rel="<?= $m['ssp_id'] ?>"  href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                    <?= $m['ssp_nama'] ?>
                  </a>
                </u> 
                <a class='link-ssp-siswa' rel="<?= $m['ssp_id'] ?>"  href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                  (<?= $m['jumlah_siswa'] ?> siswa)
                </a>
              
              </label>
              <table class="rapot" style='width:50%;'>
                <thead>
                  <tr>
                    <th style='width: 30px;'>Sem</th>
                    <th>Topik</th>
                    <th style='width: 100px;'>Jumlah Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($topik_ssp_all as $t) : 
                    if($t['jumlah_nilai'] % $m['jumlah_siswa'] != 0)
                      $kuning = "background-color:#e9ed55;";
                    else
                      $kuning = "";
                  ?>
                    <tr>
                      <td style='padding: 0px 0px 0px 5px;'><?= $t['ssp_topik_semester'] ?></td>
                      <td style='padding: 0px 0px 0px 5px;'><?= $t['ssp_topik_nama'] ?></td>
                      <?php if($t['jumlah_nilai']==0):?>
                        <td style='padding: 0px 0px 0px 5px; background-color:#d94a02;'></td>
                      <?php else:?>
                        <td style='padding: 0px 0px 0px 5px;<?= $kuning ?>'>
                          <a class='link-ssp-nilai' rel="<?= $t['ssp_topik_id'] ?>"  href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                            <?= $t['jumlah_nilai'] ?>
                          </a>
                        </td>
                      <?php endif; ?>
                    </tr>
                  <?php endforeach; ?>
                  
                </tbody>
              </table>
              <br>
              <?php endforeach; ?>
              
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script type = "text/javascript">
  $(document).ready(function () {

    function returnnilaissp(num) {
      var kata ="";
      if(num == 1){
        kata = 'D';
      }else if(num == 2){
        kata = 'C';
      }else if(num == 3){
        kata = 'B';
      }else if(num == 4){
        kata = 'A';
      }

      return kata;
    }


    $(".link-ssp-ajar").on('click', function () {
      var ssp_id = $(this).attr("rel");
      
      $("#judul_modal").html("Guru Pengajar");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_pengajar_ssp",
        data: {
          'ssp_id': ssp_id,
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

    $(".link-ssp-siswa").on('click', function () {
      var ssp_id = $(this).attr("rel");
      
      $("#judul_modal").html("Detail nilai");

      $(".modal-dialog").addClass("modal-dialog-custom");
      $(".modal-body").addClass("modal-body-custom");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_siswa_ssp",
        data: {
          'ssp_id': ssp_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Student--</b></div>';
          } else {
            var html = '';
            var i;
            html += "<table class='rapot'>";
            html += "<thead>";
            html += "<th>No Induk</th>";
            html += "<th>Nama</th>";
            html += "</thead>";
            html += "<tbody>";
            for (i = 0; i < data.length; i++) {
              html += "<tr>";
              var nama_bel = "";
              if(data[i].sis_nama_bel[0])
                nama_bel = data[i].sis_nama_bel[0];

              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].sis_no_induk + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].sis_nama_depan + " " + nama_bel + "</td>";
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

    $(".link-ssp-nilai").on('click', function () {

      var ssp_topik_id = $(this).attr("rel");

      $(".modal-dialog").addClass("modal-dialog-custom");
      $(".modal-body").addClass("modal-body-custom");
      
      $("#judul_modal").html("Detail Nilai");
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_detail_nilai_topik_ssp",
        data: {
          'ssp_topik_id': ssp_topik_id,
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
              html += "<th>No Induk</th>";
              html += "<th>Nama</th>";
              html += "<th>Nilai</th>";
              html += "</tr>";
              html += "</thead>";
              html += "<tbody>";
              var topik = "";
            for (i = 0; i < data.length; i++) {

              html += "<tr>";
              var nama_bel = "";
              if(data[i].sis_nama_bel[0])
                nama_bel = data[i].sis_nama_bel[0];

              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].sis_no_induk + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].sis_nama_depan + " " + nama_bel + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnnilaissp(data[i].ssp_nilai_angka) + "</td>";
              
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