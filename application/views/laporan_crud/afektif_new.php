<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5 border-left-success">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h5 class="text-gray-900 mb-4">Select School, Year And Month</h5>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Laporan_CRUD/show_report_by_subject') ?>" method="POST">

              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="sk_id" id="sk_id2" class="form-control mb-1">
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="t_id" id="t_id2" class="form-control">
                    <option value="0">Select Year</option>
                    <?php foreach ($tahun_all as $m) : ?>
                      <option value='<?=$m['t_id']?>'>
                        <?= $m['t_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              
              <div id="bulan_lap"></div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  $(document).ready(function () {

    $('#sk_id2').change(function () {
      $('#t_id2').change();
    });

    $('#t_id2').change(function () {
      
      var t_id = $(this).val();
      var sk_id = $('#sk_id2').val();

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_bulan_afek_terisi",
          data: {
            't_id': t_id,
            'sk_id': sk_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--No Month(s) Available--</b></div>';
            } else {
              var i;
              html = "";


              for (i = 0; i < data.length; i++) {
                html += '<div class="checkbox ml-2">';
                html += '<label><input type="checkbox" name="bulan_check[]" value="' + data[i].k_afek_bulan_id + '"> ' + data[i].bulan_nama + '</label>';
                html += '</div>';
              }

              html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
              html += 'Show Report';
              html += '</button>';

            }

            $('#bulan_lap').html(html);

          }
        });
      
    });

  });
</script>