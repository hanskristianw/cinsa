<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center mt-3">
              <div class="col-sm mb-sm-0">
                <h1 class="h4 text-gray-900">Topic List</h1>
                <button class="btn btn-primary mb-3 tambah_topik_ssp">Add New Topic</button>
              </div>
              
              <?= $this->session->flashdata('message'); ?>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="ssp_topik_ssp_id" id="ssp_topik_ssp_id" class="form-control ssp_topik_ssp_id">
                    <option value="0">Select SSP</option>
                    <?php foreach ($ssp_all as $m) : ?>
                      <option value='<?= $m['ssp_id'] ?>'>
                        <?= "(".$m['t_nama'].") ".$m['ssp_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
            </div>
            <div id="sspTabel"></div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="card o-hidden border-0 shadow-lg my-5 page_tambah_topik_ssp">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Add Topic</h1>
            </div>
            
            <form class="user" id="ssp_topik_add_form" action="<?php echo base_url('SSP_topik_CRUD/add'); ?>" method="POST">

              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="ssp_topik_ssp_id" id="ssp_topik_ssp_id" class="form-control">
                    <?php foreach ($ssp_all as $m) : ?>
                      <option value='<?= $m['ssp_id'] ?>'>
                        <?= "(".$m['t_nama'].") ".$m['ssp_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="ssp_topik_semester" id="ssp_topik_semester" class="form-control">
                      <option value="1">Odd Semester</option>
                      <option value="2">Even Semester</option>
                  </select>
                </div>
              </div>

              <input type="text" class="form-control" name="ssp_topik_nama" placeholder="Topic Name" required pattern="\S+" title="No space allowed">

              <textarea rows="4" name="ssp_topik_a" class="form-control mt-2" placeholder="Description if A" required></textarea>
              <textarea rows="4" name="ssp_topik_b" class="form-control mt-2" placeholder="Description if B" required></textarea>
              <textarea rows="4" name="ssp_topik_c" class="form-control mt-2" placeholder="Description if C" required></textarea>
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <button type="submit" class="btn btn-primary btn-user btn-block mt-2">
                      Insert Topic
                  </button>
                </div>
                <div class="col-sm mb-sm-0">
                  <button class="btn btn-danger btn-user btn-block mt-2 close_page_tambah_topik_ssp">
                      Cancel
                  </button>
                </div>
              </div>
            </form>
            <hr>
            <div id="myDiv"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  

</div>
