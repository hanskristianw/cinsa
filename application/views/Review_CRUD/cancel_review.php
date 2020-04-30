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
    <h5 class="text-center"><b><u>Pembatalan Review</u></b></h5>
    <h6 class="text-center"><b><u><?= $title ?></u></b></h6>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <form class="user" method="post" action="<?= base_url('Review_CRUD/cancel_review_list'); ?>">
      <label><b>Kelas:</b></label>
      <select name="kelas_id" id="kelas_id_cancel_review" class="form-control form-control-sm mb-2">
          <option value='0'>Pilih Kelas</option>
        <?php foreach ($kelas_all as $k) : ?>
          <option value='<?=$k['kelas_id'] ?>'>
            <?= $k['kelas_nama'].' ('.$k['t_nama'].')' ?>
          </option>
        <?php endforeach ?>
      </select>

      <div id="mapel_id_cancel_review"></div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {

    $('#kelas_id_cancel_review').change(function () {
      var kelas_id = $(this).val();

      if(kelas_id > 0){

        //alert(kelas_id);
        $.ajax(
        {
          type: "post",
          url: base_url + "API/get_mapel_jurnal_terisi",
          data: {
            'kelas_id': kelas_id
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            if(data.length > 0){
              var html = "";
              html += `<label><b>Mapel:</b></label><select class="form-control form-control-sm" name="mapel_id">`;
                for (var i = 0; i < data.length; i++) {
                  html += `<option value="${data[i].mapel_id}">${data[i].mapel_nama}</option>`;
                }
              html += `</select><button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
                Proses
              </button>`;
              $('#mapel_id_cancel_review').html(html);
            }
            else{
              var html = "<div class='text-center text-danger'><b>- Belum ada jurnal yang selesai direview -</b></div>";
              $('#mapel_id_cancel_review').html(html);
            }


          }
        });
      }
      else{
        $('#mapel_id_cancel_review').html("");
      }


    });

  });
</script>
