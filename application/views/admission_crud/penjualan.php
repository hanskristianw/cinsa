<style>
.grid-container {
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 80px;
  padding-left: 10px;
  padding-right: 30px;
  padding-top: 50px;
}


.box1{
  /*align-self:start;*/
  grid-column:1/3;
}

.grid-50 {
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:10px;
}

</style>


<div class="grid-container">

  <div class="box1 mb-3">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <div class="grid-50">
      <div>
        <label for="sk_id" class="ml-1" style="font-size:14px;"><b><u>Unit:</u></b></label>
        <select name="sk_id" id="sk_buku_id" class="form-control form-control-sm mb-2">
          <option value="0">Pilih Unit</option>
          <?php foreach ($sk_all as $k) : ?>
            <option value='<?=$k['sk_id'] ?>'>
              <?= $k['sk_nama'] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
      
      <div class="pr-2">
        <label for="t_id" class="ml-1" style="font-size:14px;"><b><u>Tahun Ajaran:</u></b></label>
        <select name="t_id" id="t_buku_id" class="form-control form-control-sm mb-2">
          <?php foreach ($t_all as $t) : ?>
            <option value='<?=$t['t_id'] ?>'>
              <?= $t['t_nama'] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <div id="jenj_ajax"></div>
  </div>
    
  <form action="<?= base_url('Admission_CRUD/add_buku_to_penjualan') ?>" method="post">
    <div style="display:none;" id="all_buku">
      <div id="buku_all_ajax"></div>
    </div>
  </form>

  <div style="display:none;" id="jual_buku">
    <div id="buku_terjual_ajax"></div>
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

  

  $('#t_buku_id').change(function () {
    $('#sk_buku_id').change();
  });

  $('#sk_buku_id').change(function () {

    $('#jenj_ajax').html("");
    $('#buku_all_ajax').html("");
    $('#buku_terjual_ajax').html("");
    
    $('#all_buku').hide();
    $('#jual_buku').hide();
    var sk_id = $(this).val();

    if(sk_id > 0){

      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_jenj_by_sk",
        data: {
          'sk_id': sk_id
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center text-light">Jenjang Belum Tersedia</div>';
          } else {
            var html = `<label class="ml-1" style="font-size:14px;"><b><u>Jenjang:</u></b></label>
            <select name="jenj_id" id="jenj_buku_id" class="form-control form-control-sm mb-2">`;
            html += '<option>Pilih Jenjang</option>';
            for (i = 0; i < data.length; i++) {
              html += `<option value="${data[i].jenj_id}">${data[i].jenj_nama}</option>`;
            }
            html += `</select>`;
          }
          $('#jenj_ajax').html(html);
          refreshJenjBuku();
        }
      });
    }

  });

  function refreshJenjBuku(){
    $('#jenj_buku_id').change(function () {

      $('#buku_all_ajax').html("");
      $('#buku_terjual_ajax').html("");
      
      var jenj_id = $(this).val();
      var sk_id = $('#sk_buku_id').val();
      var t_id = $('#t_buku_id').val();

      //alert(jenj_id);
      if(jenj_id>0){
        $.ajax(
        {
          type: "post",
          url: base_url + "API/get_buku_by_jenj_sk_t",
          data: {
            'sk_id': sk_id,
            'jenj_id': jenj_id,
            't_id': t_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center text-light">Belum Tersedia</div>';
            } else {
              var html = `<label class="mt-3 ml-1" style="font-size:15px;"><b>Buku Tersedia:</b></label>
                          <table class="table table-sm table-hover table-bordered" style="font-size:12px;">
                          <thead>
                            <tr>
                              <th>Nama Buku</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>`;
                for (i = 0; i < data.length; i++) {
                  html += `<tr>
                            <td>${data[i].buku_nama}</td>  
                            <input type="hidden" name="jenj_id" value="${jenj_id}">
                            <input type="hidden" name="t_id" value="${t_id}">
                            <td style="width:50px;"><input type="checkbox" name="buku_id[]" value="${data[i].buku_id}"></td>
                          </tr>`;
                }
                  html += `</tbody>
                          </table>
                          <button type="submit" class="btn btn-primary btn-sm btn-block mt-3" style="cursor: pointer;">
                            Tambah
                          </button>`;
              $('#buku_all_ajax').html(html);
              
             

              // alert(sk_id);
              // alert(jenj_id);
              $('#all_buku').show(500);
            }
          }
        });

        $.ajax(
        {
          type: "post",
          url: base_url + "API/get_buku_terjual_by_jenj_sk_t",
          data: {
            'sk_id': sk_id,
            'jenj_id': jenj_id,
            't_id': t_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center text-light">Belum Tersedia</div>';
            } else {
              var html = `<label class="mt-3 ml-1" style="font-size:15px;"><b>Daftar Jual:</b></label>
              <table class="table table-sm table-hover table-bordered" style="font-size:12px;">
                          <thead>
                            <tr>
                              <th>Nama Buku</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>`;
                for (i = 0; i < data.length; i++) {
                  html += `<tr>
                            <td>${data[i].buku_nama}</td>  
                            <td style="width:50px;">
                              <form method="post" action="${base_url}Admission_CRUD/delete_buku">
                                <input type="hidden" name="buku_jual_id" value="${data[i].buku_jual_id}">
                                <button type="submit" class="badge badge-danger" style="cursor: pointer;">
                                  Hapus
                                </button>
                              </form>
                            </td>
                          </tr>`;
                }
                  html += `</tbody>
                          </table>`;
              $('#buku_terjual_ajax').html(html);
              
              $('#jual_buku').show(500);
              // alert(sk_id);
              // alert(jenj_id);
            }
          }
        });


        //refreshBukuTerjual();
      }

    });
    
  }

});
</script>