<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select School, Class, Topic, Indicator</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>
            
            <form method="post" action="<?= base_url('CB_CRUD/grade_cek'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="sk_id" id="sk_cb" class="form-control">
                    <option value="0">Select School</option>
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="t" id="t_cb" class="form-control">
                    <option value="0">Select Year</option>
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?= $m['t_id'] ?>'>
                        <?= $m['t_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              
              <div id="kelas_cb_ajax">
                
              </div>
              
              <div id="topik_cb_ajax">
              
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
    $('#t_cb').change(function () {
    $('#sk_cb').change();
  });

  $('#sk_cb').change(function () {

    var sk_id = $(this).val();
    var t_id = $('#t_cb').val();

    $('#kelas_cb_ajax').html("");
    $('#topik_cb_ajax').html("");
    $('#indicator_cb_ajax').html("");

    if(sk_id>0){
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_kelas_by_year_sk",
        data: {
          't_id': t_id,
          'sk_id': sk_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Class, Add Class First--</b></div>';
          } else {
            var html = '<select name="kelas_id" id="kelas_cb" class="form-control mb-3 kelas_id">';

            html += '<option value="0">Select Class</option>';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '</option>';
            }
            html += '</select>';
          }


          $('#kelas_cb_ajax').html(html);
          refKelasCB();

        }
      });
    }

  });

  function refKelasCB(){
    $('#kelas_cb').change(function () {

      var sk_id = $('#sk_cb').val();
      var kelas_id = $(this).val();

      $('#topik_cb_ajax').html("");
      $('#indicator_cb_ajax').html("");
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_topik_cb_by_jenj_sk",
        data: {
          'sk_id': sk_id,
          'kelas_id': kelas_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Topic, Add Topic First--</b></div>';
          } else {
            var html = '<select name="topik_cb" id="topik_cb" class="form-control mb-3">';

            var i;
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].topik_cb_id + '>' + data[i].topik_cb_nama + '</option>';
            }
            html += '</select>';
            
            html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
            html += 'Show Grade';
            html += '</button>';
          }


          $('#topik_cb_ajax').html(html);

        }
      });

    });
  }
 

  });
</script>