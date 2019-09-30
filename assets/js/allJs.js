$(document).ready(function () {
  $('.custom-file-input').on('change', function () {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });

  $('.dt').DataTable({
    "ordering": false,
    "pageLength": 50
  });

  $(window).keydown(function (event) {
    if ((event.keyCode == 13) && ($(event.target)[0] != $("number")[0])) {
      event.preventDefault();
      return false;
    }
  });

  $('input[type=number]').each(function () {
    $(this).keydown(function (e) {
      var key = e.charCode || e.keyCode || 0;
      // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
      // home, end, period, and numpad decimal
      return (
        // numbers
        key >= 48 && key <= 57 ||
        // Numeric keypad
        key >= 96 && key <= 105 ||
        // Backspace and Tab and Enter
        key == 8 || key == 9 || key == 13 ||
        // Home and End
        key == 35 || key == 36 ||
        // left and right arrows
        key == 37 || key == 39 ||
        // Del and Ins
        key == 46 || key == 45);
    });

    $(this).change(function () {
      var max = parseInt($(this).attr('max'));
      var min = parseInt($(this).attr('min'));
      if ($(this).val() > max) {
        $(this).val(max);
      }
      else if ($(this).val() < min) {
        $(this).val(min);
      }

      if (!$(this).val()) {
        $(this).val(0);
      }
    });
  });


  ////////////////////////////////////
  //////UJIAN - INPUT/UPDATE//////////
  ////////////////////////////////////

  $('#uj_mid1_kog_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_mid1_psi_persen").val(pasangan);
  });

  $('#uj_mid1_psi_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_mid1_kog_persen").val(pasangan);
  });

  $('#uj_fin1_kog_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_fin1_psi_persen").val(pasangan);
  });

  $('#uj_fin1_psi_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_fin1_kog_persen").val(pasangan);
  });

  $('#uj_mid2_kog_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_mid2_psi_persen").val(pasangan);
  });

  $('#uj_mid2_psi_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_mid2_kog_persen").val(pasangan);
  });

  $('#uj_fin2_kog_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_fin2_psi_persen").val(pasangan);
  });

  $('#uj_fin2_psi_persen').on('change', function () {
    var pasangan = 100 - $(this).val();
    $("#uj_fin2_kog_persen").val(pasangan);
  });


  $('.kin').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin').index(this) + 1;
      $('.kin').eq(index).focus();
    }
  });

  $('.kin2').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin2').index(this) + 1;
      $('.kin2').eq(index).focus();
    }
  });

  $('.kin3').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin3').index(this) + 1;
      $('.kin3').eq(index).focus();
    }
  });

  $('.kin4').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin4').index(this) + 1;
      $('.kin4').eq(index).focus();
    }
  });

  $('.kin5').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin5').index(this) + 1;
      $('.kin5').eq(index).focus();
    }
  });

  $('.kin6').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin6').index(this) + 1;
      $('.kin6').eq(index).focus();
    }
  });

  $('.kin7').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin7').index(this) + 1;
      $('.kin7').eq(index).focus();
    }
  });

  $('.kin8').keydown(function (e) {
    if (e.which === 13) {
      var index = $('.kin8').index(this) + 1;
      $('.kin8').eq(index).focus();
    }
  });
  /////////////////////////////
  //////END////////////////////
  /////////////////////////////

  ////////////////////////KADIV//////
  ///////////////////////UJIAN//////
  $('#kadiv_uj_sk').change(function () {

    $('#kadiv_uj_mapel').html("");
    $('#kadiv_tes_topik').html("");
    var sk_id = $(this).val();
    var t_id = $('#kadiv_uj_t_id').val();
    //alert(sk_id);
    if (sk_id == 0 || t_id == 0) {
      $('#kadiv_uj_kelas').html("");
    }
    else {

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_kelas_by_year_sk",
          data: {
            'sk_id': sk_id,
            't_id': t_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //alert(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Please add Class--</b></div>';
            } else {
              var html = '<select name="kelas_id" id="kadiv_uj_kelas_id" class="form-control mb-3">';
              var i;
              html += '<option value="0">Select Class</option>';
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '</option>';
              }
              html += '</select>';
            }

            $('#kadiv_uj_kelas').html(html);
            refreshKadivMapel();

          }
        });
    }

  });

  $('#kadiv_uj_t_id').change(function () {
    $('#kadiv_uj_sk').change();
  });

  function refreshKadivMapel() {
    $('#kadiv_uj_kelas_id').change(function () {
      $('#kadiv_tes_topik').html("");
      var kelas_id = $(this).val();
      var tes_flag = $('#tes_flag').val();
      //alert(sk_id);
      if (kelas_id == 0) {
        $('#kadiv_uj_mapel').html("");
      }
      else {

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
              //alert(data);
              if (data.length == 0) {
                var html = '<div class="text-center mb-3 text-danger"><b>--No Subject, Please add Subject--</b></div>';
              } else {
                var html = '<select name="mapel_id" id="kadiv_uj_mapel_id" class="form-control mb-3">';
                var i;
                if (tes_flag == 1) {
                  html += '<option value= "0">Select Subject</option>';
                }
                for (i = 0; i < data.length; i++) {
                  html += '<option value=' + data[i].mapel_id + '>' + data[i].mapel_nama + '</option>';
                }
                html += '</select>';
                if (tes_flag != 1) {
                  html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
                  html += 'Input Mid & Final';
                  html += '</button>';
                }

              }

              $('#kadiv_uj_mapel').html(html);
              if (tes_flag == 1) {
                refreshKadivTopik();
              }
            }
          });
      }
    });
  }

  function refreshKadivTopik() {
    $('#kadiv_uj_mapel_id').change(function () {
      var mapel_id = $(this).val();
      var kelas_id = $('#kadiv_uj_kelas_id').val();
      //alert(sk_id);
      if (mapel_id == 0) {
        $('#kadiv_tes_topik').html("");
      }
      else {

        $.ajax(
          {
            type: "post",
            url: base_url + "API/get_topik_by_mapel",
            data: {
              'mapel_id': mapel_id,
              'kelas_id': kelas_id,
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              //alert(data);
              if (data.length == 0) {
                var html = '<div class="text-center mb-3 text-danger"><b>--No Topic, Please add Topic--</b></div>';
              } else {
                var html = '<select name="topik_id" id="kadiv_topik_id" class="form-control mb-3">';
                var i;
                for (i = 0; i < data.length; i++) {
                  html += '<option value=' + data[i].topik_id + '>' + data[i].topik_nama + ' (Sem: ' + data[i].topik_semester + ')</option>';
                }
                html += '</select>';
                html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
                html += 'Input Cognitive and Psychomotor';
                html += '</button>';

              }

              $('#kadiv_tes_topik').html(html);

            }
          });
      }
    });
  }

  /////////////////////////////////
  ////////////////////////////////////
  //////REPORT AFFECTIVE//////////////
  //////////////INDEX/////////////////
  $('#t_id').change(function () {
    var t_id = $(this).val();
    var sk_id = $('#sk_id_report_afek').val();
    //alert(t_id);
    if (t_id == 0) {
      $('#report_afek_kelas').html("");
    }

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
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Please add Class--</b></div>';
          } else {
            var html = '<select name="kelas_id" id="kelas_id" class="form-control mb-3">';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '</option>';
            }
            html += '</select>';

            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'View Report';
            html += '</button>';
          }

          $('#report_afek_kelas').html(html);

        }
      });
  });

  $('#sk_id_report_afek').change(function () {
    $('#t_id').change();
  });
  /////////////////////////////
  //////END////////////////////
  /////////////////////////////

  ////////////////////////////////////
  //////COGNITIVE - PSYSCHOMOTOR//////
  //////////////INDEX/////////////////
  $('#kog_quiz_persen').on('change', function () {
    var total = 100 - $(this).val() - $("#kog_test_persen").val() - $("#kog_ass_persen").val();

    if (total == 0) {
      $("#btn-save").removeAttr('disabled');
      $('#notif').html("");
    } else {
      $("#btn-save").attr('disabled', 'disabled');
      $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
    }

  });

  $('#kog_test_persen').on('change', function () {
    var total = 100 - $(this).val() - $("#kog_quiz_persen").val() - $("#kog_ass_persen").val();

    if (total == 0) {
      $("#btn-save").removeAttr('disabled');
      $('#notif').html("");
    } else {
      $("#btn-save").attr('disabled', 'disabled');
      $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
    }
  });

  $('#kog_ass_persen').on('change', function () {
    var total = 100 - $(this).val() - $("#kog_quiz_persen").val() - $("#kog_test_persen").val();

    if (total == 0) {
      $("#btn-save").removeAttr('disabled');
      $('#notif').html("");
    } else {
      $("#btn-save").attr('disabled', 'disabled');
      $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
    }
  });

  $('#psi_quiz_persen').on('change', function () {
    var total = 100 - $(this).val() - $("#psi_test_persen").val() - $("#psi_ass_persen").val();

    if (total == 0) {
      $("#btn-save").removeAttr('disabled');
      $('#notif').html("");
    } else {
      $("#btn-save").attr('disabled', 'disabled');
      $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
    }

  });

  $('#psi_test_persen').on('change', function () {
    var total = 100 - $(this).val() - $("#psi_quiz_persen").val() - $("#psi_ass_persen").val();

    if (total == 0) {
      $("#btn-save").removeAttr('disabled');
      $('#notif').html("");
    } else {
      $("#btn-save").attr('disabled', 'disabled');
      $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
    }
  });

  $('#psi_ass_persen').on('change', function () {
    var total = 100 - $(this).val() - $("#psi_quiz_persen").val() - $("#psi_test_persen").val();

    if (total == 0) {
      $("#btn-save").removeAttr('disabled');
      $('#notif').html("");
    } else {
      $("#btn-save").attr('disabled', 'disabled');
      $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
    }
  });


  $('#tes_t_id').change(function () {

    var t_id = $(this).val();
    $('#kelas_tes_ajax').html("");
    $('#mapel_tes_ajax').html("");
    $('#topik_tes_ajax').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_kelas_by_kr",
        data: {
          't_id': t_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Please add Class--</b></div>';
          } else {
            var html = '<select name="kelas_id" id="kelas_tes_id" class="form-control mb-3">';
            var i;
            html += '<option value=0>Select Class</option>';
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '-' + data[i].sk_nama + '</option>';
            }
            html += '</select>';

          }

          $('#kelas_tes_ajax').html(html);
          refreshTesKelas();

        }
      });
  });

  function refreshTesKelas() {
    $('#kelas_tes_id').change(function () {
      var kelas_id = $(this).val();
      var flag = $('#flag_uj').val();
      //alert(flag);
      $('#topik_tes_ajax').html("");

      //alert("hai");
      if (kelas_id == 0) {
        $('#mapel_tes_ajax').html("");
      }

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_mapel_by_kr_kelas",
          data: {
            'kelas_id': kelas_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Class--</b></div>';
            } else {
              var html = '<select name="mapel_id" id="tes_mapel_id" class="form-control mb-3">';

              if (flag != 1) {
                html += '<option value=0>Select Subject</option>';
              }
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].mapel_id + '>' + data[i].mapel_nama + '</option>';
              }
              html += '</select>';

              if (flag == 1) {
                html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
                html += 'Input Mid and Final';
                html += '</button>';
              }

            }

            $('#mapel_tes_ajax').html(html);
            if (flag != 1) {
              refreshTesMapel();
            }
          }
        });
    });
  }

  function refreshTesMapel() {
    $('#tes_mapel_id').change(function () {

      $('#topik_tes_ajax').html("");
      var mapel_id = $(this).val();

      var kelas_id = $('#kelas_tes_id').val();

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_topik_by_mapel",
          data: {
            'mapel_id': mapel_id,
            'kelas_id': kelas_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Topic, Please add 1 or more Topic--</b></div>';
            } else {
              var html = '<select name="topik_id" class="form-control mb-3">';
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].topik_id + '>' + data[i].topik_nama + ' (Sem: ' + data[i].topik_semester + ')</option>';
              }
              html += '</select>';
              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Input Cognitive and Psychomotor';
              html += '</button>';
            }

            $('#topik_tes_ajax').html(html);

          }
        });
    });
  }


  /////////////////////////////
  //////END////////////////////
  /////////////////////////////
  ////////////////////////////////////
  //////AFEKTIF///////////////////////
  //////////////INDEX/////////////////
  refreshHasil();
  refreshMingguAktif();

  function refreshMingguAktif() {
    var total_aktif = parseInt($("#option_minggu1").val()) + parseInt($("#option_minggu2").val()) + parseInt($("#option_minggu3").val()) + parseInt($("#option_minggu4").val()) + parseInt($("#option_minggu5").val());

    $('#afek_minggu_aktif').val(total_aktif);
  }

  $('#afek_t_id').change(function () {
    var t_id = $(this).val();


    $('#topik_afek_ajax').html("");
    $('#kelas_afek_ajax').html("");
    $('#mapel_afek_ajax').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_kelas_by_kr",
        data: {
          't_id': t_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Please add Class--</b></div>';
          } else {
            var html = '<select name="kelas_id" id="kelas_afek_id" class="form-control mb-3">';
            var i;
            html += '<option value=0>Select Class</option>';
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '-' + data[i].sk_nama + '</option>';
            }
            html += '</select>';

          }

          $('#kelas_afek_ajax').html(html);
          refreshKelasAfektif();
        }
      });
  });

  function refreshKelasAfektif() {
    $('#kelas_afek_id').change(function () {
      var kelas_id = $(this).val();
      //alert(flag);
      $('#mapel_afek_ajax').html("");
      $('#topik_afek_ajax').html("");

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_mapel_by_kr_kelas",
          data: {
            'kelas_id': kelas_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Class--</b></div>';
            } else {
              var html = '<select name="mapel_id" id="afek_mapel_id" class="form-control mb-3">';
              html += '<option value=0>Select Subject</option>';
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].mapel_id + '>' + data[i].mapel_nama + '</option>';
              }
              html += '</select>';


            }

            $('#mapel_afek_ajax').html(html);
            refreshAfekMapel();
          }
        });
    });
  }

  function refreshAfekMapel() {
    $('#afek_mapel_id').change(function () {
      var mapel_id = $(this).val();
      var kelas_id = $('#kelas_afek_id').val();

      $('#topik_afek_ajax').html("");

      $.ajax(
        {
          type: "post",
          url: base_url + "Afek_CRUD/get_topik",
          data: {
            'mapel_id': mapel_id,
            'kelas_id': kelas_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Affective Topic, Contact Counselor--</b></div>';
            } else {
              var html = '<select name="k_afek_id" id="k_afek_id" class="form-control mb-3">';
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].k_afek_id + '>' + data[i].bulan_nama + ' (' + data[i].k_afek_topik_nama + ')</option>';
              }
              html += '</select>';

              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Insert Affective';
              html += '</button>';
            }

            $('#topik_afek_ajax').html(html);

          }
        });
    });
  }



  $("#option_minggu1").change(function () {

    var aktif1 = $("#option_minggu1").val();

    if (aktif1 == 0) {
      $('input[type=number].minggu1').val('0')
      $('input[type=number].minggu1').attr("readonly", true);

    } else {
      $('input[type=number].minggu1').val('3')
      $('input[type=number].minggu1').attr("readonly", false);
    }
    refreshHasil();
    refreshMingguAktif();
  });

  $("#option_minggu2").change(function () {

    var aktif2 = $("#option_minggu2").val();

    if (aktif2 == 0) {
      $('input[type=number].minggu2').val('0')
      $('input[type=number].minggu2').attr("readonly", true);
    } else {
      $('input[type=number].minggu2').val('3')
      $('input[type=number].minggu2').attr("readonly", false);
    }
    refreshHasil();
    refreshMingguAktif();
  });

  $("#option_minggu3").change(function () {

    var aktif3 = $("#option_minggu3").val();

    if (aktif3 == 0) {
      $('input[type=number].minggu3').val('0')
      $('input[type=number].minggu3').attr("readonly", true);
    } else {
      $('input[type=number].minggu3').val('3')
      $('input[type=number].minggu3').attr("readonly", false);
    }
    refreshHasil();
    refreshMingguAktif();
  });

  $("#option_minggu4").change(function () {

    var aktif4 = $("#option_minggu4").val();

    if (aktif4 == 0) {
      $('input[type=number].minggu4').val('0')
      $('input[type=number].minggu4').attr("readonly", true);
    } else {
      $('input[type=number].minggu4').val('3')
      $('input[type=number].minggu4').attr("readonly", false);
    }
    refreshHasil();
    refreshMingguAktif();
  });

  $("#option_minggu5").change(function () {

    var aktif5 = $("#option_minggu5").val();

    if (aktif5 == 0) {
      $('input[type=number].minggu5').val('0')
      $('input[type=number].minggu5').attr("readonly", true);
    } else {
      $('input[type=number].minggu5').val('3')
      $('input[type=number].minggu5').attr("readonly", false);
    }
    refreshHasil();
    refreshMingguAktif();
  });

  function refreshHasil() {

    pembagi = 0;
    if ($('.option_minggu1').val() == 1) {
      pembagi++;
    }
    if ($('.option_minggu2').val() == 1) {
      pembagi++;
    }
    if ($('.option_minggu3').val() == 1) {
      pembagi++;
    }
    if ($('.option_minggu4').val() == 1) {
      pembagi++;
    }
    if ($('.option_minggu5').val() == 1) {
      pembagi++;
    }


    var total = $('.minggu1a1').length;

    for (var i = 1; i <= total; i++) {
      var total_minggu = 0;
      $('.' + i).each(function () {
        total_minggu += parseInt($(this).val());
      })

      if (pembagi != 0) {
        total_minggu /= pembagi;
        if (total_minggu.toFixed(2) >= 7.65) {
          $('.t' + i).html("A (" + total_minggu.toFixed(2) + ")");
        } else if (total_minggu.toFixed(2) >= 6.3) {
          $('.t' + i).html("B (" + total_minggu.toFixed(2) + ")");
        } else if (total_minggu.toFixed(2) >= 4.95) {
          $('.t' + i).html("<div class='text-danger'><b>C (" + total_minggu.toFixed(2) + ")</b></div>");
        } else {
          $('.t' + i).html("<div class='text-danger'><b>D (" + total_minggu.toFixed(2) + ")</b></div>");
        }
      } else {
        $('.t' + i).html("-");
      }

    }
  }

  $("input[type=number]").change(function () {
    refreshHasil();
  });


  /////////////////////////////
  //////END////////////////////
  /////////////////////////////

  ////////////////////////////////////
  //////////////KOMEN////////////////
  //////////////INDEX/////////////////

  $('#kelas_komen').change(function () {
    var id = $(this).val();

    if (id == 0) {
      $('#siswa_ajax').html("");
      $('#komen_ajax').html("");
    }

    $.ajax(
      {
        type: "post",
        url: base_url + "Komen_CRUD/get_siswa",
        data: {
          'id': id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Student, Contact School Administrative Officer--</b></div>';
          } else {
            var html = '<select name="d_s_id" id="komen_sis_id" class="form-control mb-3 komen_sis_id">';
            html += '<option value="0">Select Student</option>';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].d_s_id + '>' + data[i].sis_nama_depan + '</option>';
            }
            html += '</select>';
          }

          $('#siswa_ajax').html(html);
          refreshEvent();
        }
      });
  });
  function refreshEvent() {
    $('.komen_sis_id').change(function () {
      var id = $(this).val();
      //alert(id);
      if (id == 0) {
        $('#komen_ajax').html("");
      }

      $.ajax(
        {
          type: "post",
          url: base_url + "Komen_CRUD/get_komen",
          data: {
            'id': id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--Something went wrong, contact admin/developer--</b></div>';
            } else {
              //console.log(data);
              var html = "";
              var d_s_sick = "";
              var d_s_absenin = "";
              var d_s_absenex = "";
              var d_s_sick2 = "";
              var d_s_absenin2 = "";
              var d_s_absenex2 = "";
              if (data[0].d_s_sick) {
                d_s_sick = data[0].d_s_sick;
              }
              if (data[0].d_s_absenin) {
                d_s_absenin = data[0].d_s_absenin;
              }
              if (data[0].d_s_absenex) {
                d_s_absenex = data[0].d_s_absenex;
              }
              if (data[0].d_s_sick2) {
                d_s_sick2 = data[0].d_s_sick2;
              }
              if (data[0].d_s_absenin2) {
                d_s_absenin2 = data[0].d_s_absenin2;
              }
              if (data[0].d_s_absenex2) {
                d_s_absenex2 = data[0].d_s_absenex2;
              }
              //SEM 1
              html += '<h5 class="ml-2 mt-3"><u>Semester 1</u></h5><input type="number" value="' + d_s_sick + '" class="form-control mb-2" placeholder="Sick" required name="d_s_sick">';
              html += '<input type="number" value="' + d_s_absenin + '"  class="form-control mb-2" placeholder="Absent (Including Excuse)" required name="d_s_absenin">';
              html += '<input type="number" value="' + d_s_absenex + '" class="form-control mb-2" placeholder="Absent (Excluding Excuse)" required name="d_s_absenex">';
              html += '<textarea rows="4" name="d_s_komen_sis" class="form-control mb-2" placeholder="Mid comment">';
              if (data[0].d_s_komen_sis) {
                html += data[0].d_s_komen_sis;
              }
              html += '</textarea>';

              html += '<textarea rows="4" name="d_s_komen_sem" class="form-control mb-2" placeholder="Final comment">';
              if (data[0].d_s_komen_sem) {
                html += data[0].d_s_komen_sem;
              }
              html += '</textarea>';

              //SEM 2
              html += '<h5 class="ml-2 mt-3"><u>Semester 2</u></h5><input type="number" value="' + d_s_sick2 + '" class="form-control mb-2" placeholder="Sick" required name="d_s_sick2">';
              html += '<input type="number" value="' + d_s_absenin2 + '" class="form-control mb-2" placeholder="Absent (Including Excuse)" required name="d_s_absenin2">';
              html += '<input type="number" value="' + d_s_absenex2 + '" class="form-control mb-2" placeholder="Absent (Excluding Excuse)" required name="d_s_absenex2">';
              html += '<textarea rows="4" name="d_s_komen_sis2" class="form-control mb-2" placeholder="Mid comment">';
              if (data[0].d_s_komen_sis2) {
                html += data[0].d_s_komen_sis2;
              }
              html += '</textarea>';

              html += '<textarea rows="4" name="d_s_komen_sem2" class="form-control mb-2" placeholder="Final comment">';
              if (data[0].d_s_komen_sem2) {
                html += data[0].d_s_komen_sem2;
              }
              html += '</textarea>';

              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Insert Comment';
              html += '</button>';

            }

            $('#komen_ajax').html(html);

          }
        });
    });
  }


  /////////////////////////////
  //////END////////////////////
  /////////////////////////////

  ///////print area////////////
  $("#export_excel").click(function (e) {
    //alert("hai");
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#print_area').html()));
    e.preventDefault();
  });

  /////////////////////////////
  ///////Report Print//////////
  /////////////////////////////
  $('#sk_id_report').change(function () {
    $('#t').change();
  });
  $('#t').change(function () {
    var id = $(this).val();
    var sk_id = $('#sk_id_report').val();

    $('#kelas_ajax').html("");
    $('#siswa_ajax').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "Report_CRUD/get_kelas",
        data: {
          'id': id,
          'sk_id': sk_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Add Class First--</b></div>';
          } else {
            var html = '<select name="kelas_id" id="kelas_id" class="form-control mb-3 kelas_id">';
            html += '<option value="0">Select Class</option>';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '</option>';
            }
            html += '</select>';
          }

          $('#kelas_ajax').html(html);
          refreshEventKelas();
        }
      });
  });

  function refreshEventKelas() {
    $('.kelas_id').change(function () {
      var id = $(this).val();
      //alert(id);
      if (id == 0) {
        $('#siswa_ajax').html("");
      }

      $.ajax(
        {
          type: "post",
          url: base_url + "Report_CRUD/get_siswa",
          data: {
            'id': id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Student(s), please add 1 or more student--</b></div>';
            } else {
              var i;
              html = "";

              html += '<hr><div class="form-group d-flex justify-content-center"><label class="checkbox-inline mr-2"><input class="checkAll" type="checkbox"> <b><u>CHECK ALL</u></b></label><label class="checkbox-inline mr-2"><input class="checkSsp" name="checkSsp" checked type="checkbox"> <b><u>SHOW SSP</u></b></label><label class="checkbox-inline "><input class="checkSsp" checked type="checkbox"> <b><u>SHOW SCOUT</u></b></label></div><hr>';


              for (i = 0; i < data.length; i++) {
                html += '<div class="checkbox ml-2">';
                html += '<label><input type="checkbox" name="siswa_check[]" class="sisC" value="' + data[i].d_s_id + '"> ' + data[i].sis_nama_depan + ' ' + data[i].sis_nama_bel + '</label>';
                html += '</div>';
              }

              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Show Report';
              html += '</button>';

            }

            $('#siswa_ajax').html(html);
            refreshCheck();

          }
        });
    });
  }

  function refreshCheck() {
    $(".checkAll").click(function () {
      $('input.sisC:checkbox').not(this).prop('checked', this.checked);
    });
  }
  /////////////////////////////
  /////////////////////////////
  ////////SSP TOPIK CRUD//////
  $(".page_tambah_topik_ssp").hide();
  $(".tambah_topik_ssp").click(function () {
    $(".page_tambah_topik_ssp").show();
    $('html, body').animate({
      scrollTop: $("#myDiv").offset().top
    }, 2000);
  });
  $(".close_page_tambah_topik_ssp").click(function () {
    $(".page_tambah_topik_ssp").hide();
  });

  $('.ssp_topik_ssp_id').on('change', function () {
    var ssp_id = $(this).val();

    if (ssp_id != 0) {
      $.ajax(
        {
          type: "post",
          url: base_url + "SSP_topik_CRUD/get_topik",
          data: {
            'ssp_id': ssp_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            console.log(data);
            if (data.length == 0) {
              htmlStr = '<table class="table table-bordered"><thead class="thead-dark"><tr><th>Topic Name</th><th>Semester</th><th>Desc A</th><th>Desc B</th><th>Desc C</th><th>Action</th></tr></thead><tbody>';
              htmlStr += '<td colspan="6" class="text-center">No Data</td>';
              htmlStr += '</tr></tbody></table>';
              $('#sspTabel').html(htmlStr);
            } else {
              htmlStr = '<table class="table table-bordered"><thead class="thead-dark"><tr><th>Topic Name</th><th>Semester</th><th>Desc A</th><th>Desc B</th><th>Desc C</th><th>Action</th></tr></thead><tbody>';

              var i;
              for (i = 0; i < data.length; i++) {

                semester = "";
                if (data[i].ssp_topik_semester == 1) {
                  semester = "Odd";
                } else {
                  semester = "Even";
                }

                htmlStr += '<tr>';
                htmlStr += '<td>' + data[i].ssp_topik_nama + '</td>';
                htmlStr += '<td>' + semester + '</td>';
                htmlStr += '<td>' + data[i].ssp_topik_a + '</td>';
                htmlStr += '<td>' + data[i].ssp_topik_b + '</td>';
                htmlStr += '<td>' + data[i].ssp_topik_c + '</td>';

                htmlStr += '<td><div class="form-group row p-2"><form action="ssp_topik_crud/edit_page" method="POST">';
                htmlStr += '<input type="hidden" name="_id" value=' + data[i].ssp_topik_id + '>';
                htmlStr += '<button type="submit" class="badge badge-success">';
                htmlStr += '<i class="fa fa-edit"></i>';
                htmlStr += 'Edit Topic';
                htmlStr += '</button></form></div></td>';

                htmlStr += '</tr>';
              }

              htmlStr += '</tbody></table>';
            }

            $('#sspTabel').html(htmlStr);

          }
        });
    } else {
      htmlStr = '<table class="table table-bordered"><thead class="thead-dark"><tr><th>Topic Name</th><th>Semester</th><th>Desc A</th><th>Desc B</th><th>Desc C</th><th>Action</th></tr></thead><tbody>';
      htmlStr += '<td colspan="6" class="text-center">No Data</td>';
      htmlStr += '</tr></tbody></table>';
      $('#sspTabel').html(htmlStr);
    }

  }).change();
  /////////////////////////////
  /////////////////////////////
  ////////SSP EDIT STUDENT//////

  var sspId = $("#sspInputId").val();
  if (sspId) {
    setInterval(function () {
      refreshSspList();
    }, 3000);
  }

  function refreshSspList() {
    var sspId = $("#sspInputId").val();


    $.ajax({
      url: base_url + 'SSP_CRUD/get_siswaSSP',
      data: {
        'sspId': sspId,
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
            html += '<form method="post" action="' + base_url + 'SSP_CRUD/deleteSiswaSSP">';
            html += '<input type="hidden" name="ssp_peserta_id" value= ' + data[i].ssp_peserta_id + '>';
            html += '<input type="hidden" name="d_s_id" value= ' + data[i].d_s_id + '>';
            html += '<input type="hidden" name="ssp_id" value= ' + sspId + '>';
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

        $('#siswaSSPAjax').html(html);
      }
    });
  }

  $('#kelas_ssp').change(function () {
    var id = $(this).val();
    var sspId = $("#sspInputId").val();
    if (id == 0) {
      $('#siswaKelasAjax').html("");
    }

    $.ajax(
      {
        type: "post",
        url: base_url + "SSP_CRUD/get_siswaKelas",
        data: {
          'id': id,
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
            html += '<form method="post" class="sspEditStudentForm" id="sspEditStudentForm" action="' + base_url + 'SSP_CRUD/addStudent">';
            html += '<div><input type="hidden" name="sspId" value="' + sspId + '"</div>';
            for (i = 0; i < data.length; i++) {
              html += '<div class="checkbox ml-2">';
              html += '<label><input type="checkbox" name="siswa_check[]" class="sisC" value="' + data[i].d_s_id + '"> ' + data[i].sis_nama_depan + ' ' + data[i].sis_nama_bel + '</label>';
              html += '</div>';
            }

            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Insert to SSP';
            html += '</button>';
            html += '</form>';
          }

          $('#siswaKelasAjax').html(html);
          refreshsspEditStudentForm();
        }
      });
  });

  function refreshsspEditStudentForm() {
    $(".sspEditStudentForm").submit(function (evt) {
      evt.preventDefault();

      if ($('.sspEditStudentForm :checkbox:checked').length > 0) {
        // one or more checkboxes are checked
        var form = $(this);
        $.ajax({
          url: base_url + "SSP_CRUD/addStudent",
          data: form.serialize(),
          type: "POST",
          dataType: "html",
          success: function (data) {
            //alert(data);
            $(".sspMsg").html(data);
            $("#sspEditStudentForm")[0].reset();
            $('#siswaKelasAjax').html("");
          }
        });
      }
      else {
        $(".sspMsg").html("<div class='alert alert-danger' role='alert'>Please select one or more students</div>");
      }

    });
  }



  //////////////////////////////
  /////////////////////////////
  ////////SSP GRADE INDEX//////
  /////////////////////////////
  $('#arr_ssp').change(function () {
    var id = $(this).val();

    if (id == 0) {
      $('#topikSsp_ajax').html("");
    }

    $.ajax(
      {
        type: "post",
        url: base_url + "SSP_grade_CRUD/get_topik",
        data: {
          'id': id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Topic, Please add Topic--</b></div>';
          } else {
            var html = '<select name="ssp_topik_id" id="ssp_topik_id" class="form-control mb-3">';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].ssp_topik_id + '>' + data[i].ssp_topik_nama + ' (Sem: ' + data[i].ssp_topik_semester + ')</option>';
            }
            html += '</select>';

            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Insert SSP Grade';
            html += '</button>';
          }

          $('#topikSsp_ajax').html(html);

        }
      });
  });

  ///PRINT
  $("#print_rekap").click(function () {
    $('#print_area').printThis({
      importCSS: false,
      importStyle: true,//thrown in for extra measure
      loadCSS: base_url + "css/rapot.css"
    });
    //alert(base_url + "css/rapot.css");
  });

  //////////////////////////////
  /////////////////////////////
  ////////TOPIK INDEX//////////
  /////////////////////////////
  $('#sub_topik_crud').hide();
  $('#topik_mapel').change(function () {
    var id = $(this).val();
    var topik_jabatan_id = $('#topik_jabatan_id').val();
    //alert(topik_jabatan_id);
    if (id == 0) {
      $('#topik_mapel_ajax').html("");
      $('#sub_topik_crud').hide();
    } else {
      $('#sub_topik_crud').show();
    }

    $.ajax(
      {
        type: "post",
        url: base_url + "Topik_CRUD/get_topik_detail",
        data: {
          'id': id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);

          var html = '<table class="table table-bordered table-sm mt-2">';
          html += '<thead class="thead-dark">';
          html += '<tr>';
          html += '<th>Grade</th>';
          html += '<th>Semester</th>';
          html += '<th>Topic Name</th>';
          html += '<th>Total Grade</th>';
          html += '<th>Order Number</th>';
          html += '<th>Action</th>';
          html += '</tr>';
          html += '</thead>';

          html += '<tbody>';
          if (data.length != 0) {
            for (var i = 0; i < data.length; i++) {
              html += '<tr>';
              html += '<td>' + data[i].jenj_nama + '</td>';
              html += '<td>' + data[i].topik_semester + '</td>';
              html += '<td>' + data[i].topik_nama + '</td>';
              html += '<td>' + data[i].jum_tes + '</td>';
              html += '<td>' + data[i].topik_urutan + '</td>';
              html += '<td>';
              html += '<div class="form-group row pl-3">';
              html += '<form method="post" action="' + base_url + 'topik_CRUD/edit">';
              html += '<input type="hidden" value="' + data[i].topik_id + '" name="topik_id">';
              html += '<input type="hidden" value="' + data[i].topik_mapel_id + '" name="mapel_id">';
              html += '<button type="submit" class="badge badge-warning">';
              html += 'Edit';
              html += '</button>';

              html += '</form>';

              if (topik_jabatan_id == 4) {
                html += '<form method="post" action="' + base_url + 'topik_CRUD/delete">';

                html += '<input type="hidden" value="' + data[i].topik_id + '" name="topik_id">';
                html += '<button type="submit" class="badge badge-danger">';
                html += 'Delete';
                html += '</button>';

                html += '</form>';
              }
              html += '</div>';
              html += '</td>';
              html += '</tr>';
            }
          } else {
            html += '<td colspan="6" class="text-center table-danger"><b>--No Topic(s), please add 1 or more topic--</b></td>';
          }
          html += '</tbody>';
          html += '</table>';


          //alert(html);

          $('#topik_mapel_ajax').html(html);

        }
      });
  });
  /////////////////////////////
  ////////////TATIB////////////
  /////////////////////////////
  $('#t_tatib').change(function () {
    var id = $(this).val();

    $('#kelas_tatib_ajax').html("");
    $('#siswa_tatib_ajax').html("");
    $('#btn_tatib').html("");
    $('#detail_tatib').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "Tatib_CRUD/get_kelas",
        data: {
          'id': id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Add Class First--</b></div>';
          } else {
            var html = '<select name="kelas_tatib_id" id="kelas_tatib_id" class="form-control mb-2 kelas_tatib_id">';
            html += '<option value="0">Select Class</option>';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '</option>';
            }
            html += '</select>';
          }

          $('#kelas_tatib_ajax').html(html);
          refreshEventKelasTatib();
        }
      });
  });

  function refreshEventKelasTatib() {
    $('.kelas_tatib_id').change(function () {
      var id = $(this).val();
      //alert(id);
      if (id == 0) {
        $('#siswa_tatib_ajax').html("");
        $('#btn_tatib').html("");
        $('#detail_tatib').html("");
      }

      $.ajax(
        {
          type: "post",
          url: base_url + "Tatib_CRUD/get_siswa",
          data: {
            'id': id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Student(s), contact curriculum for more information--</b></div>';
            } else {
              var i;
              html = "";

              html += '<select name="siswa_tatib_id" id="siswa_tatib_id" class="form-control mb-3 siswa_tatib_id">';
              html += '<option value="0">Select Student</option>';
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].d_s_id + '>' + data[i].sis_nama_depan + ' ' + data[i].sis_nama_bel + '</option>';
              }
              html += '</select>';


            }

            $('#siswa_tatib_ajax').html(html);
            refreshEventBtnTatib();

          }
        });
    });
  }

  function refreshEventBtnTatib() {
    $('.siswa_tatib_id').change(function () {
      var id = $(this).val();

      var html3 = "";
      //alert(id);
      if (id == 0) {
        $('#btn_tatib').html("");
        $('#detail_tatib').html("");
      } else {


        html2 = '<div class="text-center mt-5"><h4>Student Detail</h4>';
        html2 += '<button type="submit" class="btn btn-primary mt-2">';
        html2 += 'Add Infraction/Achievement';
        html2 += '</button></div>';

        $.ajax(
          {
            type: "post",
            url: base_url + "Tatib_CRUD/get_detail_tatib",
            data: {
              'id': id,
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              if (data.length == 0) {
                html3 += '<div class="text-center mt-3 text-danger"><b>--No data available--</b></div>';
              } else {
                html3 += '<table class="table table-bordered table-sm mt-2">';
                html3 += '<thead class="thead-dark">';
                html3 += '<tr>';
                html3 += '<th>Date</th>';
                html3 += '<th>Notes</th>';
                html3 += '<th>Type</th>';
                html3 += '<th>Category</th>';
                html3 += '<th>Action</th>';
                html3 += '</tr>';
                html3 += '</thead>';

                html3 += '<tbody>';
                //alert(html3);
                if (data.length != 0) {
                  var langgar;
                  var jenis;
                  for (var i = 0; i < data.length; i++) {
                    langgar = "";

                    if (data[i].tatib_langgar == 1) {
                      langgar = "Infraction";
                    }
                    else if (data[i].tatib_langgar == 2) {
                      langgar = "Achievement";
                    }
                    else if (data[i].tatib_langgar == 3) {
                      langgar = "Counseling";
                    }

                    if (data[i].tatib_jenis == 1) {
                      jenis = "Private";
                    }
                    else if (data[i].tatib_jenis == 2) {
                      jenis = "Public";
                    }
                    html3 += '<tr>';
                    html3 += '<td>' + data[i].tatib_tanggal + '</td>';
                    html3 += '<td>' + data[i].tatib_notes + '</td>';
                    html3 += '<td>' + langgar + '</td>';
                    html3 += '<td>' + jenis + '</td>';
                    html3 += '<td>';
                    html3 += '<form method="post" action="' + base_url + 'Tatib_CRUD/edit">';

                    html3 += '<input type="hidden" value="' + data[i].tatib_id + '" name="tatib_id">';
                    html3 += '<button type="submit" class="badge badge-warning">';
                    html3 += 'Edit';
                    html3 += '</button>';

                    html3 += '</form>';

                    html3 += '<form method="post" action="' + base_url + 'Tatib_CRUD/delete">';

                    html3 += '<input type="hidden" value="' + data[i].tatib_id + '" name="tatib_id">';
                    html3 += '<button type="submit" class="badge badge-danger">';
                    html3 += 'Delete';
                    html3 += '</button>';

                    html3 += '</form>';
                    html3 += '</td>';
                    html3 += '</tr>';
                  }
                } else {
                  html3 += '<td colspan="4" class="text-center table-danger"><b>--No Topic(s), please add 1 or more topic--</b></td>';
                }
                html3 += '</tbody>';
                html3 += '</table>';
              }

              $('#detail_tatib').html(html3);
            }
          });

        $('#btn_tatib').html(html2);
      }
    });
  }


});