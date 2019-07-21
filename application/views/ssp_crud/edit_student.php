<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                
                <div class="col-lg-6 p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mt-4 mb-4"><?= $title ?></h1>
                    </div>

                        <div class="form-group row">
                            <div class="col-sm mb-sm-0">
                                <select name="kelas_ssp" id="kelas_ssp" class="form-control">
                                    <option value="0">Select Class</option>
                                    <?php foreach ($kelas_all as $m) : ?>
                                    <option value='<?=$m['kelas_id']?>'>
                                        <?= $m['kelas_nama'] ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div id="siswaKelasAjax">
                        
                        </div>
                </div>

                <div class="col-lg-6 p-5">
                
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mt-4 mb-4">Student in <?= $ssp_nama ?></h1>
                </div>
                <div class="mb-3 pr-3 pl-3 sspMsg"><?= $this->session->flashdata('message'); ?></div>
                <input type="hidden" value = <?= $ssp_id ?> id="sspInputId">
                <div class="col-sm mb-3 mb-sm-0 table-responsive">
                    
                    <div id="siswaSSPAjax">
                    
                    </div>
                </div>
            </div>
                
            </div>
        </div>
    </div>

</div>