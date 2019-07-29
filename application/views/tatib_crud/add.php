<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><u><?= $sis['sis_nama_depan'] ?> <?= $sis['sis_nama_bel'] ?></u></h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Tatib_CRUD/add_proses'); ?>">
                            <input type="hidden" name="d_s_id" value="<?= $d_s_id ?>">
                            
                            <label><b><u>Type</u>:</b></label>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <!-- Jenis pelanggaran -->
                                    <select name="langgar_id" id="langgar_id" class="form-control">
                                      <option value="1">Infraction</option>
                                      <option value="2">Achievement</option>
                                      <option value="3">Counseling</option>
                                    </select>
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                  <!-- Public/Private -->
                                  <select name="langgar_jenis" id="langgar_jenis" class="form-control">
                                    <option value="1">Private (Only Visible to Counselor)</option>
                                    <option value="2">Public (Visible to anyone)</option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm mb-3 mb-sm-0">
                                  <label for="tatib_tgl"><b><u>Date</u>:</b></label>
                                  <input type="date" name="tatib_tgl" class="form-control form-control-sm" required>
                              </div>
                            </div>

                            <label for="tatib_notes"><b><u>Notes</u>:</b></label>
                            <textarea rows="4" name="tatib_notes" class="form-control mb-2"></textarea>

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