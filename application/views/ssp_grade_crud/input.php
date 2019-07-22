<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h4 class="h4 text-gray-900"><b><u>SSP GRADE (<?= $ssp_all['ssp_topik_nama'] ?>)</u></b></h4>
            </div>

            <?php echo '<div class="alert alert-danger alert-dismissible fade show">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>ALERT:</strong> No grade found, use SAVE BUTTON below to save grade
                </div>'; ?>
            
            <div id="notif"></div>

            <form class="" action="<?= base_url('SSP_grade_CRUD/save_input'); ?>" method="post" id="formsspgrade" >
            
              <input type="hidden" value="<?= $ssp_topik_id ?>" name="ssp_topik_id">
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Score</th>
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
                      <td>
                        <?= $m['kelas_nama']; ?>
                      </td>
                      <td>
                        <select name="ssp_nilai_angka[]" id="ssp_nilai_angka" class="form-control">
                          <option value="4">A</option>
                          <option value="3">B</option>
                          <option value="2">C</option>
                          <option value="1">D</option>
                        </select>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <button type="submit" class="btn btn-success mt-2" id="btn-save">
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
