<div class="container">

  
  <div class="card o-hidden border-0 shadow-lg">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <br>
            <div id="print_area">
            <?php
              $tanggal_arr = explode('-', $tanggal);

              $tahun = $tanggal_arr[0];
              $bulan = return_nama_bulan($tanggal_arr[1]);
              $tanggal = $tanggal_arr[2];
              //var_dump($kr['kr_nama_depan']);
              for($i=0;$i<count($sis_arr);$i++):
                
                $siswa = return_konseling_report($sis_arr[$i]);


                if(isset($siswa[0]['sis_nama_depan'])):
                  
                //var_dump($siswa);
            ?>
              <hr style="height:5px; visibility:hidden;" />
              <div style="font-size:20px; font-weight:550; text-align:center;">STUDENT'S COUNSELING REPORT</div>
              <br><br>
              
              <table class="rapot_tabel">
                <tr>
                  <td>1. Student's Name</td>
                  <td>: <?= $siswa[0]['sis_nama_depan'].' '.$siswa[0]['sis_nama_bel'] ?></td>
                </tr>
                <tr>
                  <td>2. Class</td>
                  <td>: <?= $siswa[0]['kelas_nama'] ?></td>
                </tr>
                <tr>
                  <td>3. Counseling Process</td>
                  <td></td>
                </tr>
              </table>
              <br>
                <?php foreach ($siswa as $m) : ?>
                  <table class="rapot">
                    <tr>
                      <th>Date</th>
                      <th>Reasons for Counseling</th>
                      <th>Problem Category</th>
                      <th>Counseling Results and Student's<br>Commitment</th>
                    </tr>
                    <tr>
                      <td style='padding: 0px 0px 0px 5px;'><?= $m['konseling_tanggal'] ?></td>
                      <td style='padding: 0px 0px 0px 5px;'><?= $m['konseling_alasan'] ?></td>
                      <td style='padding: 0px 0px 0px 5px;'><?= $m['konseling_kategori_nama'] ?></td>
                      <td style='padding: 0px 0px 0px 5px;'><?= $m['konseling_hasil'] ?></td>
                    </tr>
                  </table>
                  <br>
                <?php endforeach ?>
              <br>
              <?php
                $gelar_belakang = "";
                if($kr['kr_gelar_belakang']!=""){
                  $gelar_belakang = ".,".$kr['kr_gelar_belakang'];
                }
              ?>
              <p class='alignright_bawah'>Surabaya, <?= $bulan.' '.$tanggal.', '.$tahun ?><br>
              <br>School Counselor<br><br><br><br><b>(<?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'].$gelar_belakang ?>)</b></p>
              
              <div style='clear: both;'></div>
              <p style="page-break-after: always;">&nbsp;</p>

            <?php 
                endif;
              endfor;
            ?>
            </div>
            <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success" value="Print">
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
