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
.grid-inside {
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:3px;
}
table.cus{
    border: 0.5px solid black;
}
.cus th{
  border: 0.1px solid black;
  text-align:center;
  padding: 3px;
}
.cus td{
  border: 0.1px solid black;
  text-align:center;
  padding: 3px;
}
</style>

<?php
  function format_history($nilai){
    $nil = explode(",", $nilai);

    $f = "";
    for($i=0;$i<count($nil);$i++){
      if($nil[$i] != "0"){
        if($i != 0){
          if($nil[$i] != $nil[$i-1] && $nil[$i]!= ""){
            $f .= $nil[$i]."-";
          }
        }else{
          if($nil[$i] != ""){
            $f .= $nil[$i]."-";
          }
        }
      }
    }
    
    return mb_substr($f, 0, -1);
  }
?>

<div class="grid-container">
  <div class="text-center">
    <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
  </div>
  

  <?= $this->session->flashdata('message'); ?>

  <div id="print_area">
  <?php foreach($kelas_all as $n): 
    $siswa = show_siswa_by_kelas($n['kelas_id']);

    $mapel_ajar = show_mapel_header_summary_order_by_mapel_urutan($n['kelas_id']);

    //var_dump($mapel_ajar);
  ?>

    <h6><u><b><?= $n['kelas_nama'] ?></b></u></h6>
    <table class="cus table-hover" style="font-size:10px;">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Sem</th>
          <th colspan="2">Jenis</th>
        <?php foreach($mapel_ajar as $m) : ?>
          <th style="width: 70px;"><?= $m['mapel_nama'] ?></th>
        <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
      <?php 
        foreach($siswa as $o) :
      ?>
        <tr>
          <td rowspan="8" style="text-align: center; width: 30px; padding: 3px 3px 3px 3px;"><?= $o['sis_no_induk'] ?></td>
          <td rowspan="8" style="text-align: center; padding: 3px 3px 3px 3px;"><?= $o['sis_nama_depan']." ".$o['sis_nama_bel'] ?></td>
          <td rowspan="4">1</td>
          <td rowspan="2">Kog</td>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UTS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_mid1_kog_log']) ?></td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UAS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_fin1_kog_log']) ?></td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <td rowspan="2">Psy</td>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UTS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_mid1_psi_log']) ?></td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UAS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_fin1_psi_log']) ?></td>
          <?php endforeach; ?>
        </tr>
        <!-- SEMESTER 2 -->
        <tr>
          <td rowspan="4">2</td>
          <td rowspan="2">Kog</td>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UTS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_mid2_kog_log']) ?></td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UAS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_fin2_kog_log']) ?></td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <td rowspan="2">Psy</td>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UTS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_mid2_psi_log']) ?></td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <td style="text-align: center; padding: 3px 3px 3px 3px;">UAS</td>
          <?php foreach($mapel_ajar as $m) : 
            $nilai = return_history_nilai($o['d_s_id'], $m['mapel_id']);
          ?>
            <td><?= format_history($nilai['uj_fin2_psi_log']) ?></td>
          <?php endforeach; ?>
        </tr>
      <?php   
        endforeach;
      ?>
      </tbody>
    </table>
    
    <br>
  <?php endforeach;?>
  </div>
  <div class="grid-inside">
    <div>
      <input type="button" name="export_excel" id="export_excel" class="btn btn-success btn-block" value="Export To Excel">
    </div>
    <div>
      <input type="button" name="print_rekap" id="print_rekap" class="btn btn-primary btn-block" value="Print">
    </div>
  </div>

</div>
