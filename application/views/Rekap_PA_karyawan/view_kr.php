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
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">

    <?php if($kr_all): ?>
      <form class="user" id="frmTest" method="post" action="<?= base_url('Rekap_PA_karyawan/hasil'); ?>">

        <input type="hidden" id="t_id" name="t_id" value="<?= $t_id ?>">

        <select class="form-control form-control-sm" name="kr_dinilai" id="kr_id">
          <option value="0">Pilih Karyawan</option>
          <?php foreach ($kr_all as $m) : ?>
            <option value="<?= $m['kr_id'] ?>"><?= $m['kr_nama_depan'].' '.$m['kr_nama_belakang'] ?></option>
          <?php endforeach; ?>
        </select>

        <div id="jabatan_ajax"></div>
        <div id="penilai_ajax"></div>

      </form>
    <?php else: ?>
      <h5 class="text-danger text-center mt-4">- Belum ada karyawan yang mempunyai nilai PA pada tahun ini -</h5>
    <?php endif; ?>

  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {

    $('#kr_id').change(function () {

      $('#jabatan_ajax').html("");
      $('#penilai_ajax').html("");

      var kr_id = $(this).val();
      var t_id = $('#t_id').val();

      if (kr_id > 0) {
        $.ajax(
          {
            type: "post",
            url: base_url + "Rekap_PA_karyawan/get_jabatan_by_karyawan",
            data: {
              'kr_id': kr_id,
              't_id': t_id
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              //console.log(data);
              if (data.length == 0) {
                var html = '<div class="text-center mt-3 mb-3 text-danger"><b>--Belum ada jabatan --</b></div>';
              } else {

                var html = "";
                var i;

                html += `<select class="form-control form-control-sm mt-2" name="jabatan_kpi_id" id="jabatan_kpi_id">
                  <option value="0">Pilih Jabatan</option>`;
                  for (i = 0; i < data.length; i++) {
                    html += `<option value="${data[i].jabatan_kpi_id}">${data[i].jabatan_kpi_nama}</option>`;
                  }
                html += `</select>`;
              }

              $('#jabatan_ajax').html(html);
              //refreshcheckpeni();
            },
            complete:function(){
              $('#jabatan_kpi_id').change(function () {

                $('#penilai_ajax').html("");

                var jabatan_kpi_id = $('#jabatan_kpi_id').val();
                var kr_id = $('#kr_id').val();
                var t_id = $('#t_id').val();
                if (jabatan_kpi_id > 0) {
                  $.ajax(
                    {
                      type: "post",
                      url: base_url + "Rekap_PA_karyawan/get_penilai",
                      data: {
                        'kr_id': kr_id,
                        't_id': t_id,
                        'jabatan_kpi_id': jabatan_kpi_id
                      },
                      async: true,
                      dataType: 'json',
                      success: function (data) {
                        if (data.length == 0) {
                          var html = '<div class="text-center mt-3 mb-3 text-danger"><b>--Belum ada jabatan --</b></div>';
                        } else {

                          var html = "";
                          var i;
                          html += `<div class="ml-2"><label class="mt-4"><b><u>Pilih Penilai</u>:</b></label><br>`;
                          for (i = 0; i < data.length; i++) {
                            html += `
                                  <input class="penic mt-2" name="kr_penilai[]" type=checkbox value="${data[i].kr_id}" id="${data[i].kr_id}">
                                  <label for="${data[i].kr_id}">${data[i].kr_nama_depan} ${data[i].kr_nama_belakang}</label><br>`;
                          }
                          html += `</div>`;

                          html += `<button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
                            Proses
                          </button>`;
                        }
                        $('#penilai_ajax').html(html);
                      }
                    });
                }
              });
            }
          });
      }

    });

    $("#frmTest").submit(function(){
        var checked = $("#frmTest input.penic:checked").length > 0;
        if (!checked){
            alert("Pilih setidaknya 1 karyawan");
            return false;
        }
    })

    $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-danger").slideUp(500);
    });
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>
