$(document).ready(function () {

  $('#close_modal').click(function () {
    $("#myModal").hide();
  });
  $('#close_modal2').click(function () {
    $("#myModal").hide();
  });
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
            if (laporan_flag == 1) {
              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Show Report';
              html += '</button>';
            }
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



});