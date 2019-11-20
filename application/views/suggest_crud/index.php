<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5 overflow-auto">
                        <div class="text-center mb-3">
                            <h4><u>Kritik dan Saran</u></h4>
                        </div>
                        <div class="alert alert-info alert-dismissible fade show mb-2">
                            <button class="close" data-dismiss="alert" type="button">
                                <span>&times;</span>
                            </button>
                            <li>Kritik dan saran dapat dikirim sebagai anonim (tanpa nama)</li>
                            <li>Isi pesan dapat berupa saran, kritik, ataupun keluhan</li>
                            <li>Untuk melihat tim divisi pendidikan <a href='javascript:void(0)' class="link-kadiv" data-toggle="myModal2" data-target="#myModal2">klik disini</a></li>
                            <li>Untuk melihat tim pengurus harian <a href='javascript:void(0)' class="link-ph" data-toggle="myModal2" data-target="#myModal2">klik disini</a></li>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" action="<?= base_url('Suggest_CRUD/add') ?>" method="POST">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                    <label for="suggest_to"><b><u>Kepada</u>:</b></label>
                                    <select class="form-control form-control-sm" name="suggest_jabatan_id" id="">
                                        <option value="8">Pengurus Harian</option>
                                        <option value="5">Div Pendidikan</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                    <label for="suggest_to"><b><u>Kirim Sebagai</u>:</b></label>
                                    <select class="form-control form-control-sm" name="suggest_kr_id" id="">
                                        <option value="<?= $kr['kr_id'] ?>"><?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'] ?></option>
                                        <option value="">Anonim</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <label for="suggest_pesan"><b><u>Isi Pesan</u>:</b></label>
                            <textarea name="suggest_pesan" rows="8" cols="50" class="form-control form-control-sm" required></textarea>

                            <button type="submit" class="btn btn-primary float-right ml-3 mt-3 btn-block btn-user">
                                Kirim
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script type = "text/javascript">
  $(document).ready(function () {

    $(".link-kadiv").on('click', function () {

      $("#judul_modal").html("Tim Pendidikan");

      $(".modal-dialog").removeClass("modal-dialog-custom");
      $(".modal-body").removeClass("modal-body-custom");
      //alert(mapel_id);
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_tim_kadiv",
        data: {
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
          } else {
            
            var html ="";
            var i;
            
            for (i = 0; i < data.length; i++) {
              if(data[i].kr_nama_depan != "admin"){
                html += "<li>"+data[i].kr_nama_depan+" "+data[i].kr_nama_belakang+"</li>"
              }
            }
            
          }
            $('#isi_modal').html(html);
            $("#myModal").show();
          
        }
      });
    });

    $(".link-ph").on('click', function () {
        
        $("#judul_modal").html("Pengurus Harian");

        $(".modal-dialog").removeClass("modal-dialog-custom");
        $(".modal-body").removeClass("modal-body-custom");
        //alert(mapel_id);
        $.ajax(
        {
        type: "post",
        url: base_url + "API/get_tim_ph",
        data: {
        },
        async: true,
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            if (data.length == 0) {
            var html = '<div class="text-center mb-3 text-danger"><b>--No Data--</b></div>';
            } else {
            
                var html ="";
                var i;
                
                for (i = 0; i < data.length; i++) {
                    if(data[i].kr_nama_depan != "admin"){
                    html += "<li>"+data[i].kr_nama_depan+" "+data[i].kr_nama_belakang+"</li>"
                    }
                }
            
            }
            
            $('#isi_modal').html(html);
            $("#myModal").show();
            
        }
        });
    });
  });
</script>