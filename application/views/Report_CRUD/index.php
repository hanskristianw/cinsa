<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select Year, Class and Students</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="Report_CRUD/show" method="POST">
              
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="sk" id="sk_id_report" class="form-control sk_id_report">
                    <option value="0">Select School</option>
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="t" id="t" class="form-control">
                    <option value="0">Select Year</option>
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?= $m['t_id'] ?>'>
                        <?= $m['t_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="semester" id="semester" class="form-control">
                    <option value="1">Odd Semester</option>
                    <option value="2">Even Semester</option>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="pJenis" id="pJenis" class="form-control">
                    <option value="0">Report Mid</option>
                    <option value="1">Report Final</option>
                  </select>
                </div>
              </div>

              <div id="guru_cb">
              
              </div>

              <div id="kelas_ajax">
              
              </div>
              <div id="siswa_ajax">
              
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
$(document).ready(function () {

  $('#guru_cb').hide();

  $('#pJenis').change(function () {
    var jenis = $(this).val();
    if(jenis == 1){
      $('#guru_cb').show();
    }else{
      $('#guru_cb').hide();
    }
  });

  $('.sk_id_report').change(function () {

    var sk_id = $(this).val();
    //alert("hai");
    //alert(sk_id);
    if (sk_id == 0) {
      $('#guru_cb').html("");
    }
    else {

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_guru_cb_by_sk",
          data: {
            'sk_id': sk_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //alert(data);
            var html = '';
            var check = "";
            if (data.length != 0) {
              html += '<label class="ml-2"><b>Counselor: </b></label>';
              html += '<select name="guru_cb" class="form-control mb-3">';
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].kr_gelar_depan + data[i].kr_nama_depan + ' ' +data[i].kr_nama_belakang + ' ' +data[i].kr_gelar_belakang + '">' + data[i].kr_gelar_depan + data[i].kr_nama_depan + ' '+data[i].kr_nama_belakang + ' ' + data[i].kr_gelar_belakang + '</option>';
              }
              html += '</select>';
            } else {
              html += '<select name="guru_cb" class="form-control mb-3">';
              html += '<option value= "-" >' + '-' + '</option>';
              html += '</select>';
            }

            $('#guru_cb').html(html);

          }
        });
    }

  });

});

</script>