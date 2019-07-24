<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select Subject</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>
            <form method="post" action="topik_CRUD/add">
              <select name="topik_mapel" id="topik_mapel" class="form-control">
                <option value="0">SELECT SUBJECT</option>
                <?php
                  foreach($mapel_all as $m) :
                    echo "<option value=".$m['mapel_id'].">".$m['mapel_nama']." - ".$m['sk_nama']."</option>";
                  endforeach
                ?>
              </select>
              <div id="sub_topik_crud">
                <button type="submit" class="btn btn-primary btn-user mt-4">
                  Add Topic
                </button>
              </div>
            </form>

            <div id="topik_mapel_ajax">
            
            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
