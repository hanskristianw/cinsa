<div class="container">

  
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <?= $this->session->flashdata('message'); ?>
            
            <?php
              for($i=0;$i<count($sis_arr);$i++):
                $nomor = 1;
                $siswa = return_raport_mid($sis_arr[$i]);
            ?>
                
              <table style='margin-top: 5px;' class='rapot'>
                <thead>
                    <tr>
                        <th rowspan='4'>NO.</th>
                        <th rowspan='4' style='width: 190px; padding: 0px 0px 0px 5px;'>SUBJECT</th>
                        <th rowspan='4' style='width: 60px; padding: 0px 0px 0px 5px;'>PASSING <br>GRADE</th>
                        <th colspan='15' style='padding: 0px 0px 0px 5px;'>PROGRESS REPORT</th>
                    </tr>
                    <tr>
                        <th colspan='12'>FORMATIVE</th>
                        <th rowspan='3' style='width: 80px;'>AFFECTIVE</th>
                        <th rowspan='2' colspan='2'>SUMMATIVE</th>
                    </tr>
                    <tr>
                        <th colspan='6'>COGNITIVE</th>
                        <th colspan='6'>PSYCHOMOTOR</th>
                    </tr>
                    <tr>
                        <th>Q1</th>
                        <th>A1</th>
                        <th>T1</th>
                        <th>Q2</th>
                        <th>A2</th>
                        <th>T2</th>
                        <th>Q1</th>
                        <th>A1</th>
                        <th>T1</th>
                        <th>Q2</th>
                        <th>A2</th>
                        <th>T2</th>
                        <th>COG</th>
                        <th>PSY</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($siswa as $m) : ?>
                    <tr>
                      <td class='nomor'><?= $nomor ?></td>
                      <td style='padding: 0px 0px 0px 5px; margin: 0px;'><?= $m['mapel_nama'] ?></td>
                      <td class='kkm' style='padding: 0px 0px 0px 5px; margin: 0px;'><?= $m['mapel_kkm'] ?></td>
                      <?= returnQATastd($m['kq'],$m['ka'],$m['kt'],$m['pq'],$m['pa'],$m['pt'],$m['uj_mid1_kog'],$m['uj_mid1_psi']); ?>
                    </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
              
            <?php 
              $nomor++;
              endfor;
            ?>
            
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
