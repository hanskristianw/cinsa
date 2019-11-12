<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><u>Add Unit</u></h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Sekolah_CRUD/add'); ?>">
                            <div class="form-group row">
                                <div class="col-sm mb-3 mb-sm-0">
                                    <label for="sk_nama"><b><u>Name</u>:</b></label>
                                    <input type="text" class="form-control" id="sk_nama" name="sk_nama" required>
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <label for="sk_nickname"><b><u>Nickname (Senior High/Junior High)</u>:</b></label>
                                    <input type="text" class="form-control" id="sk_nickname" name="sk_nickname" required >
                                </div>
                                <div class="col-sm mb-3 mb-sm-0">
                                    <label for="sk_type"><b><u>Type</u>:</b></label>
                                    <select name="sk_type" class="form-control">
                                        <option value="0">School</option>
                                        <option value="1">Management</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Add
                            </button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>