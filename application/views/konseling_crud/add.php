<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><u>Counseling for <?= $sis['sis_nama_depan'] ?> <?= $sis['sis_nama_bel'] ?></u></h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Konseling_CRUD/proses_add'); ?>">
                            <input type="hidden" name="d_s_id" value="<?= $d_s_id ?>">
                            
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <!-- Jenis pelanggaran -->
                                    <h6><b>Category:</b></h6>
                                    <select name="konseling_kategori_id" id="konseling_kategori_id" class="form-control">
                                        <?php
                                        $_selected = set_value('konseling_kategori_id');

                                        foreach ($kategori as $m) :
                                        if ($_selected == $m['konseling_kategori_id']) {
                                            $s = "selected";
                                        } else {
                                            $s = "";
                                        }
                                        echo "<option value=" . $m['konseling_kategori_id'] . " " . $s . ">" . $m['konseling_kategori_nama'] ."</option>";
                                        endforeach
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="konseling_tanggal"><b><u>Date</u>:</b></label>
                                  <input type="date" name="konseling_tanggal" class="form-control form-control-sm" required>
                              </div>
                            </div>
                            <label for="konseling_alasan"><b><u>Reasons for Counseling</u>:</b></label>
                            <textarea rows="4" name="konseling_alasan" class="form-control mb-2" required></textarea>

                            <label for="konseling_hasil"><b><u>Result</u>:</b></label>
                            <textarea rows="4" name="konseling_hasil" class="form-control mb-2" required></textarea>

                            <label for="konseling_saran"><b><u>Suggestion for Teachers</u>:</b></label>
                            <textarea rows="4" name="konseling_saran" class="form-control mb-2" required></textarea>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Add Counseling Session
                            </button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>