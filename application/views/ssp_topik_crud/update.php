<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
            </div>

            <form class="user" id="ssp_topik_add_form" action="<?php echo base_url('SSP_topik_CRUD/proses_update'); ?>" method="POST">
              
              <input type="text" class="form-control mb-3" name="ssp_topik_nama" value="<?= $ssp['ssp_topik_nama']?>" placeholder="Topic Name" required pattern="\S+" title="No space allowed">
              <input type="hidden" value="<?= $ssp['ssp_topik_id'] ?>" name="ssp_id">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="ssp_topik_semester" id="ssp_topik_semester" class="form-control">
                  <?php
                      $_selected = $ssp['ssp_topik_semester'];

                      if ($_selected == 1) {
                          echo '<option value="1" selected>Odd Semester</option>
                          <option value="2">Even Semester</option>';
                      } elseif ($_selected == 2) {
                          echo '<option value="1">Odd Semester</option>
                          <option value="2" selected>Even Semester</option>';
                      }
                      else{
                          echo '<option value="1">Odd Semester</option>
                          <option value="2">Even Semester</option>';
                      }
                  ?>
                  </select>
                </div>
              </div>

              <textarea rows="4" name="ssp_topik_a" class="form-control mt-2" placeholder="Description if A" required><?= $ssp['ssp_topik_a']?></textarea>
              <textarea rows="4" name="ssp_topik_b" class="form-control mt-2" placeholder="Description if B" required><?= $ssp['ssp_topik_b']?></textarea>
              <textarea rows="4" name="ssp_topik_c" class="form-control mt-2" placeholder="Description if C" required><?= $ssp['ssp_topik_c']?></textarea>

              <button type="submit" class="btn btn-primary btn-user btn-block mt-2">
                  Update Topic
              </button>
            </form>

            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>