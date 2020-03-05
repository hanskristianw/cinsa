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
    <h5 class="text-center"><?= ucwords(strtolower($jurnal['kelas_nama'])) ?> - <?= ucwords(strtolower($jurnal['mapel_nama'])) ?></h5>
    
    <?= $this->session->flashdata('message'); ?>
  </div>
  <div class="box1">
  <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/save_update'); ?>">

    <input type="hidden" name="jurnal_kelas_id" id="jurnal_kelas_id" value="<?= $jurnal['kelas_id'] ?>">
    <input type="hidden" name="mapel_id" id="mapel_id" value="<?= $jurnal['mapel_id'] ?>">
    <input type="hidden" name="tgl_skrng" id="tgl_skrng" value="<?= $jurnal['jurnal_tgl'] ?>">
    <input type="hidden" name="jurnal_id" value="<?= $jurnal['jurnal_id'] ?>">

    <label for="jurnal_tgl"><b><u>Tanggal Jurnal</u>:</b></label>
    <input type="date" name="jurnal_tgl" id="jurnal_tgl" class="form-control form-control-sm mb-4" value="<?= $jurnal['jurnal_tgl'] ?>" required>

    <label for="jurnal_mapel_outline_id"><b><u>Outline</u>:</b></label>
    <select name="jurnal_mapel_outline_id" id="jurnal_mapel_outline_id" class="form-control form-control-sm">
      <!-- <option value="0">Pilih Outline</option> -->
      <?php
        foreach($outline_all as $m) :
          if($jurnal['jurnal_mapel_outline_id'] == $m['mapel_outline_id'])
            echo "<option value=".$m['mapel_outline_id']." selected>".$m['mapel_outline_nama']."</option>";
          else
            echo "<option value=".$m['mapel_outline_id'].">".$m['mapel_outline_nama']."</option>";
        endforeach
      ?>
    </select>

    <div id="outline_detail_ajax" class="mt-2">
      
    </div>
    
    <div id="btn_submit">
      <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
        Save
      </button>
    </div>
    
  </form>

  </div>
</div>

<script>

$(document).ready(function() {
  $('#jurnal_tgl').change(function () {
    var jurnal_tgl = $(this).val();
    var kelas_id = $('#jurnal_kelas_id').val();
    var mapel_id = $('#mapel_id').val();
    var tgl_skrng = $('#tgl_skrng').val();

    // alert(jurnal_tgl);
    // alert(kelas_id);
    // alert(mapel_id);

    if(jurnal_tgl){

      $.ajax(
      {
        type: "post",
        url: base_url + "API/cek_data_jurnal_skrng",
        data: {
          'kelas_id': kelas_id,
          'jurnal_tgl': jurnal_tgl,
          'mapel_id': mapel_id,
          'tgl_skrng': tgl_skrng
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '';
            $('#btn_submit').show();
          } else {
            var html = '<div class="alert alert-danger text-center">- Data Jurnal pada tanggal diatas sudah ada, dalam kelas yang sama, tanggal yang sama dan mapel yang sama tidak boleh ada lebih dari 1 jurnal -</div>';
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

});

</script>