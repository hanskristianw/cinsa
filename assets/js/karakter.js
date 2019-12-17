$(document).ready(function () {
  $('#karakter_sk').change(function () {

    var sk_id = $(this).val();
    var karakter_id = $('#karakter_id').val();

    //alert(sk_id);
    if (karakter_id == 0 || sk_id == 0) {
      $('#karakter_detail').html("");
    }
    else {

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_subject_by_karakter_and_sk",
          data: {
            'sk_id': sk_id,
            'karakter_id': karakter_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //alert(data);
            var html = '';
            var check = "";
            if (data.length != 0) {
              for (i = 0; i < data.length; i++) {
                if (data[i].karakter_detail_mapel_id) {
                  check = "checked";
                }
                html += '<input type="hidden" name="karakter_detail_id[]" value=' + data[i].karakter_detail_id + '>';
                html += '<div class="checkbox ml-2">';
                html += '<label><input type="checkbox" ' + check + ' name="mapel_check[]" class="mapel_check" value="' + data[i].mapel_id + '"> ' + data[i].mapel_nama + '</label>';
                html += '</div>';
                check = "";
              }

              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Save Character';
              html += '</button>';
            } else {
              html += '<h4 class="text-center"><b>--No Subject(s), add 1 or more Subject--</b></h4>';
            }

            $('#karakter_detail').html(html);

          }
        });
    }

  });

});