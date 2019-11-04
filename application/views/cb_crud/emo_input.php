<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900 mb-3"><b><u><?= $title ?></u></b></h4>
              <h4 class="h4 text-gray-900 mb-3"><b><u><?= $siswa_all[0]['kelas_nama'] ?></u></b></h4>
            </div>

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>INFO:</strong> Press SAVE button below
                </div>';
                    

                function cetak_opt($nama, $dipilih){
                  $afek_nilai = ["A","B","C","D"];
                  $opt = "<select name=".$nama.">";
                  $_s = "selected";
                  for($i=4;$i>=1;$i--){
                    if($dipilih == $i){
                      $opt .= "<option value='".($i)."' ".$_s.">".$afek_nilai[4-$i]."</option>";
                    }else{
                      $opt .= "<option value='".($i)."'>".$afek_nilai[4-$i]."</option>";
                    }
                  }
                  $opt .= "</select>";
                  echo $opt;
                }

            ?>

            <div id="notif"></div>

            <form class="" action="<?= base_url('cb_CRUD/save_emo'); ?>" method="post">
              <table class="table table-bordered table-hover table-sm mr-5">
                <thead>
                  <tr>
                    <th rowspan="3">Reg Num</th>
                    <th rowspan="3">Name</th>
                    <th class="text-center" colspan="6"><a class='link-es' href='javascript:void(0)'>Emotional Skill</a></th>
                    <th class="text-center" colspan="8"><a class='link-ss' href='javascript:void(0)'>Spirituality</a></th>
                  </tr>
                  <tr>
                    <th class="text-center" colspan="3">Sem 1</th>
                    <th class="text-center" colspan="3">Sem 2</th>
                    <th class="text-center" colspan="4">Sem 1</th>
                    <th class="text-center" colspan="4">Sem 2</th>
                  </tr>
                  <tr>
                    <th class="text-center">Expr</th>
                    <th class="text-center">Self</th>
                    <th class="text-center">Neg</th>
                    <th class="text-center">Expr</th>
                    <th class="text-center">Self</th>
                    <th class="text-center">Neg</th>

                    <th class="text-center">Cop</th>
                    <th class="text-center">Emo</th>
                    <th class="text-center">Grate</th>
                    <th class="text-center">Refl</th>
                    <th class="text-center">Cop</th>
                    <th class="text-center">Emo</th>
                    <th class="text-center">Grate</th>
                    <th class="text-center">Refl</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                    foreach ($siswa_all as $m) :
                  ?>

                    <tr>
                      <td>
                        <input type="hidden" value="<?= $m['d_s_id']; ?>" name="d_s_id[]">
                        <?= $m['sis_no_induk']; ?>
                      </td>
                      <td>
                        <?php
                          if($m['sis_nama_bel']){
                            $bel = $m['sis_nama_bel'][0];
                          }else{
                            $bel = "";
                          }
                          echo $m['sis_nama_depan']." ".$bel;
                        ?>
                      </td>

                      <td class="text-center"><?php cetak_opt("emo_aware_ex[]",$m['emo_aware_ex']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_so[]",$m['emo_aware_so']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ne[]",$m['emo_aware_ne']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ex2[]",$m['emo_aware_ex2']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_so2[]",$m['emo_aware_so2']); ?></td>
                      <td class="text-center"><?php cetak_opt("emo_aware_ne2[]",$m['emo_aware_ne2']); ?></td>

                      
                      <td class="text-center"><?php cetak_opt("spirit_coping[]",$m['spirit_coping']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_emo[]",$m['spirit_emo']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_grate[]",$m['spirit_grate']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_ref[]",$m['spirit_ref']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_coping2[]",$m['spirit_coping2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_emo2[]",$m['spirit_emo2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_grate2[]",$m['spirit_grate2']); ?></td>
                      <td class="text-center"><?php cetak_opt("spirit_ref2[]",$m['spirit_ref2']); ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <button type="submit" class="btn btn-success mt-2" id="btn-save">
                  <i class="fa fa-save"></i>
                  Save
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<script type = "text/javascript">
  $(document).ready(function () {

    $(".link-es").on('click', function () {

      $(".modal-dialog").addClass("modal-dialog-custom");
      $(".modal-body").addClass("modal-body-custom");

      $("#judul_modal").html("Emotional Skill");

      var html = "";
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th style='width: 80px;text-align:center;'></th>";
      html += "<th>A</th>";
      html += "<th>B</th>";
      html += "<th>C</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding:5px;'>Expressive</td>";
      html += "<td style='padding:5px;'>Siswa mampu menunjukkan ekpresi emosi secara tepat misalnya tertawa saat lucu, sedih ketika kecewa, dll sesuai dengan keadaan dirinya.</td>";
      html += "<td style='padding:5px;'>Dengan bimbingan guru siswa mampu menunjukkan ekpresi emosi secara tepat misalnya tertawa saat lucu, sedih ketika kecewa, dll sesuai dengan keadaan dirinya. </td>";
      html += "<td style='padding:5px;'>Siswa belum mampu menunjukkan ekpresi emosi secara tepat misalnya tertawa saat lucu, sedih ketika kecewa, dll sesuai dengan keadaan dirinya.</td>";
      html += "</tr>"
      html += "<tr>";
      html += "<td style='padding:5px;'>Self Control</td>";
      html += "<td style='padding:5px;'>Siswa mampu mengontrol emosi dengan tidak berkata atau melakukan tindakan secara negative ketika dia dalam keadaan terdesak.</td>";
      html += "<td style='padding:5px;'>Dengan bimbingan guru siswa mampu mengontrol emosi dengan tidak berkata atau melakukan tindakan secara negative ketika dia dalam keadaan terdesak.</td>";
      html += "<td style='padding:5px;'>Siswa belum mampu mengontrol emosi dengan tidak berkata atau melakukan tindakan secara negative ketika dia dalam keadaan terdesak.</td>";
      html += "</tr>"
      html += "<tr>";
      html += "<td style='padding:5px;'>Negative Emotions</td>";
      html += "<td style='padding:5px;'>Siswa mampu melakukan upaya untuk menanggulangi emosi negative yang menekan akibat suatu masalah baik di dalam sekolah maupun diluar sekolah, dengan melakukan perubahan kognitif maupun perilaku di dalam dirinya</td>";
      html += "<td style='padding:5px;'>Dengan bimbingan guru siswa mampu melakukan upaya untuk menanggulangi emosi negative yang menekan akibat suatu masalah baik di dalam sekolah maupun diluar sekolah, dengan melakukan perubahan kognitif maupun perilaku di dalam dirinya. </td>";
      html += "<td style='padding:5px;'>Siswa belum mampu melakukan upaya untuk menanggulangi emosi negative yang menekan akibat suatu masalah baik di dalam sekolah maupun diluar sekolah, dengan melakukan perubahan kognitif maupun perilaku di dalam dirinya</td>";
      html += "</tr>"
      html += "</tbody>";
      html += "</table>";

      $('#isi_modal').html(html);
      $("#myModal").show();
    });

    $(".link-ss").on('click', function () {

      $(".modal-dialog").addClass("modal-dialog-custom");
      $(".modal-body").addClass("modal-body-custom");

      $("#judul_modal").html("Spirituality");

      var html = "";
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th style='width: 80px;text-align:center;'></th>";
      html += "<th>A</th>";
      html += "<th>B</th>";
      html += "<th>C</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding:5px;'>Coping Adversities</td>";
      html += "<td style='padding:5px;'>Siswa mampu mencari jalan keluar akibat permasalahan yang ia hadapi, serta melakukan perubahan (misalnya: siswa sering tidur saat jam pelajaran akibat pola tidur yang salah, namun ada perubahan perilaku berjalannya waktu, atau juga gaya belajar)</td>";
      html += "<td style='padding:5px;'>Dengan bimbingan guru siswa mampu mencari jalan keluar akibat permasalahan yang ia hadapi, serta melakukan perubahan (misalnya: siswa sering tidur saat jam pelajaran akibat pola tidur yang salah, namun ada perubahan perilaku berjalannya waktu, atau juga gaya belajar)</td>";
      html += "<td style='padding:5px;'>Siswa belum mampu mencari jalan keluar akibat permasalahan yang ia hadapi, serta melakukan perubahan (misalnya: siswa sering tidur saat jam pelajaran akibat pola tidur yang salah, namun ada perubahan perilaku berjalannya waktu, atau juga gaya belajar)</td>";
      html += "</tr>"
      html += "<tr>";
      html += "<td style='padding:5px;'>Emotional Resilience</td>";
      html += "<td style='padding:5px;'>Siswa memiliki ketahanan emosi, dimana siswa mampu menunjukkan ekspresi emosi yang tetap baik sekalipun situasi dan kondisi yang ia alami tidaklah begitu nyaman (misalnya, saat siswa merasa tidak nyaman dengan guru, ia mampu bersikap tetap sopan baik dalam bertindak maupun berkata-kata)</td>";
      html += "<td style='padding:5px;'>Dengan bimbingan guru siswa memiliki ketahanan emosi, dimana siswa mampu menunjukkan ekspresi emosi yang tetap baik sekalipun situasi dan kondisi yang ia alami tidaklah begitu nyaman (misalnya, saat siswa merasa tidak nyaman dengan guru, ia mampu bersikap tetap sopan baik dalam bertindak maupun berkata-kata)</td>";
      html += "<td style='padding:5px;'>Siswa belum memiliki ketahanan emosi, dimana siswa mampu menunjukkan ekspresi emosi yang tetap baik sekalipun situasi dan kondisi yang ia alami tidaklah begitu nyaman (misalnya, saat siswa merasa tidak nyaman dengan guru, ia mampu bersikap tetap sopan baik dalam bertindak maupun berkata-kata)</td>";
      html += "</tr>"
      html += "<tr>";
      html += "<td style='padding:5px;'>Grateful</td>";
      html += "<td style='padding:5px;'>Siswa tidak menggerutu secara berlebihan terhadap suatu hal atau suatu keadaan tertentu (misalnya: siswa tidak menggerutu terus-menerus apabila barada dalam kondisi banyak tugas atau siswa sedang melaksanakan kegiatan diluar sekolah namun siswa tidak nyaman dan ia tidak menggerutu)</td>";
      html += "<td style='padding:5px;'>Dengan bimbingan guru siswa tidak menggerutu secara berlebihan terhadap suatu hal atau suatu keadaan tertentu (misalnya: siswa tidak menggerutu terus-menerus apabila barada dalam kondisi banyak tugas atau siswa sedang melaksanakan kegiatan diluar sekolah namun siswa tidak nyaman dan ia tidak menggerutu)</td>";
      html += "<td style='padding:5px;'>Siswa belum mampu untuk tidak menggerutu secara berlebihan terhadap suatu hal atau suatu keadaan tertentu (misalnya: siswa tidak menggerutu terus-menerus apabila barada dalam kondisi banyak tugas atau siswa sedang melaksanakan kegiatan diluar sekolah namun siswa tidak nyaman dan ia tidak menggerutu)</td>";
      html += "</tr>"
      html += "<tr>";
      html += "<td style='padding:5px;'>Reflective</td>";
      html += "<td style='padding:5px;'>Siswa mampu menunjukkan peningkatan kearah yang lebih positif, baik dalam prestasi maupun perilaku </td>";
      html += "<td style='padding:5px;'>Dengan bimbingan guru siswa mampu menunjukkan peningkatan kearah yang lebih positif, baik dalam prestasi maupun perilaku.</td>";
      html += "<td style='padding:5px;'>Siswa belum mampu menunjukkan peningkatan kearah yang lebih positif, baik dalam prestasi maupun perilaku.</td>";
      html += "</tr>"
      html += "</tbody>";
      html += "</table>";

      $('#isi_modal').html(html);
      $("#myModal").show();
    });

  });
</script>
