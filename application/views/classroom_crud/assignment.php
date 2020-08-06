<style>
.grid-container {
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

    <h4 class="text-center"><u><?= $title ?></u></h4>

    <form action="<?= base_url('Classroom_CRUD/get_grade') ?>" method="post">

      <div id="jenis">
        <label><b><u>Jenis nilai tujuan</u>:</b></label>
        <select name="jenis_ex" class="form-control form-control-sm mb-2">
          <option value="uj_mid1_kog~Mid Pengetahuan Semester 1">Mid Pengetahuan Semester 1</option>
          <option value="uj_fin1_kog~Final Pengetahuan Semester 1">Final Pengetahuan Semester 1</option>
          <option value="uj_mid2_kog~Mid Pengetahuan Semester 2">Mid Pengetahuan Semester 2</option>
          <option value="uj_fin2_kog~Final Pengetahuan Semester 2">Final Pengetahuan Semester 2</option>
          <option value="uj_mid1_psi~Mid Ketrampilan Semester 1">Mid Ketrampilan Semester 1</option>
          <option value="uj_fin1_psi~Final Ketrampilan Semester 1">Final Ketrampilan Semester 1</option>
          <option value="uj_mid2_psi~Mid Ketrampilan Semester 2">Mid Ketrampilan Semester 2</option>
          <option value="uj_fin2_psi~Final Ketrampilan Semester 2">Final Ketrampilan Semester 2</option>
        </select>
      </div>

      <label><b><u>Pilih Assignment yang akan ditransfer</u>:</b></label>
      <select class="form-control form-control-sm mb-2" name="ass_opt">
        <?php foreach ($cwork as $c): ?>
          <option value="<?= $c->id.'~'.$c->courseId ?>"><?= $c->title ?></option>
        <?php endforeach; ?>
      </select>

      <label><b><u>Tahun Ajaran kelas tujuan</u>:</b></label>
      <select name="t_id" id="tes_ass" class="form-control form-control-sm mb-2">
        <option value="0">Pilih tahun ajaran</option>
        <?php foreach ($t_all as $m) : ?>
          <option value='<?= $m['t_id'] ?>'>
            <?= $m['t_nama'] ?>
          </option>
        <?php endforeach ?>
      </select>
      <div id="kelas_ass_ajax">

      </div>

      <div id="mapel_tes_ajax">

      </div>

      <hr>

    </form>
  </div>

</div>


<script>
$(document).ready(function () {

  $('#tes_ass').change(function () {

    var t_id = $(this).val();
    $('#kelas_ass_ajax').html("");
    $('#mapel_tes_ajax').html("");

    $.ajax(
      {
        type: "post",
        url: base_url + "API/get_kelas_by_kr",
        data: {
          't_id': t_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--Tidak ada kelas ajar, hubungi wakakur--</b></div>';
          } else {
            var html = '<label><b><u>Kelas Ajar</u>:</b></label><select name="kelas_id" id="kelas_ass" class="form-control form-control-sm mb-3">';
            var i;

            html += '<option value="0">Pilih Kelas</option>';
            for (i = 0; i < data.length; i++) {
              html += '<option value=' + data[i].kelas_id + '>' + data[i].kelas_nama + '-' + data[i].sk_nama + '</option>';
            }
            html += '</select>';

          }

          $('#kelas_ass_ajax').html(html);
          refreshTesKelas();
        }
      });
  });

  function refreshTesKelas() {
    $('#kelas_ass').change(function () {
      var kelas_id = $(this).val();

      //alert("hai");
      if (kelas_id == 0) {
        $('#mapel_tes_ajax').html("");
      }

      $.ajax(
        {
          type: "post",
          url: base_url + "API/get_mapel_by_kr_kelas",
          data: {
            'kelas_id': kelas_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--Tidak ada mapel di kelas ini--</b></div>';
            } else {
              var html = '<label><b><u>Mapel Ajar</u>:</b></label><select name="mapel_id" class="form-control form-control-sm mb-3">';

              var i;
              for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].mapel_id + '>' + data[i].mapel_nama + '</option>';
              }
              html += '</select>';

              html += `<button type="submit" class="btn btn-success btn-sm">
                Next &#8594;
              </button>`;
            }

            $('#mapel_tes_ajax').html(html);
          }
        });
    });
  }

});
</script>
