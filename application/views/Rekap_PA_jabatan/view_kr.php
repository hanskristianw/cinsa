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
      <form class="user" id="frmTest" method="post" action="<?= base_url('Rekap_PA_jabatan/view_kr2'); ?>">

        <input type="hidden" id="t_id" name="t_id" value="<?= $t_id ?>">

        <select class="form-control form-control-sm" name="jabatan_kpi_id" id="jabatan_kpi_id">
          <option value="0">Pilih Jabatan</option>
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

                html += `<div class="card mt-4">
                              <div class="card-header">
                                <div class="text-center"><b><u>Unit Karyawan</u></b></div>
                                <input class="checkAllpeni" id="checkAllpeni" type="checkbox">
                                <label style="font-size:13px;" for="checkAllpeni"><b><u>Semua Unit</u></b></label><br>`;

                for (i = 0; i < data['sk'].length; i++) {
                  html += `<input type=checkbox value="${data['sk'][i].sk_id}" id="${data['sk'][i].sk_id}"
                            onClick="(function(){
                              if ($('#${data['sk'][i].sk_id}').prop('checked')==true){
                                $('.sk${data['sk'][i].sk_id}').prop('checked', true);
                              }else{
                                $('.sk${data['sk'][i].sk_id}').prop('checked', false);
                              }

                            })();"
                           >
                           <label style="font-size:13px;" for="${data['sk'][i].sk_id}"><b><u>Hanya ${data['sk'][i].sk_nama}</u></b></label><br>`;
                }

                html += `</div>
                        <div class="card-body">`;

                for (i = 0; i < data['kr'].length; i++) {
                  html += `<input class="penic sk${data['kr'][i].sk_id}" name="kr_id[]" type=checkbox value="${data['kr'][i].kr_id}" id="${data['kr'][i].kr_id}">
                           <label for="${data['kr'][i].kr_id}">${data['kr'][i].kr_nama_depan} ${data['kr'][i].kr_nama_belakang} - ${data['kr'][i].sk_nama}</label><br>`;
                }
                html += `</div>
                        </div>`;

                html += `<button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
                  Next
                </button>`;
              }

              //console.log(html);

              $('#guru_ajax').html(html);
              refreshcheckpeni();
            }
          });
      }

    });

    function refreshcheckpeni(){
      $(".checkAllpeni").click(function () {
        $('input.penic:checkbox').not(this).prop('checked', this.checked);
      });

      $("#frmTest").submit(function(){
          var checked = $("#frmTest input.penic:checked").length > 0;
          if (!checked){
              alert("Pilih setidaknya 1 karyawan");
              return false;
          }
      });
    }

    $(".alert-danger").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-danger").slideUp(500);
    });
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

  });
</script>
