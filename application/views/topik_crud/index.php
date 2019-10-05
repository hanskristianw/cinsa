<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select Subject</h1>
            </div>
            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>PERHATIAN:</strong> <br><br>
                    1. TIDAK perlu membuat topik baru jika topik sudah ada, topik <b>HANYA PERLU DIBUAT 1 KALI</b> <br>
                    2. DELETE topik hanya bisa dilakukan oleh wakakur.
                </div>'; ?>
            <?= $this->session->flashdata('message'); ?>
            
            <input type="hidden" id="topik_jabatan_id" value="<?= $jabatan_id ?>">
            
            <form method="post" action="topik_CRUD/add">
              <select name="topik_mapel" id="topik_mapel" class="form-control">
                <option value="0">SELECT SUBJECT</option>
                <?php
                  foreach($mapel_all as $m) :
                    echo "<option value=".$m['mapel_id'].">".$m['mapel_nama']." - ".$m['sk_nama']."</option>";
                  endforeach
                ?>
              </select>
              <div id="sub_topik_crud">
                <button type="submit" class="btn btn-primary btn-user mt-4">
                  Add Topic
                </button>
              </div>
            </form>

            <div id="topik_mapel_ajax">
            
            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
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

            var html = '<table class="table table-bordered table-sm mt-2">';
            html += '<thead class="thead-dark">';
            html += '<tr>';
            html += '<th>Semester</th>';
            html += '<th>Topic Name</th>';
            html += '<th>Total Grade</th>';
            html += '<th>Order Number</th>';
            html += '<th>Action</th>';
            html += '</tr>';
            html += '</thead>';

            html += '<tbody>';
            if (data.length != 0) {
              var jnama = "";
              for (var i = 0; i < data.length; i++) {
                if(jnama != data[i].jenj_nama){
                  html += '<tr>';
                  html += '<td class="bg-info text-light text-center" colspan="5">' + data[i].jenj_nama + '</td>';
                  html += '</tr>';
                }

                html += '<tr>';
                html += '<td>' + data[i].topik_semester + '</td>';
                html += '<td>' + data[i].topik_nama + '</td>';
                html += '<td>' + data[i].jum_tes + '</td>';
                html += '<td>' + data[i].topik_urutan + '</td>';
                html += '<td>';
                html += '<div class="form-group row pl-3">';
                html += '<form method="post" action="' + base_url + 'topik_CRUD/edit">';
                html += '<input type="hidden" value="' + data[i].jum_tes + '" name="jum_tes">';
                html += '<input type="hidden" value="' + data[i].topik_id + '" name="topik_id">';
                html += '<input type="hidden" value="' + data[i].topik_mapel_id + '" name="mapel_id">';
                html += '<button type="submit" class="badge badge-warning">';
                html += 'Edit';
                html += '</button>';

                html += '</form>';

                if (topik_jabatan_id == 4) {
                  html += '<form method="post" action="' + base_url + 'topik_CRUD/delete">';

                  html += '<input type="hidden" value="' + data[i].topik_id + '" name="topik_id">';
                  html += '<button type="submit" class="badge badge-danger">';
                  html += 'Delete';
                  html += '</button>';

                  html += '</form>';
                }
                html += '</div>';
                html += '</td>';
                html += '</tr>';

                jnama = data[i].jenj_nama;

              }
            } else {
              html += '<td colspan="6" class="text-center table-danger"><b>--No Topic(s), please add 1 or more topic--</b></td>';
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