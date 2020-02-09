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
    <div id="laporan_jurnal_ajax"></div>
  
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
    // $('#mapel_tes_ajax').html("");
    // $('#topik_tes_ajax').html("");
    if(t_id>0){
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
    }
  });

  function refreshMapelJurnal() {
    $('#kelas_id_jurnal').change(function () {
      var kelas_id = $(this).val();
      //alert(flag);
      $('#mapel_id_jurnal_ajax').html("");
      $('#laporan_jurnal_ajax').html("");
      
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

            }

            $('#mapel_id_jurnal_ajax').html(html);
            refreshLapJurnal();
          }
        });
    });
  }

  
  function refreshLapJurnal() {
    $('#mapel_id_jurnal').change(function () {
      var mapel_id = $(this).val();
      var kelas_id = $('#kelas_id_jurnal').val();
      //alert(flag);
      $('#laporan_jurnal_ajax').html("");
      
      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_laporan_by_kelas_mapel",
          data: {
            'kelas_id': kelas_id,
            'mapel_id': mapel_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
            } else {
              var html = `
              <table class="table table-sm table-bordered table-striped" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Isi</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>`;

                
              var i;
              for (i = 0; i < data.length; i++) {
                html += '<tr>';
                html += '<td style="width:10%;">'+ data[i].jurnal_tgl + '</td>';
                html += '<td>'+ data[i].jurnal_isi + '</td>';

                html += `<td style="width:5%;">`;

                html += '<form method="post" action="'+ base_url + "Jurnal_CRUD/delete_absent"+'">';
                html += '<input type="hidden" class="form-control-sm ml-2" name="jurnal_id" value="'+data[i].jurnal_id+'">';
                html += `<button type="submit" class="badge badge-danger ml-2"><i class="fa fa-times"></i> Delete</button>`;
                html += '</form>';

                html += `</td>`;

                html += '</tr>';
              }
              
              html += `</tbody>
              </table>`;

            }

            $('#laporan_jurnal_ajax').html(html);
          }
        });
    });
  }

});
</script>