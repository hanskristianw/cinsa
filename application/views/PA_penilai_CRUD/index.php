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
  margin-right: 20px;
}

</style>

<div class="grid-main">

  <div class="box1 text-center mt-4"><h4><u>PA</u></h4></div>
  <div class="box1 text-center"><h5><u>Pilih Tahun dan Jabatan yang akan dinilai</u></h5></div>


  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">
    <form class="" action="<?= base_url('PA_penilai_CRUD/input'); ?>" method="post">

      <label class="mt-3"><b>Tahun Ajaran:</b></label>
      <select name="t_id" class="form-control form-control-sm">
        <?php
          foreach ($t_all as $t) :
            echo "<option value=" . $t['t_id'] . ">" . $t['t_nama'] . "</option>";
          endforeach
        ?>
      </select>

      <label class="mt-3"><b>Jabatan Anda Sebagai:</b></label>
      <select id="jabatan_kpi_id" class="form-control form-control-sm">
        <option value="0">Pilih Jabatan</option>
        <?php
          foreach ($jab_all as $t) :
            echo "<option value=" . $t['jabatan_kpi_id'] . ">" . $t['jabatan_kpi_nama'] . "</option>";
          endforeach
        ?>
      </select>

      <div id="jabatan_yang_dinilai">

      </div>

      <div id="guru_dinilai_ajax">

      </div>


    </form>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {


    $('#jabatan_kpi_id').change(function () {

      $('#jabatan_yang_dinilai').html("");
      $('#guru_dinilai_ajax').html("");

      var jabatan_kpi_id = $(this).val();

      if (jabatan_kpi_id > 0) {
        $.ajax(
          {
            type: "post",
            url: base_url + "KPI_penilai_CRUD/get_jabatan_dinilai",
            data: {
              'jabatan_kpi_id': jabatan_kpi_id
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              //alert(data);
              if (data.length == 0) {
                var html = '<div class="text-center mt-3 mb-3 text-danger"><b>--Belum ada jabatan yang harus anda nilai--</b></div>';
              } else {
                var html = '<label class="mt-3"><b>Pilih Jabatan Yang akan dinilai:</b></label><select id="jabatan_dinilai" name="jabatan_kpi_id" class="form-control form-control-sm"><option value="0">Pilih Jabatan</option>';
                var i;
                for (i = 0; i < data.length; i++) {
                  html += '<option value=' + data[i].jabatan_kpi_id + '>' + data[i].jabatan_kpi_nama + '</option>';
                }
                html += `</select>`;
              }

              $('#jabatan_yang_dinilai').html(html);
              refGuruDinilai();
            }
          });
      }

    });

    function refGuruDinilai(){
      $('#jabatan_dinilai').change(function () {

        $('#guru_dinilai_ajax').html("");

        var jabatan_kpi_id = $(this).val();

        if (jabatan_kpi_id > 0) {
          $.ajax(
            {
              type: "post",
              url: base_url + "KPI_penilai_CRUD/get_guru_dinilai",
              data: {
                'jabatan_kpi_id': jabatan_kpi_id
              },
              async: true,
              dataType: 'json',
              success: function (data) {
                //alert(data);
                if (data.length == 0) {
                  var html = '<div class="text-center mt-3 mb-3 text-danger"><b>--Belum ada karyawan yang harus anda nilai--</b></div>';
                } else {
                  var html = `<label class="mt-3"><b>Pilih Karyawan yang akan dinilai:</b></label>
                  <select name="kr_id" class="form-control form-control-sm">`;
                  var i;
                  for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].kr_id + '>' + data[i].kr_nama_depan + ' ' + data[i].kr_nama_belakang + ' - ' + data[i].sk_nama + '</option>';
                  }
                  html += `</select>
                  <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
                    Input
                  </button>`;
                }

                $('#guru_dinilai_ajax').html(html);
              }
            });
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
