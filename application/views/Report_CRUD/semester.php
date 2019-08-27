<div class="container">

  
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div id="print_area">
              <h1 class="text-center">UNDER CONSTRUCTION</h1>
            <?php
            
              //var_dump($sis_arr);
              for($i=0;$i<count($sis_arr);$i++):

                if(isset($siswa[0]['sis_nama_depan'])):
            ?>
              <hr style="height:5px; visibility:hidden;" />

            
              <p style="page-break-after: always;">&nbsp;</p>

            <?php 
                $nomor++;
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
