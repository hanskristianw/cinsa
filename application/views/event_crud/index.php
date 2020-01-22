<style>
  .wrapper{
    display:grid;
    grid-template-columns:1fr 1fr 1fr 1fr;
    grid-auto-rows:minmax(20px, auto);
    /* grid-gap:1em; */
    justify-items:stretch;
    align-items:stretch;
    padding:1em;
  }

  .wrapper_img{
    display:grid;
    grid-template-columns: 80% 20%;
    /* grid-gap:1em; */
    overflow: auto;
    padding:1em;
    height:400px;
    align-items: center;
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
      <h4><u>Event List</u></h4>
    </div>
    <div class="top_left">
      <a href="<?= base_url('Event_CRUD/add') ?>" class="btn btn-sm btn-primary">Add New Event</a>
    </div>
    <div class="wrapper">
      <div class="bottom_center">
        
        <?= $this->session->flashdata('message'); ?>
        <table class="dt2 cell-border compact stripe" style="font-size:14px;">
          <thead>
            <tr>
              <th>Event Name</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($event_all as $m) : ?>
              <tr>
                <td>
                  <a class='link-img' style="text-decoration : none; color: inherit;" rel="<?= $m['event_id'] ?>" href='javascript:void(0)' data-toggle="myModal2" data-target="#myModal2"><?= $m['event_nama'] ?>
                  </a>
                </td>
                <td style="width:10%;"><?= date("d-m-Y", strtotime($m['event_tgl'])) ?></td>
                <td style="width:10%;">
                  <div class="wrapper_inside">
                    <div>
                      <form class="" action="<?= base_url('Event_CRUD/update') ?>" method="post">
                        <input type="hidden" name="event_id" value=<?= $m['event_id'] ?>>
                        <button type="submit" class="badge badge-warning">
                          Edit
                        </button>
                      </form>
                    </div>
                    
                    <div>
                      <form class="" action="<?= base_url('Event_CRUD/absent') ?>" method="post">
                        <input type="hidden" name="event_id" value=<?= $m['event_id'] ?>>
                        <button type="submit" class="badge badge-success">
                          Add Abs
                        </button>
                      </form>
                    </div>

                    <div>
                      <form class="" action="<?= base_url('Event_CRUD/add_pic') ?>" method="post">
                        <input type="hidden" name="event_id" value=<?= $m['event_id'] ?>>
                        <button type="submit" class="badge badge-secondary">
                          Add Pic
                        </button>
                      </form>
                    </div>

                    <div>
                      <form class="" action="<?= base_url('Event_CRUD/del_absent') ?>" method="post">
                        <input type="hidden" name="event_id" value=<?= $m['event_id'] ?>>
                        <button type="submit" class="badge badge-danger">
                          Del Abs
                        </button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>


<script>
  $(document).ready(function () {
    $('.dt2').DataTable({
      "pageLength": 50
    });

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
    });

    $(".alert-danger").fadeTo(3000, 500).slideUp(500, function(){
      $(".alert-danger").slideUp(500);
    });

    $(".link-img").on('click', function() {
      var event_id = $(this).attr("rel");
      var html = '';

      $.ajax({
        type: "post",
        url: base_url + "API/get_img_event",
        data: {
          'event_id': event_id,
        },
        async: true,
        dataType: 'json',
        success: function(data) {
          console.log(data);
          if (data.length == 0) {
            html += '<div class="text-center mb-3 text-danger"><b>--No Image Available--</b></div>';
          } else {
            html += '<div class="wrapper_img">';
            var i;
            for (i = 0; i < data.length; i++) {
              html += '<div><img src="'+base_url+'assets/img/event/'+data[i].event_gambar_path+'" width="200px"></div>';
              
              html += '<div><form method="post" action="' + base_url + 'Event_CRUD/deleteimg">';
              html += '<input type="hidden" value="'+data[i].event_gambar_path+'" name="event_gambar_path">';
              html += '<input type="hidden" value="'+data[i].event_gambar_id+'" name="event_gambar_id">';
              html += `<button type="submit" class="badge badge-danger">
                          Delete
                        </button>`;
              html += "</form></div>";
            }
            html += '</div>';
            
          }
          
          $("#judul_modal").html("Image");

          $(".modal-dialog").removeClass("modal-dialog-custom");
          $(".modal-body").removeClass("modal-body-custom");

          $('#isi_modal').html(html);
          $("#myModal").show();
        }
      });

    });


  });
</script>