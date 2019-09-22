$(document).ready(function () {
  $('#laporan_t').change(function () {
    $('#laporan_sk').change();
  });
  $('#laporan_sk').change(function () {

    var sk_id = $(this).val();
    var t_id = $('#laporan_t').val();

    var laporan_flag = $('#laporan_flag').val();
    $('#laporan_kelas').html("");
    $('#laporan_mapel').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_kelas_by_year_sk",
        data: {
          't_id': t_id,
          'sk_id': sk_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Add Class First--</b></div>';
          } else {
            var html = '<select name="kelas_id" id="laporan_kelas_id" class="form-control mb-3 kelas_id">';

            if (laporan_flag != 1) {
              html += '<option value="0">Select Class</option>';
            }
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '</option>';
            }
            html += '</select>';
          }
          if (laporan_flag == 1) {
            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Show Report';
            html += '</button>';
          }

          $('#laporan_kelas').html(html);
          if (laporan_flag == 0) {
            refLapKelas();
          }
        }
      });

  });

  function refLapKelas() {
    $('#laporan_kelas_id').change(function () {

      var kelas_id = $(this).val();

      $('#laporan_mapel').html("");

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_mapel_by_kelas",
          data: {
            'kelas_id': kelas_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Subject in Class--</b></div>';
            } else {
              var html = '<select name="mapel_id" id="laporan_mapel_id" class="form-control mb-3">';
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].mapel_id + '>' + data[i].mapel_nama + '</option>';
              }
              html += '</select>';
            }

            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Show Report';
            html += '</button>';

            $('#laporan_mapel').html(html);
            //refreshEventKelas();
          }
        });

    });
  }

  function return_abjad_afek(nilai) {
    if (nilai >= 7.65) {
      return "A";
    } else if (nilai >= 6.3) {
      return "B";
    } else if (nilai >= 4.95) {
      return "C";
    } else {
      return "D";
    }
  }

  $('#bulan_laporan_id').change(function () {

    var bulan_id = $(this).val();
    var kelas_id = $('#kelas_laporan_id').val();
    var sk_id = $('#sk_laporan_id').val();
    var t_id = $('#t_laporan_id').val();
    var html = '';
    var html2 = '';
    $('#laporan_afek_show').html("");
    $('#laporan_desc_afek_show').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_desc_afek_by_sk_t_bulan",
        data: {
          'bulan_id': bulan_id,
          'sk_id': sk_id,
          't_id': t_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          for (i = 0; i < data.length; i++) {
            // html2 += '<b class="text-center mt-4"> Affective Criteria: ' + data[i].k_afek_topik_nama + '</b>';
            html2 += '<div class="alert alert-primary alert-dismissible fade show mt-4">';
            html2 += '<button class="close" data-dismiss="alert" type="button">';
            html2 += "<span>&times;</span>";
            html2 += '</button>';
            html2 += '<div class="text-center">';
            html2 += '<strong>INFO:</strong> <br> A>=7.65 B>=6.3 C>=4.95 D<4.95';

            html2 += '<br></br><strong>VALUE:</strong> <br>';
            html2 += '<u>' + data[i].k_afek_topik_nama + '</u><br><br>';
            html2 += '<strong>INDICATOR:</strong> <br>';
            html2 += data[i].k_afek_1 + '<br>';
            html2 += data[i].k_afek_2 + '<br>';
            html2 += data[i].k_afek_3
            html2 += '</div >';
          }
          $('#laporan_desc_afek_show').html(html2);
        }
      });

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_laporan_afek_header_by_kelas_bulan",
        data: {
          'bulan_id': bulan_id,
          'kelas_id': kelas_id,
          'sk_id': sk_id,
          't_id': t_id,
        },
        async: true,
        dataType: 'json',
        success: function (data2) {
          //console.log(data);
          if (data2.length == 0) {
            html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
          } else {
            //   var html = '';
            //   var i;
            html += '<table class="rapot mt-4">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Reg Num</th>';
            html += '<th>Name</th>';
            for (i = 0; i < data2.length; i++) {
              html += '<th class="text-center" style="width: 100px;" colspan="2">' + data2[i].mapel_sing + "</th>";
            }
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            // }

            $.ajax(
              {
                type: "post",
                url: base_url + "API/get_laporan_afek_by_kelas_bulan",
                data: {
                  'bulan_id': bulan_id,
                  'kelas_id': kelas_id,
                  'sk_id': sk_id,
                  't_id': t_id,
                },
                async: true,
                dataType: 'json',
                success: function (data) {
                  //console.log(data2);
                  if (data.length == 0) {
                    html = '<div class="text-center mt-4 mb-3 text-danger"><b>--No Data--</b></div>';
                  } else {
                    var i;
                    for (i = 0; i < data.length; i++) {

                      //alert(i);
                      html += '<tr>';
                      html += '<td style="width: 50px;padding: 0px 0px 0px 5px;">' + data[i].sis_no_induk + '</td>';
                      html += '<td style="padding: 0px 5px 0px 5px;">' + data[i].sis_nama_depan + '</td>';
                      var x = Object.keys(data[i]);
                      //console.log(x);
                      for (j = 6; j < data2.length + 6; j++) {
                        var nama = x[j];
                        var y = data[i];

                        //console.log(y[nama]);
                        if (y[nama]) {
                          var danger = "";
                          if (return_abjad_afek(parseFloat(y[nama]).toFixed(2)) == "C" || return_abjad_afek(parseFloat(y[nama]).toFixed(2)) == "D") {
                            danger = "color: red;";
                          }
                          html += '<td style="text-align:center;' + danger + '">' + parseFloat(y[nama]).toFixed(2); + '</td>';
                          html += '<td style="text-align:center;' + danger + '">' + return_abjad_afek(parseFloat(y[nama]).toFixed(2)) + ' </td>';
                        } else {
                          html += '<td style="text-align:center;" colspan="2">-</td>';
                        }
                      }
                      html += '<tr>';
                    }
                    html += '</tbody>';
                    html += '</table>';
                    //alert(html);
                  }
                  $('#laporan_afek_show').html(html);
                }
              });
          }
        }
      });
  });


});