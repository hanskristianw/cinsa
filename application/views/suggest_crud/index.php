<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5 overflow-auto">
                        <div class="text-center">
                            <h4><u>Kritik dan Saran</u></h4>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" action="<?= base_url('Suggest_CRUD/add') ?>" method="POST">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                    <label for="suggest_to"><b><u>Kepada</u>:</b></label>
                                    <select class="form-control form-control-sm" name="suggest_to" id="">
                                        <option value="1">BPH</option>
                                        <option value="2">Div Pendidikan</option>
                                    </select>
                                </div>
                            </div>
                            <textarea rows="8" cols="50" class="form-control form-control-sm"></textarea>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                    <input type="checkbox">Anonim
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                    <button type="submit" class="btn btn-primary float-right">
                                        Kirim
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>