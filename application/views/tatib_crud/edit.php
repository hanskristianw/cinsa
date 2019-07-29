<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><u>Edit</u></h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Tatib_CRUD/edit_proses'); ?>">
                            <input type="hidden" name="tatib_id" value="<?= $tatib_update['tatib_id'] ?>">
                            
                            <label><b><u>Type</u>:</b></label>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <!-- Jenis pelanggaran -->
                                    <?php
                                      $langgar = $tatib_update['tatib_langgar'];
                                    ?>
                                    <select name="langgar_id" id="langgar_id" class="form-control">
                                      <?php 
                                        if($langgar==1)
                                          echo'<option value="1" selected>Infraction</option>';
                                        else
                                          echo'<option value="1">Infraction</option>';
                                        if($langgar==2)
                                          echo'<option value="2" selected>Achievement</option>';
                                        else
                                          echo'<option value="2">Achievement</option>';
                                        if($langgar==3)
                                          echo'<option value="3" selected>Counseling</option>';
                                        else
                                          echo'<option value="3">Counseling</option>';
                                      ?>
                                    </select>
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                  <!-- Public/Private -->
                                  <?php
                                    $jenis = $tatib_update['tatib_jenis'];
                                  ?>
                                  <select name="langgar_jenis" id="langgar_jenis" class="form-control">
                                    <?php 
                                      if($jenis==1)
                                        echo'<option value="1" selected>Private (Only Visible to Counselor)</option>';
                                      else
                                        echo'<option value="1">Private (Only Visible to Counselor)</option>';
                                      if($jenis==2)
                                        echo'<option value="2" selected>Public (Visible to anyone)</option>';
                                      else
                                        echo'<option value="2">Public (Visible to anyone)</option>';
                                    ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm mb-3 mb-sm-0">
                                  <label for="tatib_tgl"><b><u>Date</u>:</b></label>
                                  <input type="date" name="tatib_tgl" class="form-control form-control-sm" required value="<?= $tatib_update['tatib_tanggal'] ?>">
                              </div>
                            </div>

                            <label for="tatib_notes"><b><u>Notes</u>:</b></label>
                            <textarea rows="4" name="tatib_notes" class="form-control mb-2"><?= $tatib_update['tatib_notes'] ?></textarea>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Insert
                            </button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>