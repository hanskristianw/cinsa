<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Students List</u></h1>
            </div>
            
            <?= $this->session->flashdata('message'); ?>
            
            <a href="<?= base_url('siswa_crud/add') ?>" class="btn btn-sm btn-primary mb-3">Add New Student</a>

            <table class="table table-sm table-bordered display compact table-hover dt" style="font-size:14px;">
              <thead>
                <tr class="bg-dark text-white text-center">
                  <th class="p-3">Name</th>
                  <th style='width: 50px;' class="p-3">Reg Number</th>
                  <th class="p-3">NISN</th>
                  <th class="p-3">Gender</th>
                  <th class="p-3">Religion</th>
                  <th class="p-3">Year</th>
                  <th class="p-3">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($sis_all as $m) : ?>
                  <tr>
                    <td><?= $m['sis_nama_depan'] ?> <?= $m['sis_nama_bel'] ?></td>
                    <td><?= $m['sis_no_induk'] ?></td>
                    <td><?= $m['sis_nisn'] ?></td>
                    <td>
                      <?php 
                        if($m['sis_jk'] == "1"){
                          echo "Male";
                        }else{
                          echo "Female";
                        }
                      
                      ?>
                    
                    </td>
                    <td><?= $m['agama_nama'] ?></td>
                    <td><?= $m['t_nama'] ?></td>
                    <td>
                      <div class="form-group row m-0" style="padding: 0px 0px 0px 0px;">
                        <form class="" action="<?= base_url('Siswa_CRUD/update') ?>" method="get">
                          <input type="hidden" name="_id" value=<?= $m['sis_id'] ?>>
                          <button type="submit" class="badge badge-warning">
                            Edit
                          </button>
                        </form>
                        <!-- <form class="" action="" method="post">
                          <input type="hidden" name="" method="get" value=<?= $m['sis_id'] ?>>
                          <button type="submit" class="badge badge-danger">
                            Delete
                          </button>
                        </form> -->
                      </div>
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