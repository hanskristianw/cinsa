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
  grid-template-columns: 50% 50%;
}
</style>


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/save'); ?>">
      <label><b>Tahun:</b></label>
      <select name="t_id" id="t_id_jurnal" class="form-control form-control-sm mb-2">
        <option value="0">Select Year</option>
        <?php foreach ($t_all as $t) : ?>
          <option value='<?=$t['t_id'] ?>'>
            <?= $t['t_nama'] ?>
          </option>
        <?php endforeach ?>
      </select>

      <div id="kelas_id_jurnal_ajax"></div>
      <div id="mapel_id_jurnal_ajax"></div>
      <div id="tgl_jurnal_ajax"></div>
      <div id="isi_jurnal_ajax"></div>

    </form>
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
    $('#isi_jurnal_ajax').html("");
    $('#tgl_jurnal_ajax').html("");
    $('#mapel_id_jurnal_ajax').html("");
    // $('#mapel_tes_ajax').html("");
    // $('#topik_tes_ajax').html("");

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
            html += '<option value=0>Select Class</option>';
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama +  '</option>';
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
      $('#isi_jurnal_ajax').html("");
      $('#tgl_jurnal_ajax').html("");
      $('#mapel_id_jurnal_ajax').html("");
      
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
              var html = '<label><b>Subject:</b></label><select name="mapel_id" id="mapel_id_jurnal" class="form-control form-control-sm mb-3">';

              html += '<option value=0>Select Subject</option>';
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
            refreshTglJurnal();
          }
        });
    });
  }

  function refreshTglJurnal() {
    $('#mapel_id_jurnal').change(function () {
      var kelas_id = $(this).val();
      
      var html ="";
      if(kelas_id > 0){
        html+= `<label><b>Tanggal:</b></label><input type="date" name="tgl_jurnal" id="tgl_jurnal" class="form-control form-control-sm mb-4">`;
        $('#tgl_jurnal_ajax').html(html);
        refreshIsiJurnal();
      }else{
        $('#isi_jurnal_ajax').html("");
        $('#tgl_jurnal_ajax').html("");
      }

    });
  }
  
  function refreshIsiJurnal() {
    $('#tgl_jurnal').change(function () {
      
      $('#isi_jurnal_ajax').html("");
      var tgl = $(this).val();
      var mapel_id = $('#mapel_id_jurnal').val();
      var kelas_id = $('#kelas_id_jurnal').val();

      if(tgl){
        //alert(id);
        $.ajax(
        {
          type: "post",
          url: base_url + "API/get_jurnal_by_mapel_tgl",
          data: {
            'mapel_id': mapel_id,
            'tgl': tgl,
            'kelas_id': kelas_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = `<label><b>Isi Jurnal:</b></label><textarea name="jurnal_isi" rows="6" class="form-control" required></textarea>`;
              html += '<button type="submit" class="btn btn-primary btn-user btn-block mt-3">';
              html += 'Save';
              html += '</button>';
            } else {
              var html = `<label><b>Isi Jurnal:</b></label><textarea name="jurnal_isi" rows="6" class="form-control" required>${data[0].jurnal_isi}</textarea>
              <input type="hidden" name="jurnal_id" value="${data[0].jurnal_id}">`;
              html += '<button type="submit" class="btn btn-primary btn-user btn-block mt-3">';
              html += 'Update';
              html += '</button>';
              
            }
            $('#isi_jurnal_ajax').html(html);

          }
        });

      }
    });
  }

});
</script>