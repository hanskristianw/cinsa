<style>
.grid-container {
  display: grid;
  grid-template-columns: 100%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
}
</style>

<div class="grid-container">

  <div class="text-center">
    <h1 class="h4 text-gray-900"><?= $title.' '.$sk_detail['sk_nama'] ?></h1>
    <h1 class="h4 text-gray-900 mb-4"><u><?= $t_detail['t_nama'] ?></u></h1>
  </div>
  <div class="p-2"><?= $this->session->flashdata('message'); ?></div>
  <div id="print_area">
  <table class="table table-hover table-bordered table-sm" style="font-size:11px;">
    <thead>
      <tr>
        <th style='width: 10px;'>No</th>
        <th>Nama</th>
        <th style='width: 50px;'>Status</th>
        <th>Mapel</th>
        <?php
        foreach ($kelas_all as $m) : 
          echo "<th style='width: 30px'>".ucfirst(strtolower ($m['kelas_nama_singkat']))."</th>";
        ?>
        <?php endforeach ?>
        <th style='width: 5%' >Jum Unit Lain</th>
        <th style='width: 5%' >Total</th>
      </tr>
    </thead>
    <tbody>
      
      <?php $no=1; $temp=""; 
      foreach ($kr_all as $m) : 
        $mapel_ajar = return_mapel_ajar_by_guru($sk_detail['sk_id'], $m['kr_id'], $t_detail['t_id']);

        if($mapel_ajar):

        $st = explode(',',$m['st_nama']);
        if($st[0])
          $st = $st[0];
        else
          $st = "";
        // $mapel_id_dis = explode(",",$m['mapel_id_dis']);
      ?>
        <tr>
          <td rowspan="<?= count($mapel_ajar)+1; ?>"><?= $no; ?></td>
          <td rowspan="<?= count($mapel_ajar)+1; ?>"><?= $m['kr_nama_depan'].' '.$m['kr_nama_belakang'] ?></td>
          <td rowspan="<?= count($mapel_ajar)+1; ?>"><?= $st; ?></td>
        </tr>
        <!-- CETAK MAPEL dan BEBAN perkelas -->
          <?php 
              $count=0; 
              $total = 0;
              foreach ($mapel_ajar as $a) : ?>
          <tr>
            <td><?= $a['mapel_nama'] ?></td>
            <?php foreach ($kelas_all as $k) : ?>
            <td>
              <?php
                $jam_kelas = return_jam_by_guru_kelas($m['kr_id'], $k['kelas_id'],$a['mapel_id']);
                if($jam_kelas){
                  $total += $jam_kelas;
                  echo $jam_kelas;
                }
              ?>
            </td>
            <?php endforeach; ?>
            <?php if ($count == 0) : ?>
              <td rowspan="<?= count($mapel_ajar)+1; ?>">
                <?php 
                  $jam_unit_lain = return_jam_by_guru_kelas_unit_lain($m['kr_id'], $t_detail['t_id'], $sk_detail['sk_id']);
                  if($jam_unit_lain){
                    $total += $jam_unit_lain;
                    echo $jam_unit_lain;
                  }
                ?>
              </td>
              <td rowspan="<?= count($mapel_ajar)+1; ?>"><div class="tot_dis"></div></td>
            <?php endif; ?>
          </tr>
          <?php $count++; endforeach; ?>
        <!-- //////////////////////////////// -->
        <div class="tot_temp" rel="<?= $total ?>"></div>
      <?php $no++; 
        endif; 
      endforeach; 
      ?>
    </tbody>
  </table>
  </div>
  <button type="submit" class="btn btn-success btn-user btn-block" id="export_excel">
      Export To Excel
  </button>
  <hr>

</div>


<script type="text/javascript">

  $(document).ready(function() {
    
    var tot_arr = [];
    $(".tot_temp").each(function() {
      tot_arr.push($(this).attr('rel'));
    });

    var i =0;
    $(".tot_dis").each(function() {
      $(this).html(tot_arr[i]);
      i++;
    });

  });

</script>