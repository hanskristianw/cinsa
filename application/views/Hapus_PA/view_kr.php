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

    <?php if($jabatan_all): ?>
      <form class="user" id="frmTest" method="post" action="<?= base_url('Hapus_PA/view_kr2'); ?>">

        <input type="hidden" id="t_id" name="t_id" value="<?= $t_id ?>">

        <select class="form-control form-control-sm" name="jabatan_kpi_id" id="jabatan_kpi_id">
          <option value="0">Pilih Jabatan Karyawan yang akan dihapus</option>
          <?php foreach ($jabatan_all as $m) : ?>
            <option value="<?= $m['jabatan_kpi_id'] ?>"><?= $m['jabatan_kpi_nama'] ?></option>
          <?php endforeach; ?>
        </select>

        <div id="guru_ajax"></div>

      </form>
    <?php else: ?>
      <h5 class="text-danger text-center mt-4">- Belum ada jabatan yang mempunyai nilai PA pada tahun ini -</h5>
    <?php endif; ?>

  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {

    $('#jabatan_kpi_id').change(function () {

      $('#guru_ajax').html("");

      var jabatan_kpi_id = $(this).val();
      var t_id = $('#t_id').val();

      if (jabatan_kpi_id > 0) {
        $.ajax(
          {
            type: "post",
            url: base_url + "Rekap_PA_jabatan/get_karyawan_by_jabatan",
            data: {
              'jabatan_kpi_id': jabatan_kpi_id,
              't_id': t_id
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              //console.log(data);
              if (data.length == 0) {
                var html = '<div class="text-center mt-3 mb-3 text-danger"><b>--Belum ada karyawan --</b></div>';
              } else {

                var html = "";
                var i;

                html += `<select class="form-control form-control-sm mt-2" name="kr_id">`;
                for (i = 0; i < data['kr'].length; i++) {
                  html += `<option value="${data['kr'][i].kr_id}" >${data['kr'][i].kr_nama_depan} ${data['kr'][i].kr_nama_belakang} - ${data['kr'][i].sk_nama}</option>`;
                }
                html += `</select>`;

                html += `<button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
                  Next
                </button>`;
              }

              //console.log(html);

              $('#guru_ajax').html(html);
            }
          });
      }

    });


    $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-danger").slideUp(500);
    });
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>
