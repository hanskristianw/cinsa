<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center mb-4">
              <h1 class="h4 text-gray-900"><u><b>Laporan Nilai</b></u></h1>
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
                    <td colspan="2"><br><b><u>Klik pada angka untuk melihat detail nilai</u></b></td>
                  </tr>
                </table>
            </div>

            <?= $this->session->flashdata('message'); ?>
            
              <table class="rapot">
                <thead>
                  <tr>
                    <th style='width: 120px;' rowspan="2">Subject/Class <br> Semester</th>

                    <?php 
                      $arr_kelas_id = array();
                      $arr_jumlah_murid = array();
                      foreach($kelas_all as $n) :
                        array_push($arr_kelas_id, $n['kelas_id']);
                        array_push($arr_jumlah_murid, $n['jumlah_murid']);
                    ?>
                      <th colspan="2"> 
                          <?= $n['kelas_nama_singkat']."<br>(".$n['jumlah_murid']." siswa)" ?>
                      </th>
                    <?php endforeach ?>
                  </tr>
                  <tr>
                    <?php foreach($kelas_all as $n) : ?>
                          <th>1</th>
                          <th>2</th>
                    <?php endforeach ?>
                  </tr>
                  
                </thead>
                <tbody>
                  <tr>
                      <td style='padding: 0px 0px 0px 5px;' rowspan='2'>Character Building</td>
                  </tr>
                  <tr>
                      <?php 
                      for($i=0;$i<count($arr_kelas_id);$i++){
                        $sem1 = show_cb_count($arr_kelas_id[$i],1);
                        $sem2 = show_cb_count($arr_kelas_id[$i],2);
                        //semester 1
                        if($sem1['jumlah']==0){
                          echo "<td style='background-color:#d94a02;width: 30px;'></td>";
                        }
                        else{
                          if($sem1['jumlah'] % $arr_jumlah_murid[$i] != 0)
                            $kuning = "background-color:#e9ed55;";
                          else
                            $kuning = "";

                          echo "<td style='width: 30px;text-align:center;".$kuning."'>
                                <a class='link-cb' rel='".$arr_kelas_id[$i]."' rel2='1' href='javascript:void(0)'>".$sem1['jumlah']."</a></td>";
                        }
                        //semester 2
                        if($sem2['jumlah']==0){
                          echo "<td style='background-color:#d94a02;width: 30px;'></td>";
                        }
                        else{
                          if($sem2['jumlah'] % $arr_jumlah_murid[$i] != 0)
                            $kuning = "background-color:#e9ed55;";
                          else
                            $kuning = "";
                            
                          echo "<td style='width: 30px;text-align:center;".$kuning."'>
                          <a class='link-cb' rel='".$arr_kelas_id[$i]."' rel2='2' href='javascript:void(0)'>".$sem2['jumlah']."</a></td>";
                        }
                      }
                    ?>
                  </tr>
                </tbody>
              </table>
              <br>
              
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script type = "text/javascript">
  $(document).ready(function () {
    $(".link-cb").on('click', function () {
      var kelas_id = $(this).attr("rel");
      var semester = $(this).attr("rel2");

      $(".modal-dialog").addClass("modal-dialog-custom");
      $(".modal-body").addClass("modal-body-custom");
      
      $("#judul_modal").html("Detail Nilai");
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_nilai_cb_by_kelas_semester",
        data: {
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
              html += "<th>Nama</th>";
              html += "<th>Ind 1</th>";
              html += "<th>Ind 2</th>";
              html += "<th>Ind 3</th>";
              html += "<th>Ind 4</th>";
              html += "<th>Ind 5</th>";
              html += "</tr>";
              html += "</thead>";
              html += "<tbody>";
              var topik = "";
            for (i = 0; i < data.length; i++) {
              
              if(topik != data[i].topik_cb_nama){
                html += "<tr style='text-align:center;background-color:#e9ed55;'>";
                html += "<td style='width: 120px;' colspan='6'><b>"+data[i].topik_cb_nama+"</b></td>";
                html += "</tr>";
              }

              html += "<tr>";
              var nama_bel = "";
              if(data[i].sis_nama_bel[0])
                nama_bel = data[i].sis_nama_bel[0];

              html += "<td style='padding: 0px 0px 0px 5px;'>"+data[i].sis_nama_depan + " " + nama_bel + "</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnNilaiCB(data[i].nilai_cb1)+"</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnNilaiCB(data[i].nilai_cb2)+"</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnNilaiCB(data[i].nilai_cb3)+"</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnNilaiCB(data[i].nilai_cb4)+"</td>";
              html += "<td style='padding: 0px 0px 0px 5px;'>"+returnNilaiCB(data[i].nilai_cb5)+"</td>";
              html += "</tr>";

              topik = data[i].topik_cb_nama;
            }
              html += "</tbody>";
              html += "</table>";
          }

          $('#isi_modal').html(html);
          $("#myModal").show();
        }
      });

    });
    
    function returnNilaiCB(nilai){
      if(nilai=="4")
        return "A";
      else if(nilai=="3")
        return "B";
      else if(nilai=="2")
        return "C";
      else if(nilai=="1")
        return "D"
      else
        return " ";
    }

  });
</script>