<style>
.grid-container {
  display: grid;
  grid-template-columns: 15% 15% 15% 25% 15% 15%;
  grid-column-gap:4px;
  padding-right:3px;
}
.grid-container > div{
  text-align:left;
}

.grid-main {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 20px;
  padding-top: 20px;
}

.box1{
  /*align-self:start;*/
  grid-column:2/3;
  overflow: auto;
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:3px;
}

</style>

<div class="grid-main">

  <div class="box1 mb-4">

      <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4 mt-4"><u><?= $title ?></u></h1>
      </div>
      <?php echo '<div class="alert alert-danger alert-dismissible fade show" style="font-size:14px;">
              <button class="close" data-dismiss="alert" type="button">
                  <span>&times;</span>
              </button>
              <strong><u>PERHATIAN:</u></strong> <br><br>
              <ul>
                <li><b>TIDAK PERLU</b> membuat outline baru jika outline sudah ada</li>
                <li>Outline adalah detail pelajaran tiap minggunya dan digunakan untuk mengisi jurnal</li>
                <li>Outline tidak sama dengan Topik</li>
              </ul>
          </div>'; ?>
      <?= $this->session->flashdata('message'); ?>

      <form method="post" action="<?= base_url('Topik_CRUD/add_outline'); ?>">
        <select name="mapel_id" id="mapel_id_outline" class="form-control form-control-sm">
          <option value="0">Pilih Mapel</option>
          <?php
            foreach($mapel_all as $m) :
              echo "<option value=".$m['mapel_id'].">".$m['mapel_nama']." - ".$m['sk_nama']."</option>";
            endforeach
          ?>
        </select>
        <div id="sub_topik_crud" style="display:none;">
          <button type="submit" class="btn btn-primary btn-user mt-4" style="height:30px;font-size:13px;">
            &plus; Outline
          </button>
        </div>
      </form>

      <div id="outline_mapel_ajax">

      </div>
      <hr>
  </div>

</div>


<script>
  $(document).ready(function () {

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
    });

    $('#mapel_id_outline').change(function () {
      var mapel_id = $(this).val();

      if(mapel_id>0){

        $('#sub_topik_crud').show();
        $.ajax(
        {
          type: "post",
          url: base_url + "API/get_outline_detail",
          data: {
            'mapel_id': mapel_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            var html = '<table class="table table-bordered table-sm mt-2" style="font-size:14px;">';
            html += '<thead class="thead-dark">';
            html += '<tr>';
            html += '<th>Deskripsi Outline</th>';
            html += '<th>Jenjang</th>';
            html += '<th>Action</th>';
            html += '</tr>';
            html += '</thead>';

            html += '<tbody>';
            if (data.length != 0) {
              //sudah ada outline
              for (var i = 0; i < data.length; i++) {
                html += `<tr>
                          <td>${data[i].mapel_outline_nama}</td>
                          <td style="width:60px;">${data[i].jenj_nama}</td>
                          <td style="width:60px;">
                            <form method="post" action="${base_url}Topik_CRUD/edit_outline">
                              <input type="hidden" value="${data[i].mapel_outline_id}" name="mapel_outline_id">
                              <button type="submit" class="badge badge-warning">Edit</button>
                            </form>
                          </td>
                        </tr>`;
              }
            } else {
              //belum ada outline
              html += '<td colspan="3" class="text-center text-danger"><b>--Outline Belum Ada--</b></td>';
            }
            html += '</tbody>';
            html += '</table>';


            //alert(html);

            $('#outline_mapel_ajax').html(html);

          }
        });
      }else{

        $('#sub_topik_crud').hide();
        $('#outline_mapel_ajax').html("");
      }

    });
  });
</script>
