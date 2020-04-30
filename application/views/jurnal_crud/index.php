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

    <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/input'); ?>">
      <label class="mt-2"><b>Tahun:</b></label>
      <select name="t_id" id="t_id_jurnal" class="form-control form-control-sm mb-2">
        <option value="0">Pilih Tahun</option>
        <?php foreach ($t_all as $t) : ?>
          <option value='<?=$t['t_id'] ?>'>
            <?= $t['t_nama'] ?>
          </option>
        <?php endforeach ?>
      </select>

      <label class="mt-2"><b>Bulan:</b></label>
      <select name="bulan_id" class="form-control form-control-sm mb-2">
        <?php foreach ($bulan as $b) : ?>
          <option value='<?=$b['bulan_id'] ?>'>
            <?= $b['bulan_nama'] ?>
          </option>
        <?php endforeach ?>
      </select>

      <div id="mapel_id_jurnal_ajax"></div>
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
    $('#mapel_id_jurnal_ajax').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_mapel_by_kr_real",
        data: {
          't_id': t_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 mt-3 text-danger"><b>--Anda tidak mengajar mapel pada tahun ini dikelas manapun--</b></div>';
          } else {
            var html = '<label><b>Mapel:</b></label><select name="mapel_id" id="mapel_id_jurnal" class="form-control form-control-sm mb-3">';

            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].mapel_id + '>' + data[i].mapel_nama + ' - ' +  data[i].sk_nama +'</option>';
            }
            html += '</select>';
            html += `<button type="submit" class="btn btn-primary btn-user btn-block mt-3">
              Proses
            </button>`;
          }

          $('#mapel_id_jurnal_ajax').html(html);

        }
      });
  });

});
</script>
