<style>
.grid-container {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 120px;
  padding-top: 50px;
}


.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.box2{
  /*align-self:start;*/
  grid-template-columns: 50% 50%;
}
</style>


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?> <?= $mapel_nama ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
  
    <table class="table table-sm table-bordered mt-4" style="font-size:14px;">
      <thead>
        <tr class="bg-dark text-white">
          <th style="width:70px;" class="pt-4 pb-4 text-center">Tanggal</th>
          <th class="pt-4 pb-4 text-center">Outline</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $kelas = ""; 
        foreach($lapor as $l): 
          if($kelas != $l['kelas_nama'])
            echo "<tr class='text-center bg-primary text-white'><td colspan='2'>".$l['kelas_nama'].' - '.$l['sk_nama']."</td></tr>";
        ?>
          <tr>
            <td><?= date("d/m", strtotime($l['jurnal_tgl'])) ?></td>
            <td><?= $l['mapel_outline_nama'] ?></td>
          </tr>
        <?php 
          $kelas = $l['kelas_nama']; 
        endforeach; 
        ?>
      </tbody>
    </table>

  </div>
</div>