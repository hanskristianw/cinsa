<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select Year, Class and Students</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="Komen_CRUD/input" method="POST">

              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="t" id="t" class="form-control">
                    <option value="0">Select Year</option>
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?= $m['t_id'] ?>'>
                        <?= $m['t_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div id="kelas_ajax">
              
              </div>
              <div id="siswa_ajax">
              
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
