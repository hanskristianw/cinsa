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
    text-align: left;
    margin-top: 30px;
    /* padding:2em; */
    /* height: 10px; */
  }
  .top_left{
    align-self:left;
    grid-column:1/5;
    text-align: left;
    padding:2em;
    height: 10px;
  }

  .bottom_center{
    justify-items:stretch;
    align-items:stretch;
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
    padding-right:1em;
    /* grid-row:3; */
    /* border:1px solid #333; */
  }

  .right{
    grid-column:3/5;
    padding-left:1em;
    /* grid-row:2/4; */
    /* border:1px solid #333; */
  }

</style>


<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="top">
      <h4><u>Laporan Kegiatan</u></h4>
    </div>
    
    <form class="" action="<?= base_url('Event_CRUD/laporan_show') ?>" method="post">
      <div class="wrapper">
        <div class="top">
          <div class="alert alert-danger" role="alert" style="font-size:14px">
            <b>Perhatian:</b> Tanggal awal harus lebih kecil dari tanggal akhir!
          </div>
          <label for="sk" style="font-size:12px"><b><u>Unit</u>:</b></label>
          <select name="sk" id="sk" class="form-control form-control-sm mb-2">
            <?php foreach ($sk_all as $m) : ?>
              <option value='<?= $m['sk_id'] ?>'>
                <?= $m['sk_nama']; ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>


        <div class="left">
          <label for="tgl_awal" style="font-size:12px"><b><u>Tanggal Awal</u>:</b></label>
          <input type="date" name="tgl_awal" class="form-control form-control-sm mb-2 tgl_awal" required>
        </div>
          
        <div class="right">
          <label for="tgl_akhir" style="font-size:12px"><b><u>Tanggal Akhir</u>:</b></label>
          <input type="date" name="tgl_akhir" class="form-control form-control-sm mb-2 tgl_akhir" required>
        </div>
      </div>
      <div class="bottom_center">
        <button type="submit" class="btn btn-primary btn-user btn-block">
          Show
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function () {
    // $(".bottom_center-success").fadeTo(2000, 500).slideUp(500, function(){
    //   $(".alert-success").slideUp(500);
    // });

    $(".bottom_center").hide();

    $('.tgl_awal').change(function () {
      var startDate = new Date($('.tgl_awal').val());
      var endDate = new Date($('.tgl_akhir').val());

      if (startDate < endDate){
        $(".bottom_center").show();
      }else{
        $(".bottom_center").hide();
      }
    });

    $('.tgl_akhir').change(function () {
      $('.tgl_awal').change();
    });

  });
</script>
