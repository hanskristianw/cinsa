$(document).ready(function () {

  $('#but_konselor').hide();
  $('#kadiv_kon_sk').change(function () {

    var sk_id = $(this).val();

    //alert(sk_id);
    if (sk_id == 0) {
      $('#kadiv_kon_detail').html("");
      $('#but_konselor').hide();
    }
    else {

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_konselor_by_sk",
          data: {
            'sk_id': sk_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {

            $('#but_konselor').show();
            //alert(data);
            var html = '<table class="table table-bordered table-sm mt-2">';
            html += '<thead class="thead-dark">';
            html += '<tr>';
            html += '<th>Full Name</th>';
            html += '<th>Action</th>';
            html += '</tr>';
            html += '</thead>';

            html += '<tbody>';
            if (data.length != 0) {
              for (var i = 0; i < data.length; i++) {
                html += '<tr>';
                html += '<td>' + data[i].kr_nama_depan + ' ' + data[i].kr_nama_belakang + '</td>';
                html += '<td>';

                html += '<div class="form-group row ml-2">';
                html += '<form method="post" action="' + base_url + 'Konselor_CRUD/edit">';

                html += '<input type="hidden" value="' + data[i].konselor_id + '" name="konselor_id">';
                html += '<button type="submit" class="badge badge-warning">';
                html += 'Edit';
                html += '</button>';

                html += '</form>';

                html += '<form method="post" action="' + base_url + 'Konselor_CRUD/delete_proses">';

                html += '<input type="hidden" value="' + data[i].konselor_id + '" name="konselor_id">';
                html += '<button type="submit" class="badge badge-danger">';
                html += 'Delete';
                html += '</button>';

                html += '</form>';

                html += '</div>';

                html += '</td>';
                html += '</tr>';
              }
            } else {
              html += '<td colspan="2" class="text-center table-danger"><b>--No Counselor(s), please add 1 or more counselor--</b></td>';
            }
            html += '</tbody>';
            html += '</table>';

            $('#kadiv_kon_detail').html(html);

          }
        });
    }

  });

  //KRITERIA AFEKTIF
  $('#submit_kriteria_afektif').hide();
  $('#k_afek_t_id').change(function () {
    var k_afek_t_id = $(this).val();
    var k_afek_bulan_id = $('#k_afek_bulan_id').val();
    var sk_id = $('#sk_id').val();
    var _k_afek_t_id = $('#_k_afek_t_id').val();
    var _k_afek_bulan_id = $('#_k_afek_bulan_id').val();


    if (_k_afek_t_id == k_afek_t_id && _k_afek_bulan_id == k_afek_bulan_id) {
      $('#submit_kriteria_afektif').show();
      $('#notif_kriteria').html("");
    }
    else {
      if (k_afek_t_id > 0 && k_afek_bulan_id > 0) {
        $.ajax(
          {
            type: "post",
            url: base_url + "API/cek_topik_afektif_exist",
            data: {
              'k_afek_t_id': k_afek_t_id,
              'k_afek_bulan_id': k_afek_bulan_id,
              'sk_id': sk_id
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              if (data.length == 0) {
                $('#submit_kriteria_afektif').show();
                $('#notif_kriteria').html("");
              } else {
                var html = '<div class="alert alert-danger" role="alert">Criteria with same month and year already exist!</div>';
                $('#notif_kriteria').html(html);
                $('#submit_kriteria_afektif').hide();
              }
            }
          });
      } else {
        $('#submit_kriteria_afektif').hide();
        $('#notif_kriteria').html("");
      }
    }



  }).change();

  $('#k_afek_bulan_id').change(function () {
    $('#k_afek_t_id').change();
  });

  /////////////
  //KONSELING//
  /////////////
  $('#konseling_sk_id').change(function () {
    var sk_id = $(this).val();
    var t_id = $('#konseling_t_id').val();
    $('#konseling_siswa_id').html("");
    $('#detail_konseling').html("");
    $('#btn_add_konseling').html("");

    //alert(sk_id);

    if (sk_id > 0 && t_id > 0) {
      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_kelas_by_year_sk",
          data: {
            't_id': t_id,
            'sk_id': sk_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Please add Class--</b></div>';
            } else {
              var html = '<select name="kelas_id" id="konseling_kelas_id_opt" class="form-control mb-3">';
              var i;
              html += '<option value= "0" >Select Class</option>';
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '</option>';
              }
              html += '</select>';
            }

            $('#konseling_kelas_id').html(html);
            refreshKonselingSiswa();
          }
        });
    } else {
      $('#konseling_kelas_id').html("");
    }

  });

  $('#konseling_t_id').change(function () {
    $('#konseling_sk_id').change();
  });

  function refreshKonselingSiswa() {
    $('#konseling_kelas_id_opt').change(function () {
      var kelas_id = $(this).val();

      $('#detail_konseling').html("");
      $('#btn_add_konseling').html("");
      //alert(kelas_id);

      if (kelas_id > 0) {
        $.ajax(
          {
            type: "post",
            url: base_url + "API/get_siswa_by_kelas",
            data: {
              'kelas_id': kelas_id
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              if (data.length == 0) {
                var html = '<div class="text-center mb-3 text-danger"><b>--No Student(s), contact curriculum for more information--</b></div>';
              } else {
                var i;
                html = "";

                html += '<select name="d_s_id" id="konseling_d_s_id" class="form-control mb-3 siswa_tatib_id">';
                html += '<option value= "0">Select Student</option>';
                for (i = 0; i < data.length; i++) {
                  html += '<option value=' + data[i].d_s_id + '>' + data[i].sis_nama_depan + ' ' + data[i].sis_nama_bel + '</option>';
                }
                html += '</select>';

              }

              $('#konseling_siswa_id').html(html);
              refreshdetailKonselingSiswa();
            }
          });

      } else {
        $('#konseling_siswa_id').html("");
      }

    });
  }

  function refreshdetailKonselingSiswa() {
    $('#konseling_d_s_id').change(function () {
      var d_s_id = $(this).val();
      var html3 = "";
      var html2 = "";

      //alert(d_s_id);

      if (d_s_id > 0) {
        $.ajax(
          {
            type: "post",
            url: base_url + "API/get_detail_konseling_by_siswa",
            data: {
              'd_s_id': d_s_id,
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              if (data.length == 0) {
                html2 += '<button type="submit" class="btn btn-primary btn-user mt-3">';
                html2 += 'Add Counseling Session';
                html2 += '</button>';

                html3 += '<div class="text-center mt-3 text-danger"><b>--No data available--</b></div>';
              } else {
                html2 += '<button type="submit" class="btn btn-primary btn-user mt-3">';
                html2 += 'Add Counseling Session';
                html2 += '</button>';

                html3 += '<table class="table table-bordered table-sm mt-2">';
                html3 += '<thead class="thead-dark">';
                html3 += '<tr>';
                html3 += '<th>Date</th>';
                html3 += '<th>Category</th>';
                html3 += '<th>Reason</th>';
                html3 += '<th>Result</th>';
                html3 += '<th>For Teacher</th>';
                html3 += '<th>Action</th>';
                html3 += '</tr>';
                html3 += '</thead>';

                html3 += '<tbody>';
                //alert(html3);
                if (data.length != 0) {
                  for (var i = 0; i < data.length; i++) {
                    html3 += '<tr>';
                    html3 += '<td>' + data[i].konseling_tanggal + '</td>';
                    html3 += '<td>' + data[i].konseling_kategori_nama + '</td>';
                    html3 += '<td>' + data[i].konseling_alasan + '</td>';
                    html3 += '<td>' + data[i].konseling_hasil + '</td>';
                    html3 += '<td>' + data[i].konseling_saran + '</td>';
                    html3 += '<td>';
                    html3 += '<div class="form-group row ml-2">';
                    html3 += '<form method="post" action="' + base_url + 'Konseling_CRUD/edit">';

                    html3 += '<input type="hidden" value="' + data[i].konseling_id + '" name="konseling_id">';
                    html3 += '<input type="hidden" value="' + data[i].konseling_d_s_id + '" name="d_s_id">';
                    html3 += '<button type="submit" class="badge badge-warning">';
                    html3 += 'Edit';
                    html3 += '</button>';

                    html3 += '</form>';

                    html3 += '<form method="post" action="' + base_url + 'Konseling_CRUD/delete">';

                    html3 += '<input type="hidden" value="' + data[i].konseling_id + '" name="konseling_id">';
                    html3 += '<button type="submit" class="badge badge-danger">';
                    html3 += 'Delete';
                    html3 += '</button>';

                    html3 += '</form>';
                    html3 += '</div>';
                    html3 += '</tr>';
                  }
                }
                html3 += '</tbody>';
                html3 += '</table>';
              }

              $('#detail_konseling').html(html3);
              $('#btn_add_konseling').html(html2);
            }
          });

      } else {
        $('#detail_konseling').html("");
        $('#btn_add_konseling').html("");
      }

    });
  }


});