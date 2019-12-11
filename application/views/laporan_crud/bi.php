<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            
            
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-2"><?= $title ?></h1>
              <h5><u>Select School and Year</u></h5>
            </div>
            <br>
            <div class="alert alert-info alert-dismissible fade show mb-4">
              <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
              </button>
              <strong>INFO: </strong> Semakin banyak memilih siswa maka proses penyajian data akan semakin lama
            </div>
            <?= $this->session->flashdata('message'); ?>
            
            <form method="post" action="<?= base_url('laporan_crud/bi_show'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="sk_id" id="sk_id_dkn" class="form-control">
                    <option value="0">Select School</option>
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="t_id" id="t_dkn" class="form-control">
                    <option value="0">Select Year</option>
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?= $m['t_id'] ?>'>
                        <?= $m['t_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div id="kelas_ajax_dkn">
              
              </div>
              <div id="siswa_ajax_dkn">
              
              </div>
            </form>

            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
$(document).ready(function () {
  $('#sk_id_dkn').change(function () {
    $('#t').change();
  });
  $('#t_dkn').change(function () {
    var id = $(this).val();
    var sk_id = $('#sk_id_dkn').val();

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

          $('#kelas_ajax_dkn').html(html);
          refreshEventKelasbi();
        }
      });
  });

  function refreshEventKelasbi() {
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

              html += '<hr><div class="form-group d-flex justify-content-center"><label class="checkbox-inline mr-2"><input class="checkAll" type="checkbox"> <b><u>CHECK ALL</u></b></label></div><hr>';


              for (i = 0; i < data.length; i++) {
                html += '<div class="checkbox ml-2">';
                html += '<label><input type="checkbox" name="siswa_check[]" class="sisCdkn" value="' + data[i].d_s_id + '"> ' + data[i].sis_nama_depan + ' ' + data[i].sis_nama_bel + '</label>';
                html += '</div>';
              }

              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Show';
              html += '</button>';

            }

            $('#siswa_ajax_dkn').html(html);
            refreshCheckdkn();

          }
        });
    });
  }
  function refreshCheckdkn() {
    $(".checkAll").click(function () {
      $('input.sisCdkn:checkbox').not(this).prop('checked', this.checked);
    });
  }
});
</script>