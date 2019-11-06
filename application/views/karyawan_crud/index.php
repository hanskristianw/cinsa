<style>
  table.dataTable td {
    padding: 0px;
  }
</style>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
              <div class="p-5 overflow-auto">
                  <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Employee List</h1>
                  </div>
                  
                  <?= $this->session->flashdata('message'); ?>

                  <a href="<?= base_url('karyawan_crud/add') ?>" class="btn btn-primary mb-3">Add New Employee</a>

                  <table class="table-bordered dt compact">
                    <thead>
                      <tr>
                        <th style='padding: 0px 0px 0px 5px; width: 100px;'>First Name</th>
                        <th style='padding: 0px 0px 0px 5px; width: 200px;'>Last Name</th>
                        <th style='padding: 0px 0px 0px 5px; width: 120px;'>Username</th>
                        <th style='padding: 0px 0px 0px 5px; width: 100px;'>Department</th>
                        <th style='padding: 0px 0px 0px 5px; width: 150px;'>School</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($kr_all as $m) : ?>
                        <tr>
                          <td style='padding: 0px 5px 0px 5px;'><?= $m['kr_nama_depan'] ?></td>
                          <td style='padding: 0px 5px 0px 5px;'><?= $m['kr_nama_belakang'] ?></td>
                          <td style='padding: 0px 5px 0px 5px;'><?= $m['kr_username'] ?></td>
                          <td style='padding: 0px 5px 0px 5px;'><?= $m['jabatan_nama'] ?></td>
                          <td style='padding: 0px 5px 0px 5px;'><?= ucfirst(strtolower($m['sk_nama'])) ?></td>
                          <td style='padding: 10px 0px 0px 20px;'>
                            <div class="form-group row">
                              <form class="" action="<?= base_url('Karyawan_CRUD/update') ?>" method="get">
                                <input type="hidden" name="_id" value=<?= $m['kr_id'] ?>>
                                <button type="submit" class="badge badge-warning">
                                  Edit
                                </button>
                              </form>
                              
                              <div>
                                <button id="<?= $m['kr_id'] ?>" class="update-status badge badge-success">
                                  Status
                                </button>
                              </div>
                              
                              <form action="<?= base_url('Karyawan_CRUD/reset') ?>" method="post">
                                <input type="hidden" name="kr_id" value=<?= $m['kr_id'] ?>>
                                <button type="submit" class="badge badge-info">
                                  Reset
                                </button>
                              </form>

                              <form action="<?= base_url('Karyawan_CRUD/print') ?>" method="post">
                                <input type="hidden" name="_id" value=<?= $m['kr_id'] ?>>
                                <button type="submit" class="badge badge-secondary">
                                  Print
                                </button>
                              </form>

                              <form class="" action="<?= base_url('Karyawan_CRUD/delete') ?>" method="post">
                                <input type="hidden" name="kr_id" value=<?= $m['kr_id'] ?> method="post">
                                <button type="submit" class="badge badge-danger">
                                  Delete
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                  <hr>
              </div>
            </div>
        </div>
        </div>
    </div>

</div>


<script type = "text/javascript">
  $(document).ready(function () {
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
