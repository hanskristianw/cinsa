<style>
.grid-container {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 120px;
  padding-top: 50px;
}


.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}
</style>


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <label><b>Tahun:</b></label>
    <select name="t_id" id="t_id_jurnal" class="form-control form-control-sm mb-2">
      <option value="0">Pilih Tahun</option>
      <?php foreach ($t_all as $t) : ?>
        <option value='<?=$t['t_id'] ?>'>
          <?= $t['t_nama'] ?>
        </option>
      <?php endforeach ?>
    </select>

    <div id="kelas_id_jurnal_ajax"></div>
    <div id="mapel_id_jurnal_ajax"></div>

    <div id="daftar_jurnal_ajax"></div>

  </div>
</div>

<script>

$(document).ready(function() {

  $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
  });

  $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-danger").slideUp(500);
  });
  
  $('#t_id_jurnal').change(function () {

    var t_id = $(this).val();
    $('#kelas_id_jurnal_ajax').html("");
    $('#mapel_id_jurnal_ajax').html("");
    $('#daftar_jurnal_ajax').html("");

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
            var html = '<label><b>Kelas:</b></label><select name="kelas_id" id="kelas_id_jurnal" class="form-control form-control-sm mb-3">';
            var i;
            html += '<option value=0>Pilih Kelas Ajar</option>';
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama +' - '+ data[i].sk_nama + '</option>';
            }
            html += '</select>';

          }

          $('#kelas_id_jurnal_ajax').html(html);
          refreshMapelJurnal();

        }
      });
  });

  function refreshMapelJurnal() {
    $('#kelas_id_jurnal').change(function () {
      var kelas_id = $(this).val();
      //alert(flag);
      $('#mapel_id_jurnal_ajax').html("");
      $('#daftar_jurnal_ajax').html("");
      
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
            
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Subject In Class--</b></div>';
            } else {
              var html = '<label><b>Mapel:</b></label><select name="mapel_id" id="mapel_id_jurnal" class="form-control form-control-sm mb-3">';

              html += '<option value=0>Pilih Mapel</option>';
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].mapel_id + '>' + data[i].mapel_nama + '</option>';
              }
              html += '</select>';

              // html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              // html += 'Input Mid and Final';
              // html += '</button>';

            }

            $('#mapel_id_jurnal_ajax').html(html);
            //refreshTglJurnal();
            refreshDaftarJurnal();
          }
        });
    });
  }

  function refreshDaftarJurnal(){
    $('#mapel_id_jurnal').change(function () {
      
      $('#daftar_jurnal_ajax').html("");
      var mapel_id = $('#mapel_id_jurnal').val();
      var kelas_id = $('#kelas_id_jurnal').val();

      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_daftar_jurnal_by_mapel_kelas",
        data: {
          'mapel_id': mapel_id,
          'kelas_id': kelas_id
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          var html = 
          `
          <form method="post" action="${base_url}Jurnal_CRUD/add_jurnal">
            <input type="hidden" name="mapel_id" value="${mapel_id}">
            <input type="hidden" name="kelas_id" value="${kelas_id}">

            <button type="submit" class="btn btn-primary mt-4" style="font-size:15px; height:33px;">
              <div style="vertical-align:middle;">
                &plus; Jurnal
              </div>
            </button>
          </form>
          <table class="table table-sm table-bordered mt-3" style="font-size:14px;">
            <thead>
              <th style="width:40px;">Tanggal</th>
              <th>Outline</th>
              <th style="width:80px;">Action</th>
            </thead>
            <tbody>`;
          if (data.length == 0) {
            html += `<tr><td colspan="3" class="text-danger text-center"> <b>- Data Jurnal belum ada -</b> </td></tr>`;
            // html += '<button type="submit" class="btn btn-primary btn-user btn-block mt-3">';
            // html += 'Save';
            // html += '</button>';
          } else {
            var fields;
            for (var i = 0; i < data.length; i++) {
              tgl = data[i].jurnal_tgl.split('-');
              html += `
              <tr>
                <td>${tgl[2]}/${tgl[1]}</td>
                <td>${data[i].mapel_outline_nama}</td>
                <td>
                  <div class="box2">
                    <div>
                      <form action="${base_url}Jurnal_CRUD/edit_jurnal" method="post">
                        <input type="hidden" name="jurnal_id" value="${data[i].jurnal_id}" method="post">
                        <button type="submit" class="badge badge-warning">
                          Edit
                        </button>
                      </form>
                    </div>
                    <div>
                      <form action="${base_url}Jurnal_CRUD/add_absen" method="post">
                        <input type="hidden" name="jurnal_id" value="${data[i].jurnal_id}" method="post">
                        <button type="submit" class="badge badge-secondary">
                          Absent
                        </button>
                      </form>
                    </div>
                  </div>
                  
                  
                </td>
              </tr>`;
            }
            // var html = ``;
            // html += '<button type="submit" class="btn btn-primary btn-user btn-block mt-3">';
            // html += 'Update';
            // html += '</button>';
          }
          html += `</tbody></table>`;
          $('#daftar_jurnal_ajax').html(html);

        }
      });

    });
  }

});
</script>