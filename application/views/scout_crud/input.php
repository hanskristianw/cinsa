<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900 mb-3"><b><u>Scout Grade <?= $siswa_all[0]['kelas_nama'] ?></u></b></h4>
            </div>

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>INFO:</strong> Press SAVE button below
                </div>';

                function cetak_opt($nama, $dipilih){
                  $afek_nilai = ["A","B","C","D"];
                  $opt = "<select name=".$nama.">";
                  $_s = "selected";
                  for($i=4;$i>=1;$i--){
                    if($dipilih == $i){
                      $opt .= "<option value='".($i)."' ".$_s.">".$afek_nilai[4-$i]."</option>";
                    }else{
                      $opt .= "<option value='".($i)."'>".$afek_nilai[4-$i]."</option>";
                    }
                  }
                  $opt .= "</select>";
                  echo $opt;
                }

            ?>

            <div id="notif"></div>

            <form class="" action="<?= base_url('Scout_CRUD/save_input'); ?>" method="post">
              <table class="table table-bordered table-hover table-sm mr-5">
                <thead>
                  <tr>
                    <th>Reg Num</th>
                    <th>Name</th>
                    <th class="text-center">Grade<br>Odd Semester</th>
                    <th class="text-center">Grade<br>Even Semester</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    foreach ($siswa_all as $m) :
                  ?>

                    <tr>
                      <td>
                        <input type="hidden" value="<?= $m['d_s_id']; ?>" name="d_s_id[]">
                        <?= $m['sis_no_induk']; ?>
                      </td>
                      <td>
                        <?php
                          if($m['sis_nama_bel']){
                            $bel = $m['sis_nama_bel'][0];
                          }else{
                            $bel = "";
                          }
                          echo $m['sis_nama_depan']." ".$bel;
                        ?>
                      </td>

                      <td class="text-center">
                        <!-- NILAI -->
                        <?php cetak_opt("d_s_scout_nilai[]",$m['d_s_scout_nilai']); ?>
                      </td>
                      <td class="text-center">
                        <!-- NILAI -->
                        <?php cetak_opt("d_s_scout_nilai2[]",$m['d_s_scout_nilai2']); ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <button type="submit" class="btn btn-success mt-2" id="btn-save">
                  <i class="fa fa-save"></i>
                  Save
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
