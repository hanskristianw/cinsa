<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900"><b><u>CB GRADE <?= $kelas['kelas_nama'] ?></u></b></h4>
              <h4 class="h4 text-gray-900"><b><u><?= $topik_cb_nama['topik_cb_nama'] ?></u></b></h4>
            </div>

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>ALERT:</strong> No grade found, use SAVE BUTTON below to save grade
                </div>'; ?>

            <form class="" action="<?= base_url('CB_CRUD/save_input'); ?>" method="post">
              <input type="hidden" name="nilai_cb_topik_cb_id" value="<?= $topik_cb_id ?>">
              <input type="hidden" name="kelas_id" value="<?= $kelas['kelas_id'] ?>">
              <label for="nilai_cb_jum"><b><u>Total Indicator</u>:</b></label>
              <select name="nilai_cb_jum" class="form-control-sm mt-4 mb-4" id="nilai_cb_jum">
                <?php 
                  $_selected = 5;
                  for($i=5;$i>0;$i--){
                    if($_selected == $i){
                      $s = "selected";
                    }else{
                      $s = "";
                    }
                    echo "<option value=" . $i . " " . $s . ">" . $i . "</option>";
                  }
                ?>
              </select>
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th class="ind1">Ind 1</th>
                    <th class="ind2">Ind 2</th>
                    <th class="ind3">Ind 3</th>
                    <th class="ind4">Ind 4</th>
                    <th class="ind5">Ind 5</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                    $nomor = 1;
                    function cetak_opt($nama, $class, $dipilih){
                      $afek_nilai = ["A","B","C","D","E"];
                      $opt = "<select name=".$nama." class=".$class.">";
                      $_s = "selected";
                      for($i=4;$i>=0;$i--){
                        if($dipilih == $i){
                          $opt .= "<option value='".($i)."' ".$_s.">".$afek_nilai[4-$i]."</option>";
                        }else{
                          $opt .= "<option value='".($i)."'>".$afek_nilai[4-$i]."</option>";
                        }
                      }
                      $opt .= "</select>";
                      echo $opt;
                    }
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
                      <td class="ind1"><?php cetak_opt("nilai_cb1[]","nilai_cb1",4); ?></td>
                      <td class="ind2"><?php cetak_opt("nilai_cb2[]","nilai_cb2",4); ?></td>
                      <td class="ind3"><?php cetak_opt("nilai_cb3[]","nilai_cb3",4); ?></td>
                      <td class="ind4"><?php cetak_opt("nilai_cb4[]","nilai_cb4",4); ?></td>
                      <td class="ind5"><?php cetak_opt("nilai_cb5[]","nilai_cb5",4); ?></td>
                    </tr>
                    <?php $nomor++;  endforeach; ?>
                </tbody>
              </table>
              <button type="submit" class="btn btn-success mt-2">
                  <i class="fa fa-save"></i>
                  Save All
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
$(document).ready(function () {

  $('#nilai_cb_jum').change(function () {
    var jum = parseInt($(this).val());
    hideCustom("ind",jum+1,5);
  });


  function hideCustom(nama, awal, jum){
    
    setNol('nilai_cb',awal,jum);
    
    for(var i=1;i<=awal-1;i++){
      $('.'+nama+i).show();
    }
    
    setA('nilai_cb',1,awal-1);

    for(var i=awal;i<=jum;i++){
      $('.'+nama+i).hide();
    }
  }

  function setNol(nama, awal, akhir){
    for(var i=awal;i<=akhir;i++){
      $('.'+nama+i).val(0);
    }
  }

  function setA(nama, awal, akhir){
    for(var i=awal;i<=akhir;i++){
      if($('.'+nama+i).val()==0){
        $('.'+nama+i).val(4);
      }
    }
  }

});
</script>