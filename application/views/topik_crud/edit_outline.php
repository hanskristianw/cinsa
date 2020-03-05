<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-4">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mt-2"><u><?= $title ?></u></h1>
                            <h5><?= ucwords(strtolower($mapel_nama)) ?></h5>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show">
                          <button class="close" data-dismiss="alert" type="button">
                              <span>&times;</span>
                          </button>
                          <strong>PERHATIAN:</strong> Edit jenjang hanya dapat dilakukan ketika outline tidak mempunyai detail
                        </div>
                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Topik_CRUD/edit_outline_proses'); ?>">
                          <input type="hidden" name="mapel_outline_id" value="<?= $mo['mapel_outline_id'] ?>">
                          
                          <label for="mapel_outline_nama"><b><u>Deskripsi Outline</u>:</b></label>
                          <textarea rows="4" name="mapel_outline_nama" class="form-control mb-2" required><?= $mo['mapel_outline_nama'] ?></textarea>
                            
                          <label for="mapel_outline_jenj_id"><b><u>Untuk Jenjang</u>:</b></label>
                          <select name="mapel_outline_jenj_id" class="form-control form-control-sm">
                              <?php
                              $_selected = set_value('mapel_outline_jenj_id', $mo['mapel_outline_jenj_id']);

                              foreach ($jenj_all as $m) :
                              if ($_selected == $m['jenj_id']) {
                                  $s = "selected";
                              } else {
                                  $s = "";
                              }
                              echo "<option value=" . $m['jenj_id'] . " " . $s . ">" . $m['jenj_nama'] . "</option>";
                              endforeach
                              ?>
                          </select>
                          
                          <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
                            Update
                          </button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>