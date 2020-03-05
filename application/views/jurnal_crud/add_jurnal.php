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
    <h4 class="h4 text-gray-900 mt-3 text-center"><u><?= $title ?></u></h4>
    <h5 class="text-center"><?= ucwords(strtolower($kelas_nama['kelas_nama'])) ?> - <?= ucwords(strtolower($mapel_nama['mapel_nama'])) ?></h5>
    
    <?= $this->session->flashdata('message'); ?>
  </div>
  <div class="box1">
  <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/save_jurnal'); ?>">
    <input type="hidden" name="jurnal_kelas_id" id="jurnal_kelas_id" value="<?= $kelas_id ?>">
    <input type="hidden" name="mapel_id" id="mapel_id" value="<?= $mapel_nama['mapel_id'] ?>">

    <label for="jurnal_tgl"><b><u>Tanggal Jurnal</u>:</b></label>
    <input type="date" name="jurnal_tgl" id="jurnal_tgl" class="form-control form-control-sm mb-4" required>

    <div id="outline_detail_ajax">
      
    </div>
    
    <div id="btn_submit" style="display:none;">
      <?php if($outline_all): ?>
        <label for="jurnal_mapel_outline_id"><b><u>Outline</u>:</b></label>
        <select name="jurnal_mapel_outline_id" id="jurnal_mapel_outline_id" class="form-control form-control-sm">
          <!-- <option value="0">Pilih Outline</option> -->
          <?php
            foreach($outline_all as $m) :
              echo "<option value=".$m['mapel_outline_id'].">".$m['mapel_outline_nama']."</option>";
            endforeach
          ?>
        </select>
        <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
          Save
        </button>
      
      <?php else: ?>
        <div class="text-center bg-danger text-white p-2">- Outline Belum ada, tambahkan outline terlebih dahulu -</div>
      <?php endif; ?>
    </div>
    
    
    <div id="loadingDiv" style="display:none;">
      <img src="<?= base_url('assets/img/loading.gif'); ?>" alt="loading">
    </div>
    
    <!-- <div id="jurnal_absen_tidak_masuk_ajax"></div>

    <div id="jurnal_absen_ajax"></div> -->

    <!--  -->
  </form>

  </div>
</div>


<script>
$(document).ready(function() {

  $('#loadingDiv')
  .hide()  // Hide it initially
  .ajaxStart(function() {
    $(this).show();
  })
  .ajaxStop(function() {
    $(this).hide();
  });

  $('#jurnal_tgl').change(function () {
    var jurnal_tgl = $(this).val();
    var kelas_id = $('#jurnal_kelas_id').val();
    var mapel_id = $('#mapel_id').val();

    // alert(jurnal_tgl);
    // alert(kelas_id);
    // alert(mapel_id);

    if(jurnal_tgl){

      $.ajax(
      {
        type: "post",
        url: base_url + "API/cek_data_jurnal",
        data: {
          'kelas_id': kelas_id,
          'jurnal_tgl': jurnal_tgl,
          'mapel_id': mapel_id
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '';
            $('#btn_submit').show();
          } else {
            var html = '<div class="alert alert-danger text-center">- Data Jurnal pada tanggal diatas sudah ada, silahkan lakukan edit jika ingin merubah -</div>';
            $('#btn_submit').hide();
          }
          $('#outline_detail_ajax').html(html);
        }
      });
    }
    else{
      $('#btn_submit').hide();
    }
  });

  // $('#jurnal_tgl').change(function () {
  
  //   var jurnal_tgl = $(this).val();
  //   var kelas_id = $('#jurnal_kelas_id').val();
  //   var jurnal_mapel_outline_id = $('#jurnal_mapel_outline_id').val();
    

  //   $('#jurnal_absen_ajax').html("");
    
  //   if(jurnal_tgl){
      

  //     $.ajax(
  //     {
  //       type: "post",
  //       url: base_url + "API/get_absen_by_outline_tgl",
  //       data: {
  //         'kelas_id': kelas_id,
  //         'jurnal_tgl': jurnal_tgl,
  //         'jurnal_mapel_outline_id': jurnal_mapel_outline_id
  //       },
  //       async: true,
  //       dataType: 'json',
  //       success: function (data) {
  //         console.log(data);
  //         if (data.length == 0) {
  //           var html = '';
  //         } else {
  //           if(data[0].total > 0){
  //             var html = `Data Sudah Ada`;
  //           }else{
              
  //             $('#outline_ajax').show();

  //             var html = `
  //             <h5 class="text-center text-danger mt-3"><b><u>Absensi Kehadiran Siswa Pada Saat Pelajaran</u></b></h5>
  //             <div class="alert alert-warning" role="alert" style="font-size:14px;">
  //               Jika siswa tidak hadir, dalam melakukan absensi pastikan siswa memang tidak ada pada kelas, ketidakhadiran dalam kelas ketika pelajaran akan langsung <b>disampaikan ke orang tua melalui aplikasi</b>!
  //             </div>
  //             <table class="table table-sm table-bordered table-striped" style="font-size: 10px;">
  //               <thead>
  //                 <tr>
  //                   <th>NIS</th>
  //                   <th>Nama</th>
  //                   <th>Hadir</th>
  //                   <th>Tidak</th>
  //                   <th>Keterangan</th>
  //                 </tr>
  //               </thead>
  //               <tbody>`;
  //             for (i = 0; i < data.length; i++) {
  //               html += `<tr>
  //                         <td style="width:35px;">${data[i].sis_no_induk}</td>
  //                         <input type="hidden" value="${data[i].d_s_id}" name="d_s_id[]">
  //                         <td>${data[i].sis_nama_depan} ${data[i].sis_nama_bel}</td>
  //                         <td style="width:35px;">
  //                           <input type="radio" class="form-control-sm" name="${data[i].d_s_id}" value="0" style="height:15px;" checked>
  //                         </td>
  //                         <td style="width:35px;">
  //                           <input type="radio" class="form-control-sm" name="${data[i].d_s_id}" value="1" style="height:15px;">
  //                         </td>
  //                         <td>
  //                           <input type="text" name="absen_j_ket[]" class="form-control form-control-sm" style="font-size: 12px; height:20px;">
  //                         </td>`;
  //               html +=`</tr>`;
  //             }
              
  //             html += `</tbody>
  //             </table>`;
  //             html += '<button type="submit" class="btn btn-primary">';
  //             html += '<i class="fa fa-save"></i> Simpan';
  //             html += '</button>';
  //           }
            
  //         }
  //         $('#jurnal_absen_ajax').html(html);

  //       }
  //     });
  //   }
  //   else{
  //     $('#outline_ajax').hide();
  //   }

  // });
});
</script>