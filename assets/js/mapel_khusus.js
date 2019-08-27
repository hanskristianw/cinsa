$(document).ready(function () {
  var mkId = $("#mkInputId").val();
  if (mkId) {
    setInterval(function () {
      refreshMkList();
    }, 3000);
  }

  function refreshMkList() {
    var mkId = $("#mkInputId").val();

    $.ajax({
      url: base_url + 'API/get_siswaMK',
      data: {
        'mkId': mkId,
      },
      type: 'POST',
      async: true,
      dataType: 'json',
      success: function (data) {
        //console.log(data);
        if (data.length == 0) {
          var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
        } else {
          var i;
          //alert(data.length);
          html = "";
          html += '<table class="table table-sm">';
          html += '<thead>';
          html += '<tr>';
          html += '<th class="w-50">Student Name</th>';
          html += '<th>Class</th>';
          html += '<th>Action</th>';
          html += '</tr>';
          html += '</thead>';
          html += '<tbody>';
          for (i = 0; i < data.length; i++) {
            html += '<tr>';
            html += '<td>' + data[i].sis_nama_depan + ' ' + data[i].sis_nama_bel + '</td>';
            html += '<td>' + data[i].kelas_nama + '</td>';
            html += '<td>';
            html += '<form method="post" id="deleteSiswaMk" class="deleteSiswaMk" action="' + base_url + 'MK_CRUD/deleteStudent">';
            html += '<input type="hidden" name="d_s_id" value= ' + data[i].d_s_id + '>';
            html += '<input type="hidden" name="mk_detail_id" value= ' + data[i].mk_detail_id + '>';
            html += '<button type="submit" class="ml-2 btn btn-danger">';
            html += '<i class="fa fa-trash-alt"></i>';
            html += '</button>';
            html += '</form>';
            html += '</td>';
            html += '</tr>';
          }
          html += '</tbody>';
          html += '</table><hr>';

        }
        $('#siswaMKAjax').html(html);
      }
    });
  }

  $('#kelas_mk').change(function () {
    var kelas_id = $(this).val();
    var mk_mapel_id = $("#mk_mapel_id").val();
    //alert(kelas_id);
    var mkId = $("#mkInputId").val();
    if (kelas_id == 0) {
      $('#siswaKelasAjax').html("");
    }

    $.ajax(
      {
        type: "post",
        url: base_url + "MK_CRUD/get_siswaKelas",
        data: {
          'kelas_id': kelas_id,
          'mkId': mkId,
          'mk_mapel_id': mk_mapel_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          html = "";
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Student(s) available--</b></div>';
          } else {
            var i;
            html += '<form method="post" class="mkEditStudentForm" id="mkEditStudentForm" action="' + base_url + 'MK_CRUD/addStudent">';
            html += '<div><input type="hidden" name="mkId" value="' + mkId + '"</div>';
            for (i = 0; i < data.length; i++) {
              html += '<div class="checkbox ml-2">';
              html += '<label><input type="checkbox" name="siswa_check[]" class="sisC" value="' + data[i].d_s_id + '"> ' + data[i].sis_nama_depan + ' ' + data[i].sis_nama_bel + '</label>';
              html += '</div>';
            }

            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Add';
            html += '</button>';
            html += '</form>';
          }

          $('#siswaKelasAjax').html(html);
          refreshmkEditStudentForm();
        }
      });
  });


  function refreshmkEditStudentForm() {
    $(".mkEditStudentForm").submit(function (evt) {
      evt.preventDefault();

      if ($('.mkEditStudentForm :checkbox:checked').length > 0) {
        // one or more checkboxes are checked
        var form = $(this);
        $.ajax({
          url: base_url + "MK_CRUD/addStudent",
          data: form.serialize(),
          type: "POST",
          dataType: "html",
          success: function (data) {
            //alert(data);
            $(".mkMsg").html(data);
            $('#kelas_mk').change();
            $('#siswaKelasAjax').html("");
          }
        });
      }
      else {
        $(".mkMsg").html("<div class='alert alert-danger' role='alert'>Please select one or more students</div>");
      }

    });
  }


});