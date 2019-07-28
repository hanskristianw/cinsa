<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select Year, Class and Student</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="Report_CRUD/show" method="POST">

              <select name="t_tatib" id="t_tatib" class="form-control mb-2">
                <option value="0">Select Year</option>
                <?php foreach ($t_all as $m) : ?>
                  <option value='<?= $m['t_id'] ?>'>
                    <?= $m['t_nama']; ?>
                  </option>
                <?php endforeach ?>
              </select>
              <div id="kelas_tatib_ajax">
              
              </div>
              <div id="siswa_tatib_ajax">
              
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
