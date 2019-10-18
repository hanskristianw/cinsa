<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            
            <div class="text-center">
              <h1 class="h4 text-gray-900"><u>Pilih Mapel dan Jenjang</u></h1>
              <h5 class="mb-4">Persentase yang tidak diset akan menggunakan persentase <a class='link-def-persen' href='javascript:void(0)'>default</a></h5>
            </div>

            <?= $this->session->flashdata('message'); ?>
            
            <form method="post" action="<?= base_url('Percent_CRUD/save_persen'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="mapel_id" id="mapel_id_persen" class="form-control">
                    <option value="0">Pilih Mapel</option>
                    <?php foreach ($mapel_all as $m) : ?>
                      <option value='<?= $m['mapel_id'] ?>'>
                        <?= $m['mapel_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="jenj_id" id="jenj_id_persen" class="form-control">
                    <option value="0">Pilih Jenjang</option>
                    <?php foreach ($jenj_all as $m) : ?>
                      <option value='<?= $m['jenj_id'] ?>'>
                        <?= $m['jenj_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              
              <div id="detail_persen_ajax">
                
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

    $(".link-def-persen").on('click', function () {
      
      $("#judul_modal").html("Persentase Default");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      

      
      var html = '<h5 style="font-size:15px;">Formative Pengetahuan: 70%</h5>';
      html += '<h5 style="font-size:15px;">Formative Ketrampilan: 30%</h5><br>';
      html += '<h5 style="font-size:15px;">Summative Pengetahuan: 70%</h5>';
      html += '<h5 style="font-size:15px;">Formative Ketrampilan: 30%</h5><br>';
      
      html += '<h5 style="font-size:15px;">NA Pengetahuan: 50%</h5>';
      html += '<h5 style="font-size:15px;">NA Ketrampilan: 50%</h5>';
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $('#jenj_id_persen').change(function () {
      $('#mapel_id_persen').change();
    }).change();

    $('#mapel_id_persen').change(function () {

    var mapel_id = $(this).val();
    var jenj_id = $('#jenj_id_persen').val();

    $('#detail_persen_ajax').html("");

    if(mapel_id > 0 && jenj_id > 0){
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_percent_by_mapel_jenj",
        data: {
          'mapel_id': mapel_id,
          'jenj_id': jenj_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '';
            html += '<div class="alert alert-danger alert-dismissible fade show">';
            html += '<button class="close" data-dismiss="alert" type="button">';
            html += '<span>&times;</span>';
            html += '</button>';
            html += '<strong>INFO:</strong> Persentase belum diset, silahkan simpan persentase';
            html += '</div>';

            html += '<div class="form-group row">';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_forma_peng"><b><u>% Formative Pengetahuan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_forma_peng" value="70" required>';
            html += '</div>';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_summa_peng"><b><u>% Summative Pengetahuan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_summa_peng" value="30" required>';
            html += '</div>';
            html += '</div>';

            html += '<div class="form-group row">';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_forma_ket"><b><u>% Formative Ketrampilan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_forma_ket" value="70" required>';
            html += '</div>';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_summa_ket"><b><u>% Summative Ketrampilan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_summa_ket" value="30" required>';
            html += '</div>';
            html += '</div>';

            html += '<div class="form-group row">';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_peng_akhir"><b><u>% Pengetahuan Akhir</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_peng_akhir" value="50" required>';
            html += '</div>';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_ket_akhir"><b><u>% Ketrampilan Akhir</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_ket_akhir" value="50" required>';
            html += '</div>';
            html += '</div>';


            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Save';
            html += '</button>';
          } else {
            var html = '';
            html += '<div class="alert alert-success alert-dismissible fade show">';
            html += '<button class="close" data-dismiss="alert" type="button">';
            html += '<span>&times;</span>';
            html += '</button>';
            html += '<strong>INFO:</strong> Persentase sudah ada, tekan save untuk melakukan update';
            html += '</div>';

            html += '<div class="form-group row">';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_forma_peng"><b><u>% Formative Pengetahuan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_forma_peng" value="'+data[0].persen_forma_peng+'" required min=0 max=100>';
            html += '</div>';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_summa_peng"><b><u>% Summative Pengetahuan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_summa_peng" value="'+data[0].persen_summa_peng+'" required min=0 max=100>';
            html += '</div>';
            html += '</div>';

            html += '<div class="form-group row">';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_forma_ket"><b><u>% Formative Ketrampilan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_forma_ket" value="'+data[0].persen_forma_ket+'" required min=0 max=100>';
            html += '</div>';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_summa_ket"><b><u>% Summative Ketrampilan</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_summa_ket" value="'+data[0].persen_summa_ket+'" required min=0 max=100>';
            html += '</div>';
            html += '</div>';

            html += '<div class="form-group row">';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_peng_akhir"><b><u>% Pengetahuan Akhir</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_peng_akhir" value="'+data[0].persen_peng_akhir+'" required min=0 max=100>';
            html += '</div>';
            html += '<div class="col-sm mb-3 mb-sm-0">';
            html += '<label for="persen_ket_akhir"><b><u>% Ketrampilan Akhir</u>:</b></label>';
            html += '<input type="number" class="form-control" name="persen_ket_akhir" value="'+data[0].persen_ket_akhir+'" required min=0 max=100>';
            html += '</div>';
            html += '</div>';


            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Save';
            html += '</button>';
          }


          $('#detail_persen_ajax').html(html);

        }
      });
    }

    

  }).change();
 

  });
</script>