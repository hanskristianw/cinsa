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
.grid-dalam {
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
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
  <table class="table table-hover table-bordered table-sm" style="font-size:11px; border: 1px solid black; border-collapse: collapse;">
    <thead>
      <tr>
        <th style='width: 10px; border: 1px solid black;'>No</th>
        <th style="border: 1px solid black;">Nama</th>
        <th style='width: 50px; border: 1px solid black;'>Status</th>
        <th style="border: 1px solid black;">Mapel</th>
        <?php
        foreach ($kelas_all as $m) : 
          echo "<th style='width: 30px; border: 1px solid black;'>".ucfirst(strtolower ($m['kelas_nama_singkat']))."</th>";
        ?>
        <?php endforeach ?>
        <th style='width: 5%; border: 1px solid black;' >Jum Unit Lain</th>
        <th style='width: 5%; border: 1px solid black;' >Tambahan</th>
        <th style='width: 5%; border: 1px solid black;' >Total</th>
      </tr>
    </thead>
    <tbody>
      
      <?php $no=1; $temp=""; 
      foreach ($kr_all as $m) : 
        $mapel_ajar = return_mapel_ajar_by_guru($sk_detail['sk_id'], $m['kr_id'], $t_detail['t_id']);
        $total_mapel_ajar = count($mapel_ajar);
        $beban_tam = return_tamb_by_guru($m['kr_id'], $t_detail['t_id']);

        if($mapel_ajar):

        $st = explode(',',$m['st_nama']);
        if($st[0])
          $st = $st[0];
        else
          $st = "";
        // $mapel_id_dis = explode(",",$m['mapel_id_dis']);
      ?>
        <tr>
          <?php 
            if($beban_tam && !$mapel_ajar){
              $rowspan = '1';
            }else{
              $rowspan = count($mapel_ajar)+1;
            }
          ?>
          
          <td style="border: 1px solid black;" rowspan="<?= $rowspan ?>"><?= $no; ?></td>
          <td style="border: 1px solid black;" rowspan="<?= $rowspan ?>"><?= $m['kr_nama_depan'].' '.$m['kr_nama_belakang'] ?></td>
          <td style="border: 1px solid black;" rowspan="<?= $rowspan ?>"><?= $st; ?></td>
        </tr>
        <!-- CETAK MAPEL dan BEBAN perkelas -->
          <?php 
              $count=0; 
              $total = 0;
              foreach ($mapel_ajar as $a) : ?>
          <tr>
            <td style="border: 1px solid black;"><?= $a['mapel_nama'] ?></td>
            <?php foreach ($kelas_all as $k) : ?>
            <td style="border: 1px solid black;">
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
              <td style="border: 1px solid black;" rowspan="<?= $rowspan-1 ?>">
                <?php 
                  $jam_unit_lain = return_jam_by_guru_kelas_unit_lain($m['kr_id'], $t_detail['t_id'], $sk_detail['sk_id']);
                  if($jam_unit_lain){
                    $total += $jam_unit_lain;
                    echo $jam_unit_lain;
                  }
                ?>
              </td>
              <td style="border: 1px solid black;" rowspan="<?= $rowspan-1 ?>"><?= $beban_tam['beban_tam_jum'] ?></td>
              <td style="border: 1px solid black;" rowspan="<?= $rowspan-1 ?>"><div class="tot_dis"></div></td>
            <?php endif; ?>
          </tr>
          <?php $count++; endforeach; ?>
        <!-- //////////////////////////////// -->
        <div class="tot_temp" rel="<?= $total+$beban_tam['beban_tam_jum'] ?>"></div>
      <?php $no++; 
        endif; 
      endforeach; 
      ?>

      <?php foreach ($kr_all_not_in as $kn) : ?>
        <tr>
          <td style="border: 1px solid black;"><?= $no ?></td>
          <td style="border: 1px solid black;"><?= $kn['kr_nama_depan'].' '.$kn['kr_nama_belakang'] ?></td>
          <td style="border: 1px solid black;"><?= $kn['st_nama'] ?></td>
          <td style="border: 1px solid black;"></td>
          <?php foreach ($kelas_all as $k) : ?>
          <td style="border: 1px solid black;"></td>
          <?php endforeach; ?>
          <td style="border: 1px solid black;"></td>
          <td style="border: 1px solid black;"></td>
          <td style="border: 1px solid black;"><?= $kn['beban_tam_jum'] ?></td>
        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>
  </div>
  <div class="grid-dalam">
    <div>
    <button type="submit" class="btn btn-success btn-user btn-block" id="export_excel">
      Export To Excel
    </button>
    </div>
    <div>
    <input type="button" name="print_rekap" id="print_rekap" class="btn btn-primary btn-block" value="Print">
    </div>
  </div>
  
  
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