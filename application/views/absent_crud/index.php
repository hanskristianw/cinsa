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
    <form class="user" method="post" action="<?= base_url('Absent_CRUD/save'); ?>">
      <label><b>Kelas:</b></label>
      <select name="kelas_id" id="kelas_absen" class="form-control form-control-sm mb-2">
        <?php foreach ($kelas_all as $k) : ?>
          <option value='<?=$k['kelas_id'] ?>'>
            <?= $k['kelas_nama'].' ('.$k['t_nama'].')' ?>
          </option>
        <?php endforeach ?>
      </select>
      <label><b>Tanggal:</b></label>
      <input type="date" name="tgl_absen" id="tgl_absen" class="form-control form-control-sm mb-4">

      <div id="absen_kelas_tidak_masuk"></div>

      <div id="absen_kelas"></div>
    </form>
  </div>
</div>

<script>

$(document).ready(function() {
  
  function status_siswa(st_id){
    if(st_id==1)
      return "Sakit";
    else if(st_id==2)
      return "Ijin";
    else if(st_id==3)
      return "Alpha";
  }


  $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
  });

  $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-danger").slideUp(500);
  });

  $('#tgl_absen').change(function () {
    $('#kelas_absen').change();
  });
  $('#kelas_absen').change(function () {
    var id = $(this).val();
    var tgl = $('#tgl_absen').val();

    $('#absen_kelas').html("");
    $('#absen_kelas_tidak_masuk').html("");

    if(tgl){
      //alert(id);
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_absen_siswa_tidak_masuk_by_kelas",
        data: {
          'kelas_id': id,
          'tgl': tgl
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '';
          } else {
            var html = `
            <h5 class="text-center text-danger"><b><u>Murid yang tidak masuk, ijin atau alpha</u></b></h5>
            <table class="table table-sm table-bordered table-striped" style="font-size: 10px;">
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>`;
            for (i = 0; i < data.length; i++) {
              html += `<tr>
                        <td style="width:35px;">${data[i].sis_no_induk}</td>
                        <td>${data[i].sis_nama_depan} ${data[i].sis_nama_bel}</td>
                        <td>${status_siswa(data[i].absen_siswa_status)}</td>
                        <td>${data[i].absen_siswa_ket}</td>
                        <td>`;

              html += '<form method="post" action="'+ base_url + "Absent_CRUD/delete_absent"+'">';
              html += '<input type="hidden" class="form-control-sm ml-2" name="absen_siswa_id" value="'+data[i].absen_siswa_id+'">';
              html += '<button type="submit" class="badge badge-danger ml-2">';
              html += '<i class="fa fa-times"></i> Delete';
              html += '</button>';
              html += '</form>';

              html +=`</td>
                      </tr>`;
            }
            html += `</tbody>
            </table>`;
          }
          $('#absen_kelas_tidak_masuk').html(html);

        }
      });

      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_absen_siswa_by_kelas",
        data: {
          'kelas_id': id,
          'tgl': tgl
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Student--</b></div>';
          } else {
            var html = `
            <h5 class="text-center text-success"><b><u>Murid yang MASUK</u></b></h5>
            <label style="font-size: 12px;"><b>M: Masuk</b>; <b>S: Sakit</b>; <b>I: Ijin</b>; <b>A: Alpha</b></label>
            <table class="table table-sm table-bordered table-striped" style="font-size: 10px;">
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>M</th>
                  <th>S</th>
                  <th>I</th>
                  <th>A</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>`;
            for (i = 0; i < data.length; i++) {
              html += `<tr>
                        <td style="width:35px;">
                          <input type="hidden" value="${data[i].d_s_id}" name="d_s_id[]">
                          ${data[i].sis_no_induk}
                        </td>
                        <td>${data[i].sis_nama_depan} ${data[i].sis_nama_bel}</td>
                        <td style="width:35px;"><input type="radio" class="form-control-sm" name="${data[i].d_s_id}" value="0" style="height:15px;" checked></td>
                        <td style="width:35px;"><input type="radio" class="form-control-sm" name="${data[i].d_s_id}" value="1" style="height:15px;"></td>
                        <td style="width:35px;"><input type="radio" class="form-control-sm" name="${data[i].d_s_id}" value="2" style="height:15px;"></td>
                        <td style="width:35px;"><input type="radio" class="form-control-sm" name="${data[i].d_s_id}" value="3" style="height:15px;"></td>
                        <td><input type="text" name="absen_siswa_ket[]" class="form-control form-control-sm" style="font-size: 12px; height:20px;"></td>
                      </tr>`;
            }
            html += `</tbody>
            </table>`;
            html += `<button type="submit" class="btn btn-primary btn-user btn-block">
                  Save
                </button>`;
            //console.log(html);
          }
          $('#absen_kelas').html(html);

          //refreshEventKelas();
        }
      });
    }

  });

});
</script>