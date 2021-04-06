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

<?php
  function returnsktamb($sk_tamb){
    if(strlen($sk_tamb) > 15){
      return "<div style='margin-top:0px;margin-bottom:0px;font-size:12px;' data-toggle='tooltip' data-placement='top' title='".$sk_tamb."'>".substr($sk_tamb, 0, 15)."... </div>";
    }else{
      return "<div style='margin-top:0px;margin-bottom:0px;font-size:12px;' data-toggle='tooltip' data-placement='top' title='".$sk_tamb."'>".$sk_tamb."</div>";
    }


  }
?>

<div class="grid-main">

  <div class="box1 text-center">
      <h1 class="h4 text-gray-900 mb-4 mt-4"><u>Daftar Karyawan</u></h1>
  </div>

  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1">
    <a href="<?= base_url('karyawan_crud/add') ?>" class="btn btn-secondary mb-3">&plus; Karyawan</a>
  </div>

  <div class="box1 mb-4">
    <table class="table table-hover table-bordered dt2" style="font-size:13px;">
      <thead>
        <tr>
          <th style='padding: 5px 5px 5px 5px;' rowspan="2" width="20%">Nama</th>
          <th style='padding: 5px 5px 5px 5px; width: 120px;' rowspan="2">Username</th>
          <th style='padding: 5px 5px 5px 5px;' rowspan="2">History<br>Status</th>
          <th style='padding: 5px 5px 5px 5px;' rowspan="2">Jabatan</th>
          <th style='padding: 5px 5px 5px 5px; width: 150px;' rowspan="2">Unit Utama</th>
          <th style='padding: 5px 5px 5px 5px; width: 130px;' rowspan="2">Unit Tambahan</th>
          <th style='padding: 5px 5px 5px 5px; text-align:center;' colspan="7" width="20%">Action</th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($kr_all as $m) : ?>
          <tr>
            <td style='padding: 2px 5px 2px 5px;'><?= $m['kr_nama_depan'].' '.$m['kr_nama_belakang'] ?></td>
            <td style='padding: 2px 5px 2px 5px;'><?= $m['kr_username'] ?></td>
            <td style='padding: 2px 5px 2px 5px;'><?= $m['st_nama'] ?></td>
            <td style='padding: 2px 5px 2px 5px;'><?= $m['jabatan_nama'] ?></td>
            <td style='padding: 2px 5px 2px 5px;'><?= ucfirst(strtolower($m['sk_nama'])) ?></td>
            <td style='padding: 2px 5px 2px 5px;'><?= returnsktamb($m['sk_tamb']) ?></td>

            <td style='padding: 0px 0px 0px 0px;'>
              <form class="text-center" action="<?= base_url('Karyawan_CRUD/update') ?>" method="get">
                <input type="hidden" name="_id" value=<?= $m['kr_id'] ?>>
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
            </td>

            <td style='padding: 0px 0px 0px 0px;'>
              <div class="text-center">
                <button id="<?= $m['kr_id'] ?>" class="update-status badge badge-dark">
                  &plus; Status
                </button>
              </div>
            </td>

            <td style='padding: 0px 0px 0px 0px;'>
              <div class="text-center">
                <form action="<?= base_url('Karyawan_CRUD/unit_tambahan') ?>" method="post">
                  <input type="hidden" name="kr_id" value="<?= $m['kr_id'] ?>">
                  <button class="badge badge-dark">
                    &plus; Unit Tambahan
                  </button>
                </form>
              </div>
            </td>

            <td style='padding: 0px 0px 0px 0px;'>
              <div class="text-center">
                <form action="<?= base_url('Karyawan_CRUD/reset') ?>" method="post">
                  <input type="hidden" name="kr_id" value="<?= $m['kr_id'] ?>">
                  <button type="submit" class="badge badge-info">
                    Reset Pass
                  </button>
                </form>
              </div>
            </td>

            <td style='padding: 0px 0px 0px 0px;'>
              <div class="text-center">
                <form action="<?= base_url('Karyawan_CRUD/ubah_status') ?>" method="post">
                  <input type="hidden" name="kr_id" value="<?= $m['kr_id'] ?>">
                    <?php if($m['kr_resign'] == 0) : ?>
                      <button onclick="return confirm('Karyawan yang dinonaktifkan tidak akan dapat mengakses SAS, lanjutkan?')" type="submit" class="badge badge-primary">
                        Nonaktif
                      </button>
                    <?php else: ?>
                      <button onclick="return confirm('Karyawan yang diaktifkan akan dapat mengakses SAS, Aktifkan kembali karyawan?')" type="submit" class="badge badge-success">
                        Aktifkan
                      </button>
                    <?php endif; ?>
                </form>
              </div>
            </td>

            <td style='padding: 0px 0px 0px 0px;'>
              <div class="text-center">
                <form action="<?= base_url('Karyawan_CRUD/print_laporan') ?>" method="post" class="form_print">
                  <input type="hidden" name="kr_id" value="<?= $m['kr_id'] ?>">
                  <button type="submit" class="badge badge-secondary" onclick="$('.form_print').attr('target', '_blank');">
                    Print
                  </button>
                </form>
              </div>
            </td>

            <td style='padding: 0px 0px 0px 0px;'>
              <div class="text-center">
                <form action="<?= base_url('Karyawan_CRUD/delete') ?>" method="post">
                  <input type="hidden" name="kr_id" value="<?= $m['kr_id'] ?>" method="post">
                  <button onclick="return confirm('Lebih disarankan untuk nonaktifkan pegawai atau edit daripada menghapus karyawan, menghapus karyawan akan menghapus seluruh history nilai dan kelas, pastikan karyawan tidak memiliki kelas dan nilai, lanjutkan?')" type="submit" class="badge badge-danger">
                    Del
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>


