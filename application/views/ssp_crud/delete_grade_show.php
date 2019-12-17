<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Grade List</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

              <table class="table table-hover table-sm" style='font-size:13px;'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Grade</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($siswa_all as $m) :
                  ?>
                    <tr>
                      <td>
                        <?= $m['sis_no_induk']; ?>
                      </td>
                      <td>
                        <?php
                          echo $m['sis_nama_depan']." ".$m['sis_nama_bel'];
                        ?>
                      </td>
                      <td>
                        <?= $m['kelas_nama']; ?>
                      </td>
                      <td>
                        <?php 
                          if($m['ssp_nilai_angka']==4){
                            echo "A";
                          }elseif($m['ssp_nilai_angka']==3){
                            echo "B";
                          }elseif($m['ssp_nilai_angka']==2){
                            echo "C";
                          }elseif($m['ssp_nilai_angka']==1){
                            echo "D";
                          }
                        ?>
                      </td>
                      <td>
                        <form action="<?= base_url('SSP_CRUD/delete_grade_proses'); ?>" method="post">
                          <input type="hidden" value="<?= $m['ssp_nilai_id']; ?>" name="ssp_nilai_id">
                          <button type="submit" class="badge badge-danger">
                            Delete
                          </button>
                        </form>
                      </td>
                     </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
