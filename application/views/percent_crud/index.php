<style>
  .wrapper{
    display:grid;
    grid-template-columns:1fr 1fr 1fr 1fr;
    grid-auto-rows:minmax(50px, auto);
    /* grid-gap:1em; */
    justify-items:stretch;
    align-items:stretch;
    padding:1em;
  }

  .top{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:2em;
  }

  .announce{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:1em;
  }

  .left{
    /*justify-self:end;*/
    grid-column:1/3;
    padding:1em;
    /* grid-row:3; */
    /* border:1px solid #333; */
  }

  .right{
    grid-column:3/5;
    padding:1em;
    /* grid-row:2/4; */
    /* border:1px solid #333; */
  }

</style>


<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <form method="post" action="<?= base_url('Percent_CRUD/save_persen'); ?>">
      <div class="wrapper">
        <div class="top">
          <h1 class="h4 text-gray-900"><u>Pilih Mapel dan Jenjang</u></h1>
          <h5>Persentase yang tidak diset akan menggunakan persentase <a class='link-def-persen' href='javascript:void(0)'>default</a></h5>
          <h6><b><i>Perlu diperhatikan merubah persentase mapel akan merubah semua perhitungan mapel di tahun yang sama, misal jika merubah persentase di semester 2 tahun 19/20, maka perhitungan pada semester 1 tahun 19/20 juga akan ikut berubah, pastikan tidak merubah persentase jika masih dalam tahun yang sama</i></b></h6>
        </div>
        
        <?= $this->session->flashdata('message'); ?>
        
        <div class="left">
          <select name="mapel_id" id="mapel_id_persen" class="form-control form-control-sm">
            <option value="0">Pilih Mapel</option>
            <?php foreach ($mapel_all as $m) : ?>
              <option value='<?= $m['mapel_id'] ?>'>
                <?= $m['mapel_nama'] ?>
              </option>
            <?php endforeach ?>
          </select>
          
          <select name="t_id" id="t_id_persen" class="form-control form-control-sm mt-2">
            <?php foreach ($t_all as $m) : ?>
              <option value='<?= $m['t_id'] ?>'>
                <?= $m['t_nama']; ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
        
        <div class="right">
          <select name="jenj_id" id="jenj_id_persen" class="form-control form-control-sm">
            <option value="0">Pilih Jenjang</option>
            <?php foreach ($jenj_all as $m) : ?>
              <option value='<?= $m['jenj_id'] ?>'>
                <?= $m['jenj_nama']; ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>

      </div>
      <div class="wrapper" id="detail_persen_ajax">
          
      </div>
    </form>
    
  </div>

</div>


