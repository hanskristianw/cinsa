<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900"><u><b>CHARACTER LIST</b></u></h1>
              <h1 class="h4 text-gray-900"><u><b><?= $karakter['karakter_nama'] ?></b></u></h1>
              <h5 class="text-gray-900 mb-4">Select School, Character and Subject</h5>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Karakter_CRUD/save_character') ?>" method="POST">
              <div class="form-group row">
                <div class="col-sm mb-sm-0">

                  <input type="hidden" name="karakter_id" id="karakter_id" value="<?= $karakter['karakter_id'] ?>">

                  <select name="sk_id" id="karakter_sk" class="form-control mb-3">
                    <option value="0">Select School</option>
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div id="karakter_detail">
                
              </div>
            </form>
            
            

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
