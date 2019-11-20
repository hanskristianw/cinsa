<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">

            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select School</h1>
            </div>
            <?php echo '<div class="alert alert-success alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    Topik <b>HANYA PERLU DIBUAT 1 KALI</b> dan dapat digunakan untuk setiap tahun ajaran<br><br>
                    
                </div>'; ?>

            <?php echo '<div class="alert alert-primary alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>

                    Deskripsi jika A,B maupun C dapat memakai karakter spesial: <br>
                    <b>{s}</b> &rarr; nama depan siswa <br>
                    <b>{his/her}</b> &rarr; his/her diawali dengan huruf KECIL berdasarkan gender murid<br>
                    <b>{HIS/HER}</b> &rarr; his/her diawali dengan huruf BESAR berdasarkan gender murid<br>
                    <b>{he/she}</b> &rarr; he/she diawali dengan huruf KECIL berdasarkan gender murid<br>
                    <b>{HE/SHE}</b> &rarr; he/she diawali dengan huruf BESAR berdasarkan gender murid<br>
                    <b>{herself/himself}</b> &rarr; herself/himself diawali dengan huruf KECIL berdasarkan gender murid<br>
                    <b>{HERSELF/HIMSELF}</b> &rarr; herself/himself diawali dengan huruf BESAR berdasarkan gender murid<br>
                    
                    <br>

                    <b>Contoh</b>: Tono is a diligent student. He never comes late, his attitude .... <br><br>
                    <b>Desc</b>: {s} is a diligent student. {HE/SHE} never comes late, {his/her} attitude ....
                    
                </div>'; ?>
            <?= $this->session->flashdata('message'); ?>

            <form method="post" action="<?= base_url('CB_CRUD/add_topik'); ?>">
              <select name="topik_sk_id" id="topik_sk_id" class="form-control">
                <?php
                foreach ($sk_all as $m) :
                  echo "<option value=" . $m['sk_id'] . ">" . $m['sk_nama'] . "</option>";
                endforeach
                ?>
              </select>
              <button type="submit" class="btn btn-primary btn-user mt-2">
                Add Topic
              </button>
            </form>

            <div id="topik_cb_ajax">

            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<script>
  $(document).ready(function() {
    $('#topik_sk_id').change(function() {
      var topik_sk_id = $(this).val();

      //alert(topik_sk_id);

      $('#topik_cb_ajax').html("");

      $.ajax({
        type: "post",
        url: base_url + "API/get_topik_CB",
        data: {
          'topik_sk_id': topik_sk_id,
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          //console.log(data);

          var html = '<table class="table table-bordered table-sm mt-2">';
          html += '<thead class="thead-dark">';
          html += '<tr>';
          html += '<th>Semester</th>';
          html += '<th>Topic Name</th>';
          html += '<th>Grade Count</th>';
          html += '<th>Desc A</th>';
          html += '<th>Desc B</th>';
          html += '<th>Desc C</th>';
          html += '<th>Action</th>';
          html += '</tr>';
          html += '</thead>';

          html += '<tbody>';
          if (data.length != 0) {
            var jnama = "";
            for (var i = 0; i < data.length; i++) {
              if (jnama != data[i].jenj_nama) {
                html += '<tr>';
                html += '<td class="bg-info text-light text-center" colspan="7">' + data[i].jenj_nama + '</td>';
                html += '</tr>';
              }

              html += '<tr>';
              html += '<td style="width: 10px;">' + data[i].topik_cb_semester + '</td>';
              html += '<td>' + data[i].topik_cb_nama + '</td>';
              html += '<td>' + data[i].jum_cb + '</td>';
              html += '<td>' + data[i].topik_cb_a + '</td>';
              html += '<td>' + data[i].topik_cb_b + '</td>';
              html += '<td>' + data[i].topik_cb_c + '</td>';
              html += '<td style="width: 150px;" class="p-2">';
              html += '<div class="form-group row pl-3">';
              html += '<form method="post" action="' + base_url + 'CB_CRUD/edit_topik">';
              html += '<input type="hidden" value="' + data[i].topik_cb_id + '" name="topik_cb_id">';
              html += '<input type="hidden" value="' + data[i].jum_cb + '" name="jum_cb">';
              html += '<button type="submit" class="badge badge-warning">';
              html += 'Edit';
              html += '</button>';
              html += '</form>';


              html += '<form method="post" action="' + base_url + 'CB_CRUD/delete_topik">';
              html += '<input type="hidden" value="' + data[i].topik_cb_id + '" name="topik_cb_id">';
              html += '<button type="submit" class="badge badge-danger">';
              html += 'Delete';
              html += '</button>';
              html += '</form>';

              html += '</div>';
              html += '</td>';
              html += '</tr>';

              jnama = data[i].jenj_nama;

            }
          } else {
            html += '<td colspan="7" class="text-center table-danger"><b>--No Topic(s), please add 1 or more topic--</b></td>';
          }
          html += '</tbody>';
          html += '</table>';


          //alert(html);

          $('#topik_cb_ajax').html(html);

        }
      });
    });

    $('#topik_sk_id').change();
  });
</script>