<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Mid and Final Score</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>
            <form class="" action="" method="post">
              <table class="table display compact table-hover dt">
                <thead>
                  <tr>
                    <th rowspan="3">No</th>
                    <th rowspan="3">Nama</th>
                    <th colspan="4">Semester 1</th>
                    <th colspan="4">Semester 2</th>
                  </tr>
                  <tr>
                    <td colspan="2">Cognitive</td>
                    <td colspan="2">Psychomotor</td>
                    <td colspan="2">Cognitive</td>
                    <td colspan="2">Psychomotor</td>
                  </tr>
                  <tr>
                    <td>Mid</td>
                    <td>Final</td>
                    <td>Mid</td>
                    <td>Final</td>
                    <td>Mid</td>
                    <td>Final</td>
                    <td>Mid</td>
                    <td>Final</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($siswa_all as $m) : ?>
                    <tr>
                      <td><?= $m['sis_no_induk']; ?></td>
                      <td><?= $m['sis_nama_depan']." ".$m['sis_nama_bel'][0] ?></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                      <td><input type="number" onfocus='this.select();' required style='width: 47px;' name="" value="0" max="100"></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
              <button type="submit" class="btn btn-success">
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