</div>


<script type = "text/javascript">
  $(document).ready(function () {

    $('.dt2').DataTable({
      "pageLength": 50
    });

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
    });

    function refreshhistory(){
      var kr_id = $('.kr_id').val();

      $.ajax(
      {
          type: "post",
          url: base_url + "API/get_history_st",
          data: {
            'kr_id': kr_id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
              //console.log(data);
              if (data.length == 0) {
                  var html = 'No History Available';
              }
              else {
                  var i;

                  var html = '';

                  html += '<table>';
                  html += '<thead>';
                  html += '<th style="padding: 0px 5px 0px 5px;">Date</th>';
                  html += '<th></th>';
                  html += '<th style="padding: 0px 5px 0px 5px;">Status</th>';
                  html += '<th></th>';
                  html += '</thead>';
                  html += '<tbody>';
                  for (i = 0; i < data.length; i++) {
                      html += '<tr>';
                      html += '<td style="padding: 0px 15px 0px 0px;">'+data[i].kr_h_status_tanggal+'</td>';
                      html += '<td style="padding: 0px 15px 0px 0px;">&rarr;</td>';
                      html += '<td style="padding: 0px 15px 0px 5px;">'+data[i].st_nama+'</td>';
                      html += '<td>';
                      html += '<form method="post" action="'+ base_url + "Karyawan_CRUD/delete_history"+'">';

                      html += '<input type="hidden" class="form-control-sm ml-2" name="kr_h_status_id" value="'+data[i].kr_h_status_id+'">';
                      html += '<button type="submit" class="badge badge-danger ml-2">';
                      html += '<i class="fa fa-times"></i>';
                      html += '</button>';

                      html += '</form>';
                      html += '</td>';
                      html += '</tr>';
                  }
                  html += '</tbody>';
                  html += '</table>';

              }

              $('.history_ajax').html(html);
          }
      });
    }

    $(".update-status").on('click', function (event) {
      event.preventDefault();
      var kr_id = this.id;

      $("#judul_modal").html("Update Status");

      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_st",
        data: {

        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Status--</b></div>';
          } else {
            var i;

            var html = '';
            html += '<form method="post" action="'+ base_url + "Karyawan_CRUD/update_status"+'">';
            html += '<select class="form-control-sm" name="kr_h_status_status_id">';

            for (i = 0; i < data.length; i++) {
                html += '<option value="'+data[i].st_id+'">'+data[i].st_nama+'</option>';
            }

            html += '</select>';

            html += '<input type="hidden" class="form-control-sm ml-2 kr_id" name="kr_id" value="'+kr_id+'" required>';

            html += '<input type="date" class="form-control-sm ml-2" name="kr_h_status_tanggal" required>';

            html += '<button type="submit" class="bagde badge-primary btn-user ml-2">';
            html += 'Update';
            html += '</button>';

            html += '</form>';

            html += '<div class="history_ajax mt-3"></div>';

          }

          $('#isi_modal').html(html);

          refreshhistory();
          $("#myModal").show();
        }
      });

    });

  });
</script>
