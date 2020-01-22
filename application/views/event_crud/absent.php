<style>
  .wrapper{
    display:grid;
    grid-template-columns:1fr 1fr 1fr 1fr;
    grid-auto-rows:minmax(20px, auto);
    /* grid-gap:1em; */
    justify-items:stretch;
    align-items:stretch;
    padding:1em;
    overflow: auto;
  }

  .wrapper_inside{
    display:grid;
    grid-template-columns:1fr 1fr 1fr 1fr;
    /* grid-gap:1em; */
    justify-items:stretch;
    align-items:stretch;
  }

  .top{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:2em;
    height: 10px;
  }
  .top_left{
    align-self:left;
    grid-column:1/5;
    text-align: left;
    padding:2em;
    height: 10px;
  }

  .bottom_center{
    align-self:center;
    grid-column:1/5;
    text-align:left;
    padding:1em;
    margin-bottom: 20px;
  }

  .announce{
    align-self:center;
    grid-column:1/5;
    text-align: center;
    padding:1em;
  }

  .left{
    /*justify-self:end;*/
    grid-column:1/3;
    padding:1em;
    /* grid-row:3; */
    /* border:1px solid #333; */
  }

  .right{
    grid-column:3/5;
    padding:1em;
    /* grid-row:2/4; */
    /* border:1px solid #333; */
  }

</style>


<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="top">
      <h4><u>Absensi Kegiatan <?= $event_all['event_nama'] ?></u></h4>
    </div>
    <div class="wrapper">
      <div class="top">
        <select name="sk" id="sk" class="form-control form-control-sm sk_id_absent">
          <option value="0">Select Unit</option>
          <?php foreach ($sk_all as $m) : ?>
            <option value='<?= $m['sk_id'] ?>'>
              <?= $m['sk_nama']; ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="wrapper">
      <div class="bottom_center">
        
        <?= $this->session->flashdata('message'); ?>
        <form class="user" method="post" action="<?= base_url('Event_CRUD/add_absent'); ?>">
          <input type="hidden" name="event_id" value="<?= $event_id ?>" class="event_absent">
          <div id="karyawan_absen">
          
          </div>
        </form>
      </div>
    </div>

  </div>
</div>


<script>
  $(document).ready(function () {
    
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
    });

    $('.sk_id_absent').change(function () {

      var sk_id = $(this).val();
      var event_id = $('.event_absent').val();
      //alert("hai");
      //alert(sk_id);
      if (sk_id == 0 || event_id == 0) {
        $('#karyawan_absen').html("");
      }
      else {

        $.ajax(
          {
            type: "post",
            url: base_url + "API/get_kr_absen_by_sk",
            data: {
              'sk_id': sk_id,
              'event_id': event_id
            },
            async: true,
            dataType: 'json',
            success: function (data) {
              if(data.length > 0){
                var html = '';

                html =`

                <h5 class="text-center text-danger"><u>Peserta yang BELUM terdata</u></h5> <br>

                
                <table class="table table-bordered table-striped table-sm" style="font-size:14px;">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Bukan Peserta</th>
                      <th>Hadir</th>
                      <th>Tidak</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>`;

                for (i = 0; i < data.length; i++) {
                  html += `
                  <tr>
                    <td class="align-middle" style='width: 30%; padding: 0px 0px 0px 5px;'>${data[i].kr_nama_depan} ${data[i].kr_nama_belakang}</td>
                    <td style='padding: 6px 0px 0px 5px;'>
                      <input type="hidden" value="${data[i].kr_id}" name="kr_id[]">
                      <input type="radio" class="form-control-sm" name="${data[i].kr_id}" value="0" style="height:15px;" checked>
                    </td>
                    <td style='padding: 6px 0px 0px 5px;'>
                      <input type="radio" class="form-control-sm" name="${data[i].kr_id}" value="1" style="height:15px;">
                    </td>
                    <td style='padding: 6px 0px 0px 5px;'>
                      <input type="radio" class="form-control-sm" name="${data[i].kr_id}" value="2" style="height:15px;">
                    </td>
                    <td style='width: 30%;'><input name="d_event_keterangan[]" style="height:20px; font-size:12px;" type="text" class="form-control form-control-sm"></td>
                  </tr>`;
                }
                  html+=`</tbody>
                    </table>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Save
                    </button>
                  `;

                $('#karyawan_absen').html(html);
              }
              //alert(data);
            }
          });
      }

    });
  });
</script>