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
    <form action="<?= base_url('Jadwal_CRUD/jadwal_input'); ?>" method="post">
      <label><b>Unit:</b></label>
      <select name="sk_id" id="sk_id_jadwal" class="form-control form-control-sm mb-2">
        <option value="0">Pilih Unit</option>
        <?php foreach ($sk_all as $s) : ?>
          <option value='<?=$s['sk_id'] ?>'>
            <?= $s['sk_nama'] ?>
          </option>
        <?php endforeach ?>
      </select>


      <label><b>Tahun:</b></label>
      <select name="t_id" id="t_id_jadwal" class="form-control form-control-sm mb-2">
        <option value="0">Pilih Tahun</option>
        <?php foreach ($t_all as $t) : ?>
          <option value='<?=$t['t_id'] ?>'>
            <?= $t['t_nama'] ?>
          </option>
        <?php endforeach ?>
      </select>

      <div id="kelas_ajax_jadwal">

      </div>

    </form>
  </div>
</div>

<script>
  $(document).ready(function () {

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
    });

    $('.mapel_id').each(function () {
      $(this).change(function () {
        alert($(this).attr('id'));
      });
    });

    $('#t_id_jadwal').change(function () {
      $('#sk_id_jadwal').change();
    });

    $('#sk_id_jadwal').change(function () {
      var sk_id = $(this).val();
      var t_id = $('#t_id_jadwal').val();

      $('#kelas_ajax_jadwal').html("");

      if(sk_id>0 && t_id>0){
        $.ajax(
        {
          type: "post",
          url: base_url + "API/get_kelas_by_year_sk",
          data: {
            'sk_id': sk_id,
            't_id': t_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            var html = '';

            if (data.length != 0) {
              //sudah ada outline
              html += `<label><b>Kelas:</b></label><select class="form-control form-control-sm mb-2" name="kelas_id">`;
              for (var i = 0; i < data.length; i++) {
                html += `<option value="${data[i].kelas_id}">${data[i].kelas_nama}</option>`;
              }
              html += `</select>
                <button type="submit" class="btn btn-secondary btn-block">
                  Proses
                </button>
              `;

            } else {
              //belum ada outline
              html += '<div colspan="3" class="text-center text-danger mt-2"><b>--Kelas Belum Ada--</b></div>';
            }

            $('#kelas_ajax_jadwal').html(html);

          }
        });
      }else{
        $('#kelas_ajax_jadwal').html("");
      }

    }).change();


  });
</script>
