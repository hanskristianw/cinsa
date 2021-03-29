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
    <div class="alert alert-danger alert-dismissible fade show">
        <button class="close" data-dismiss="alert" type="button">
            <span>&times;</span>
        </button>
        <strong>PERHATIAN:</strong><br><br>

        <ul>
          <li>TIDAK PERLU membuat topik baru jika topik sudah ada, topik <b>HANYA PERLU DIBUAT 1 KALI.</b></li>
          <li>DELETE topik hanya bisa dilakukan oleh wakakur.</li>
        </ul>

    </div>
    <?= $this->session->flashdata('message'); ?>

    <input type="hidden" id="topik_jabatan_id" value="<?= $jabatan_id ?>">

    <form method="post" action="topik_CRUD/add">
      <select name="topik_mapel" id="topik_mapel" class="form-control form-control-sm">
        <option value="0">Pilih Mapel</option>
        <?php
          foreach($mapel_all as $m) :
            echo "<option value=".$m['mapel_id'].">".$m['mapel_nama']." - ".$m['sk_nama']."</option>";
          endforeach
        ?>
      </select>
      <div id="sub_topik_crud">
        <button type="submit" class="btn btn-primary btn-user mt-4">
          Tambah topik
        </button>
      </div>
    </form>

    <div id="topik_mapel_ajax">

    </div>
    <hr>
  </div>

</div>


<script>
  $(document).ready(function () {
    $('#sub_topik_crud').hide();
    $('#topik_mapel').change(function () {
      var id = $(this).val();
      var topik_jabatan_id = $('#topik_jabatan_id').val();
      //alert(topik_jabatan_id);
      if (id == 0) {
        $('#topik_mapel_ajax').html("");
        $('#sub_topik_crud').hide();
      } else {
        $('#sub_topik_crud').show();
      }

      $.ajax(
        {
          type: "post",
          url: base_url + "Topik_CRUD/get_topik_detail",
          data: {
            'id': id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);

            var html = '<table class="table table-bordered table-sm mt-2" style="font-size:13px;">';
            html += '<thead class="thead-dark">';
            html += '<tr>';
            html += '<th style="width:70px;">Semester</th>';
            html += '<th>Nama Topik</th>';
            html += '<th style="width:70px;">Total Nilai</th>';
            html += '<th style="width:70px;">Urutan topik</th>';
            if (topik_jabatan_id == 4) {
              html += '<th colspan="2">Action</th>';
            }else{
              html += '<th>Action</th>';
            }
            html += '</tr>';
            html += '</thead>';

            html += '<tbody>';
            if (data.length != 0) {
              var jnama = "";
              for (var i = 0; i < data.length; i++) {
                if (topik_jabatan_id == 4) {
                  if(jnama != data[i].jenj_nama){
                    html += '<tr>';
                    html += '<td class="bg-info text-light text-center" colspan="6">' + data[i].jenj_nama + '</td>';
                    html += '</tr>';
                  }
                }else{
                  if(jnama != data[i].jenj_nama){
                    html += '<tr>';
                    html += '<td class="bg-info text-light text-center" colspan="5">' + data[i].jenj_nama + '</td>';
                    html += '</tr>';
                  }
                }

                html += '<tr>';
                html += '<td class="text-center">' + data[i].topik_semester + '</td>';
                html += '<td>' + data[i].topik_nama + '</td>';
                html += '<td>' + data[i].jum_tes + '</td>';
                html += '<td>' + data[i].topik_urutan + '</td>';
                html += '<td style="width:50px;">';
                html += '<form method="post" action="' + base_url + 'topik_CRUD/edit">';
                html += '<input type="hidden" value="' + data[i].jum_tes + '" name="jum_tes">';
                html += '<input type="hidden" value="' + data[i].topik_id + '" name="topik_id">';
                html += '<input type="hidden" value="' + data[i].topik_mapel_id + '" name="mapel_id">';
                html += '<button type="submit" class="badge badge-warning">';
                html += 'Edit';
                html += '</button>';

                html += '</form>';
                html += '</td>';

                if (topik_jabatan_id == 4) {
                  html += '<td style="width:50px;">';
                  html += '<form method="post" action="' + base_url + 'topik_CRUD/delete">';

                  html += '<input type="hidden" value="' + data[i].topik_id + '" name="topik_id">';
                  html += '<button type="submit" class="badge badge-danger">';
                  html += 'Delete';
                  html += '</button>';

                  html += '</form>';
                  html += '</td>';
                }
                html += '</tr>';

                jnama = data[i].jenj_nama;

              }
            } else {
              html += '<td colspan="6" class="text-center table-danger"><b>--Tidak ada topik, silahkan tambahkan topik--</b></td>';
            }
            html += '</tbody>';
            html += '</table>';


            //alert(html);

            $('#topik_mapel_ajax').html(html);

          }
        });
    });
  });
</script>