<script>
  $(document).ready(function () {

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
    });

    function sync_persen(){

      //PENGETAHUAN
      $(".persen_forma_peng").change(function () {
        
        var persen_forma_peng = parseInt($(this).val());
        var persen_summa_peng = 0;

        if(persen_forma_peng<100)
          persen_summa_peng = 100 - parseInt(persen_forma_peng);
        else
          $(this).val(100);

        $(".persen_summa_peng").val(persen_summa_peng);
      });

      $(".persen_summa_peng").change(function () {
        var persen_summa_peng = parseInt($(this).val());
        var persen_forma_peng = 0;

        if(persen_summa_peng<100)
          persen_forma_peng = 100 - parseInt(persen_summa_peng);
        else
          $(this).val(100);

        $(".persen_forma_peng").val(persen_forma_peng);
      });

      //KETRAMPILAN
      $(".persen_forma_ket").change(function () {
        
        var persen_forma_ket = parseInt($(this).val());
        var persen_summa_ket = 0;

        if(persen_forma_ket<100)
          persen_summa_ket = 100 - parseInt(persen_forma_ket);
        else
          $(this).val(100);

        $(".persen_summa_ket").val(persen_summa_ket);
      });

      $(".persen_summa_ket").change(function () {
        var persen_summa_ket = parseInt($(this).val());
        var persen_forma_ket = 0;

        if(persen_summa_ket<100)
          persen_forma_ket = 100 - parseInt(persen_summa_ket);
        else
          $(this).val(100);

        $(".persen_forma_ket").val(persen_forma_ket);
      });

      //AKHIR
      $(".persen_peng_akhir").change(function () {
        
        var persen_peng_akhir = parseInt($(this).val());
        var persen_ket_akhir = 0;

        if(persen_peng_akhir<100)
          persen_ket_akhir = 100 - parseInt(persen_peng_akhir);
        else
          $(this).val(100);

        $(".persen_ket_akhir").val(persen_ket_akhir);
      });

      $(".persen_ket_akhir").change(function () {
        var persen_ket_akhir = parseInt($(this).val());
        var persen_peng_akhir = 0;

        if(persen_ket_akhir<100)
          persen_peng_akhir = 100 - parseInt(persen_ket_akhir);
        else
          $(this).val(100);

        $(".persen_peng_akhir").val(persen_peng_akhir);
      });

    }

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

    $('#t_id_persen').change(function () {
      $('#mapel_id_persen').change();
    }).change();

    $('#mapel_id_persen').change(function () {

    var mapel_id = $(this).val();
    var jenj_id = $('#jenj_id_persen').val();
    var t_id = $('#t_id_persen').val();

    $('#detail_persen_ajax').html("");

    if(mapel_id > 0 && jenj_id > 0){
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_percent_by_mapel_jenj",
        data: {
          'mapel_id': mapel_id,
          'jenj_id': jenj_id,
          't_id': t_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '';
            html += '<div class="alert alert-danger alert-dismissible announce fade show m-3">';
            html += '<button class="close" data-dismiss="alert" type="button">';
            html += '<span>&times;</span>';
            html += '</button>';
            html += '<strong>INFO:</strong> Persentase belum diset, silahkan simpan persentase';
            html += '</div>';

            html += `<div class="left">
                    <label for="persen_forma_peng"><b><u>% Formative Pengetahuan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_forma_peng" name="persen_forma_peng" value="70" required>
                    </div>
                    `;
            html += `<div class="right">
                    <label for="persen_summa_peng"><b><u>% Summative Pengetahuan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_summa_peng" name="persen_summa_peng" value="30" required>
                    </div>
                    `;

            html += `<div class="left">
                    <label for="persen_forma_ket"><b><u>% Formative Ketrampilan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_forma_ket" name="persen_forma_ket" value="70" required>
                    </div>
                    `;
            html += `<div class="right">
                    <label for="persen_summa_ket"><b><u>% Summative Ketrampilan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_summa_ket" name="persen_summa_ket" value="30" required>
                    </div>
                    `;

            html += `<div class="left">
                    <label for="persen_peng_akhir"><b><u>% Pengetahuan Akhir</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_peng_akhir" name="persen_peng_akhir" value="50" required>
                    </div>
                    `;
            html += `<div class="right">
                    <label for="persen_ket_akhir"><b><u>% Ketrampilan Akhir</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_ket_akhir" name="persen_ket_akhir" value="50" required>
                    </div>
                    `;

            html += '<button type="submit" class="btn btn-sm btn-primary btn-user announce m-3">';
            html += 'Save';
            html += '</button>';
          } else {
            var html = '';
            html += '<div class="alert alert-success alert-dismissible fade show announce m-3">';
            html += '<button class="close" data-dismiss="alert" type="button">';
            html += '<span>&times;</span>';
            html += '</button>';
            html += '<strong>INFO:</strong> Persentase sudah ada, tekan save untuk melakukan update';
            html += '</div>';

            html += `<div class="left">
                    <label for="persen_forma_peng"><b><u>% Formative Pengetahuan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_forma_peng" name="persen_forma_peng" value="${data[0].persen_forma_peng}" required min=0 max=100>
                    </div>
                    `;
            html += `<div class="right">
                    <label for="persen_summa_peng"><b><u>% Summative Pengetahuan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_summa_peng" name="persen_summa_peng" value="${data[0].persen_summa_peng}" required min=0 max=100>
                    </div>
                    `;

            html += `<div class="left">
                    <label for="persen_forma_ket"><b><u>% Formative Ketrampilan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_forma_ket" name="persen_forma_ket" value="${data[0].persen_forma_ket}" required min=0 max=100>
                    </div>
                    `;
            html += `<div class="right">
                    <label for="persen_summa_ket"><b><u>% Summative Ketrampilan</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_summa_ket" name="persen_summa_ket" value="${data[0].persen_summa_ket}" required min=0 max=100>
                    </div>
                    `;

            html += `<div class="left">
                    <label for="persen_peng_akhir"><b><u>% Pengetahuan Akhir</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_peng_akhir" name="persen_peng_akhir" value="${data[0].persen_peng_akhir}" required min=0 max=100>
                    </div>
                    `;
            html += `<div class="right">
                    <label for="persen_ket_akhir"><b><u>% Ketrampilan Akhir</u>:</b></label>
                    <input type="number" class="form-control form-control-sm persen_ket_akhir" name="persen_ket_akhir" value="${data[0].persen_ket_akhir}" required min=0 max=100>
                    </div>
                    `;


            html += '<button type="submit" class="btn btn-primary btn-sm btn-user announce m-3">';
            html += 'Update';
            html += '</button>';
          }


          $('#detail_persen_ajax').html(html);
          sync_persen();

        }
      });
    }


  }).change();
 

  });
</script>