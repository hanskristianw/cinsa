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

<?php

function return_status_absen($status){
  if($status == 0 || !$status){
    return "-";
  }elseif($status == 1){
    return "&#10004;";
  }elseif($status == 2){
    return "&#10006;";
  }
}

?>

<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="top">
      <h4><u>Laporan Kegiatan <?= $sk_nama['sk_nama'] ?></u></h4>
    </div>
  
    <div class="wrapper">
      <div class="bottom_center">
        
        <table class="table table-sm table-bordered" style="font-size:12px;">
          <thead>
            <tr>
              <th style="width:20%;">Nama</th>
              <?php foreach($event_all as $e): ?>
                <th style="width:100px;text-align:center;"><?= substr($e['event_nama'],0,20)."<br>(".date("d-m-Y", strtotime($e['event_tgl'])).")" ?></th>
              <?php endforeach; ?>
              <th style="width:70px;text-align:center;">Tidak<br>hadir</th>
              <th style="width:70px;text-align:center;">Hadir</th>
              <th style="text-align:center;">%</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($kr_all as $k): 
                $jum_tidak_hadir = 0;
                $jum_hadir = 0;
                $total = 0;
            ?>
              <tr>
                <td><?= $k['kr_nama_depan'].' '.$k['kr_nama_belakang'] ?></td>
                <?php foreach($event_all as $e): ?>
                  <td style="width:70px;text-align:center;">
                    <?php
                      $abs = cek_absen_kegiatan($k['kr_id'],$e['event_id']);
                      $status = $abs['d_event_hadir'];
                      if($status == 0 || !$status){
                        echo "-";
                      }elseif($status == 1){
                        //hadir
                        echo "&#10004;";
                        $jum_hadir++;
                        $total++;
                      }elseif($status == 2){
                        //tidak hadir
                        echo "&#10006;";
                        $jum_tidak_hadir++;
                        $total++;
                      }
                    ?>
                  </td>
                <?php endforeach; ?>
                <td style="text-align:center;"><?php if($jum_tidak_hadir==0)echo"-";else echo $jum_tidak_hadir; ?></td>
                <td style="text-align:center;"><?php if($jum_hadir==0)echo"-";else echo $jum_hadir; ?></td>
                <td style="text-align:center;"><?php if($total==0)echo"-";else echo round($jum_hadir/$total*100,0); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    // $(".bottom_center-success").fadeTo(2000, 500).slideUp(500, function(){
    //   $(".alert-success").slideUp(500);
    // });


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
