<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="alert alert-info alert-dismissible fade show mb-4">
              <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
              </button>

              <h4><u><b>Perhitungan nilai akhir</b></u></h4>
              <div style="font-family:Cambria, sans-serif;font-size:12px;" class="mb-2">* Masing - masing persentase mapel dapat diset secara dinamis oleh wakakur, hubungi wakakur sekolah masing-masing untuk info lebih lanjut</div>

              <table>
                <tr>
                  <td><b>Formative</b></td>
                  <td>: total nilai harian (Quiz, Tes, Ass) / jumlah topik terisi </td>
                </tr>
                <tr>
                  <td><b>Summative</b></td>
                  <td>: UTS x persentase + UAS x persentase </td>
                </tr>
                <tr>
                  <td><b>Nilai Kognitif</b></td>
                  <td>: (formative x % formative pengetahuan) + (summative x % summative pengetahuan)</td>
                </tr>
                <tr>
                  <td><b>Nilai Psikomotor</b></td>
                  <td>: (formative x % formative ketrampilan) + (summative x % summative ketrampilan)</td>
                </tr>
                <tr>
                  <td><b>Nilai Akhir</b></td>
                  <td>: (kognitif x % pengetahuan akhir) + (ketrampilan x % ketrampilan akhir)</td>
                </tr>
              </table>


            </div>

            <div class="alert alert-info alert-dismissible fade show mb-4">
              <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
              </button>
              <b>Klik nilai cognitive, psychomotor dan nilai akhir untuk melihat detail perhitungan</b>
            </div>

            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Laporan Nilai Akhir</u></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <?php foreach($kelas_all as $n):
              $siswa = show_siswa_by_kelas($n['kelas_id']);

              $mapel_ajar = get_mapel_ajar_kelas_kr($n['kelas_id'], $kr_id);

              //var_dump($mapel_ajar);
            ?>

              <h6><u><?= $n['kelas_nama'] ?></u> - <?= $n['sk_nama'] ?></h6>
              <table class="rapot">
                <thead>
                  <tr>
                    <th rowspan="2">No Induk</th>
                    <th rowspan="2">Nama</th>
                  <?php foreach($mapel_ajar as $m) : ?>
                    <th colspan="4"><?= $m['mapel_sing'] ?></th>
                  <?php endforeach; ?>
                  </tr>
                  <tr>
                  <?php foreach($mapel_ajar as $m) : ?>
                    <th>Cognitive</th>
                    <th>Psychomotor</th>
                    <th>Final</th>
                    <th>Affective</th>
                  <?php endforeach; ?>
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
                    <?php foreach($mapel_ajar as $m) :
                      $nil_fin = return_raport_fin_mapel($o['d_s_id'], $semester, $n['kelas_jenj_id'], $m['mapel_id'], $t_id);

                      if(isset($nil_fin)){
                        $for_kog = $nil_fin['for_kog'];
                        $for_psi = $nil_fin['for_psi'];
                        $sum_kog_sem1 = $nil_fin['sum_kog_sem1'];
                        $sum_psi_sem1 = $nil_fin['sum_psi_sem1'];
                        $sum_kog_sem2 = $nil_fin['sum_kog_sem2'];
                        $sum_psi_sem2 = $nil_fin['sum_psi_sem2'];
                      }
                      else{
                        $for_kog = 0;
                        $for_psi = 0;
                        $sum_kog_sem1 = 0;
                        $sum_psi_sem1 = 0;
                        $sum_kog_sem2 = 0;
                        $sum_psi_sem2 = 0;
                      }


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

                      if ($semester == 1) {
                        $kognitif = round($for_kog * $persen_forma_peng / 100 + $sum_kog_sem1 * $persen_summa_peng / 100);
                        $psikomotor = round($for_psi * $persen_forma_ket / 100 + $sum_psi_sem1 * $persen_summa_ket / 100);

                        $n_akhir = round($kognitif * $persen_peng_akhir / 100 + $psikomotor * $persen_ket_akhir / 100);
                      } elseif ($semester == 2) {
                        $kognitif = round($for_kog * $persen_forma_peng / 100 + $sum_kog_sem2 * $persen_summa_peng / 100);
                        $psikomotor = round($for_psi * $persen_forma_ket / 100 + $sum_psi_sem2 * $persen_summa_ket / 100);

                        $n_akhir = round($kognitif * $persen_peng_akhir / 100 + $psikomotor * $persen_ket_akhir / 100);
                      }

                    ?>

                      <!-- cognitive -->
                      <td style='text-align: center;'>
                        <a class='link-kog' style="text-decoration : none; color: inherit;" rel="<?= $m['mapel_id'] ?>" rel2="<?= $o['d_s_id'] ?>" rel3="<?= $semester ?>" rel4="<?= $persen_forma_peng ?>" rel5="<?= $persen_summa_peng ?>" href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                          <?= $kognitif ?>
                        </a>
                      </td>
                      <!-- psychomotor -->
                      <td style='text-align: center;'>
                        <a class='link-psi' style="text-decoration : none; color: inherit;" rel="<?= $m['mapel_id'] ?>" rel2="<?= $o['d_s_id'] ?>" rel3="<?= $semester ?>" rel4="<?= $persen_forma_ket ?>" rel5="<?= $persen_summa_ket ?>" href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                          <?= $psikomotor ?>
                        </a>
                      </td>


                      <!-- final -->
                      <td style='text-align: center;'>
                        <a class='link-akhir' style="text-decoration : none; color: inherit;" rel="<?= $kognitif ?>" rel2="<?= $psikomotor ?>" rel3="<?= $persen_peng_akhir ?>" rel4="<?= $persen_ket_akhir ?>" href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2">
                          <?= $n_akhir ?>
                        </a>
                      </td>

                      <!-- affective -->
                      <td style='text-align: center;'>
                        <?php
                          if(isset($nil_fin['total'])){
                            echo return_abjad_afek($nil_fin['total']);
                          }
                          else{
                            echo "-";
                          }
                         ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>
                <?php
                  endforeach;
                ?>
                </tbody>
              </table>
              <br>
            <?php endforeach;?>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<script type="text/javascript">
  $(document).ready(function() {

    $(".link-kog").on('click', function() {
      var mapel_id = $(this).attr("rel");
      var d_s_id = $(this).attr("rel2");
      var semester = $(this).attr("rel3");

      var persen_forma_peng = $(this).attr("rel4");
      var persen_summa_peng = $(this).attr("rel5");

      $("#judul_modal").html("Detail Nilai Pengetahuan");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      //alert(mapel_id);
      $.ajax({
        type: "post",
        url: base_url + "API/get_formative_by_mapel",
        data: {
          'mapel_id': mapel_id,
          'd_s_id': d_s_id,
          'semester': semester,
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Formative Data--</b></div>';
          } else {
            var html = '';
            var html2 = "";
            var i;
            html += "<label><u>Formative</u></label>"
            html += "<table class='rapot'>";
            html += "<tr>"
            html += "<th>Nama</th>";
            html += "<th>Quiz x %</th>";
            html += "<th>Test x %</th>";
            html += "<th>Ass x %</th>";
            html += "<th>Total</th>";
            html += "</tr>"
            var total_akhir = 0;
            for (i = 0; i < data.length; i++) {
              html += "<tr>"
              html += "<td style='width: 180px; padding: 0px 0px 0px 5px;'>" + data[i].topik_nama + "</td>";

              var total = 0;
              var hasil_quiz = data[i].kog_quiz * data[i].kog_quiz_persen / 100;
              var hasil_test = data[i].kog_test * data[i].kog_test_persen / 100;
              var hasil_ass = data[i].kog_ass * data[i].kog_ass_persen / 100;
              total += hasil_quiz + hasil_test + hasil_ass;
              var roundtotal = Math.round(total);
              total_akhir += roundtotal;
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].kog_quiz + "x" + data[i].kog_quiz_persen / 100 + " = " + hasil_quiz + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].kog_test + "x" + data[i].kog_test_persen / 100 + " = " + hasil_test + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].kog_ass + "x" + data[i].kog_ass_persen / 100 + " = " + hasil_ass + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + total + "~ " + roundtotal + "</td>";
              html += "</tr>"
            }

            var total_akhir_forma = total_akhir / data.length;
            var roundtotal_akhir_forma = Math.round(total_akhir_forma);

            html += "<tr>"
            html += "<td style='padding: 0px 0px 0px 5px;'>Formative</td>";
            html += "<td colspan='4' style='padding: 0px 0px 0px 5px;'>" + total_akhir_forma + "~ "+roundtotal_akhir_forma+"</td>";
            html += "</tr>"
            html += "</table>";

            $.ajax({
              type: "post",
              url: base_url + "API/get_summative_by_mapel",
              data: {
                'mapel_id': mapel_id,
                'd_s_id': d_s_id,
              },
              async: true,
              dataType: 'json',
              success: function(data) {
                if (data.length == 0) {
                  html2 += '<div class="text-center mb-3 text-danger"><b>--No Summative Data--</b></div>';
                } else {
                  var i;
                  html2 += "<label class='mt-3'><u>Summative</u></label>"
                  html2 += "<table class='rapot'>";
                  html2 += "<tr>"
                  html2 += "<th>PTS x %</th>";
                  html2 += "<th>PAS x %</th>";
                  html2 += "</tr>"
                  var total_akhir_sum = 0;
                  for (i = 0; i < data.length; i++) {
                    if (semester == 1) {
                      var hasil_pts = data[i].uj_mid1_kog * data[i].uj_mid1_kog_persen / 100;
                      var hasil_pas = data[i].uj_fin1_kog * data[i].uj_fin1_kog_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid1_kog + "x" + data[i].uj_mid1_kog_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin1_kog + "x" + data[i].uj_fin1_kog_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    } else if (semester == 2) {
                      var hasil_pts = data[i].uj_mid2_kog * data[i].uj_mid2_kog_persen / 100;
                      var hasil_pas = data[i].uj_fin2_kog * data[i].uj_fin2_kog_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid2_kog + "x" + data[i].uj_mid2_kog_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin2_kog + "x" + data[i].uj_fin2_kog_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    }

                  }

                  total_akhir_sum = hasil_pts + hasil_pas;

                  var roundtotal_akhir_sum = Math.round(total_akhir_sum);
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>Total</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + total_akhir_sum + " ~"+roundtotal_akhir_sum+"</td>";
                  html2 += "</tr>"

                  html2 += "</table>";

                  var akhir_kognitif = roundtotal_akhir_forma * persen_forma_peng / 100 + roundtotal_akhir_sum * persen_summa_peng / 100;
                  var akhir_forma = roundtotal_akhir_forma * persen_forma_peng / 100;
                  var akhir_summa = roundtotal_akhir_sum * persen_summa_peng / 100;

                  var roundakhir_kognitif = Math.round(akhir_kognitif);

                  html2 += "<table class='rapot mt-3'>";
                  html2 += "<tr>"
                  html2 += "<th>"
                  html2 += "Formative x % formative"
                  html2 += "</th>"
                  html2 += "<th>"
                  html2 += "Summative x % Summative"
                  html2 += "</th>"
                  html2 += "</tr>"
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_forma + "x" + persen_forma_peng / 100 + "= " + akhir_forma + "</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_sum + "x" + persen_summa_peng / 100 + "= " + akhir_summa + "</td>";
                  html2 += "</tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;' colspan='2'>Nilai Akhir Kognitif: " + akhir_kognitif + " ~"+roundakhir_kognitif+"</td>";
                  html2 += "</tr>"
                  html2 += "</table>";
                }

                //console.log(html2);

                $('#isi_modal').html(html + html2);
                $("#myModal").show();
              }
            });
          }
        }
      });
    });

    $(".link-psi").on('click', function() {
      var mapel_id = $(this).attr("rel");
      var d_s_id = $(this).attr("rel2");
      var semester = $(this).attr("rel3");

      var persen_forma_ket = $(this).attr("rel4");
      var persen_summa_ket = $(this).attr("rel5");

      $("#judul_modal").html("Detail Nilai Ketrampilan");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      //alert(mapel_id);
      $.ajax({
        type: "post",
        url: base_url + "API/get_formative_by_mapel",
        data: {
          'mapel_id': mapel_id,
          'd_s_id': d_s_id,
          'semester': semester,
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Formative Data--</b></div>';
          } else {
            var html = '';
            var html2 = "";
            var i;
            html += "<label><u>Formative</u></label>"
            html += "<table class='rapot'>";
            html += "<tr>"
            html += "<th>Nama</th>";
            html += "<th>Quiz x %</th>";
            html += "<th>Test x %</th>";
            html += "<th>Ass x %</th>";
            html += "<th>Total</th>";
            html += "</tr>"
            var total_akhir = 0;
            for (i = 0; i < data.length; i++) {
              html += "<tr>"
              html += "<td style='width: 180px; padding: 0px 0px 0px 5px;'>" + data[i].topik_nama + "</td>";

              var total = 0;
              var hasil_quiz = data[i].psi_quiz * data[i].psi_quiz_persen / 100;
              var hasil_test = data[i].psi_test * data[i].psi_test_persen / 100;
              var hasil_ass = data[i].psi_ass * data[i].psi_ass_persen / 100;
              total += hasil_quiz + hasil_test + hasil_ass;
              var roundtotal = Math.round(total);
              total_akhir += roundtotal;
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].psi_quiz + "x" + data[i].psi_quiz_persen / 100 + " = " + hasil_quiz + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].psi_test + "x" + data[i].psi_test_persen / 100 + " = " + hasil_test + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].psi_ass + "x" + data[i].psi_ass_persen / 100 + " = " + hasil_ass + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>" + total + "~ " + roundtotal + "</td>";
              html += "</tr>"
            }

            var total_akhir_forma = total_akhir / data.length;
            var roundtotal_akhir_forma = Math.round(total_akhir_forma);

            html += "<tr>"
            html += "<td style='padding: 0px 0px 0px 5px;'>Formative</td>";
            html += "<td colspan='4' style='padding: 0px 0px 0px 5px;'>" + total_akhir_forma + "~ "+roundtotal_akhir_forma+"</td>";
            html += "</tr>"
            html += "</table>";

            $.ajax({
              type: "post",
              url: base_url + "API/get_summative_by_mapel",
              data: {
                'mapel_id': mapel_id,
                'd_s_id': d_s_id,
              },
              async: true,
              dataType: 'json',
              success: function(data) {
                if (data.length == 0) {
                  html2 += '<div class="text-center mb-3 text-danger"><b>--No Summative Data--</b></div>';
                } else {
                  var i;
                  html2 += "<label class='mt-3'><u>Summative</u></label>"
                  html2 += "<table class='rapot'>";
                  html2 += "<tr>"
                  html2 += "<th>PTS x %</th>";
                  html2 += "<th>PAS x %</th>";
                  html2 += "</tr>"
                  var total_akhir_sum = 0;
                  for (i = 0; i < data.length; i++) {
                    if (semester == 1) {
                      var hasil_pts = data[i].uj_mid1_psi * data[i].uj_mid1_psi_persen / 100;
                      var hasil_pas = data[i].uj_fin1_psi * data[i].uj_fin1_psi_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid1_psi + "x" + data[i].uj_mid1_psi_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin1_psi + "x" + data[i].uj_fin1_psi_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    } else if (semester == 2) {
                      var hasil_pts = data[i].uj_mid2_psi * data[i].uj_mid2_psi_persen / 100;
                      var hasil_pas = data[i].uj_fin2_psi * data[i].uj_fin2_psi_persen / 100;
                      html2 += "<tr>"
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_mid2_psi + "x" + data[i].uj_mid2_psi_persen / 100 + " = " + hasil_pts + "</td>";
                      html2 += "<td style='padding: 0px 0px 0px 5px;'>" + data[i].uj_fin2_psi + "x" + data[i].uj_fin2_psi_persen / 100 + " = " + hasil_pas + "</td>";
                      html2 += "</tr>"
                    }

                  }

                  total_akhir_sum = hasil_pts + hasil_pas;

                  var roundtotal_akhir_sum = Math.round(total_akhir_sum);
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>Total</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + total_akhir_sum + " ~"+roundtotal_akhir_sum+"</td>";
                  html2 += "</tr>"

                  html2 += "</table>";

                  var akhir_kognitif = roundtotal_akhir_forma * persen_forma_ket / 100 + roundtotal_akhir_sum * persen_summa_ket / 100;
                  var akhir_forma = roundtotal_akhir_forma * persen_forma_ket / 100;
                  var akhir_summa = roundtotal_akhir_sum * persen_summa_ket / 100;

                  var roundakhir_kognitif = Math.round(akhir_kognitif);

                  html2 += "<table class='rapot mt-3'>";
                  html2 += "<tr>"
                  html2 += "<th>"
                  html2 += "Formative x % formative"
                  html2 += "</th>"
                  html2 += "<th>"
                  html2 += "Summative x % Summative"
                  html2 += "</th>"
                  html2 += "</tr>"
                  html2 += "<tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_forma + "x" + persen_forma_ket / 100 + "= " + akhir_forma + "</td>";
                  html2 += "<td style='padding: 0px 0px 0px 5px;'>" + roundtotal_akhir_sum + "x" + persen_summa_ket / 100 + "= " + akhir_summa + "</td>";
                  html2 += "</tr>"
                  html2 += "<td style='padding: 0px 0px 0px 5px;' colspan='2'>Nilai Akhir Kognitif: " + akhir_kognitif + " ~"+roundakhir_kognitif+"</td>";
                  html2 += "</tr>"
                  html2 += "</table>";
                }

                //console.log(html2);

                $('#isi_modal').html(html + html2);
                $("#myModal").show();
              }
            });
          }
        }
      });
    });

    $(".link-akhir").on('click', function() {
      var kog = $(this).attr("rel");
      var psi = $(this).attr("rel2");
      var persen_kog = $(this).attr("rel3");
      var persen_psi = $(this).attr("rel4");

      //alert("aaaa");
      var html = '';
      $("#judul_modal").html("Detail Nilai Akhir");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      //alert(mapel_id);
      html += "<label><u>Nilai Akhir</u></label>"
      html += "<table class='rapot'>";
      html += "<tr>"
      html += "<th>Cognitive x % Cog</th>";
      html += "<th>Psychomotor x % Psy</th>";
      html += "<th>NA</th>";
      html += "</tr>"
      html += "<tr>"

      var akhir_kog = kog*(persen_kog/100);
      var akhir_psi = psi*(persen_psi/100);

      var na = akhir_kog + akhir_psi;
      var roundna = Math.round(na);

      html += "<td style='padding: 0px 0px 0px 5px;'>"+kog+"x"+persen_kog/100+"="+akhir_kog+"</td>";
      html += "<td style='padding: 0px 0px 0px 5px;'>"+psi+"x"+persen_psi/100+"="+akhir_psi+"</td>";
      html += "<td style='padding: 0px 0px 0px 5px;'>"+akhir_kog+"+"+akhir_psi+"= "+na+"~ "+roundna+"</td>";
      html += "</tr>"
      html += "</table>";

      $('#isi_modal').html(html);
      $("#myModal").show();
    });

  });
</script>
