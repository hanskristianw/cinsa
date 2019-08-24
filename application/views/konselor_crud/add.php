<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Add Counselor</h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('Konselor_CRUD/proses_add'); ?>">
                            <input type="hidden" name="sk_id" value="<?= $sk_id ?>">
                            <div class="form-group row">
                                <div class="col mb-3 mb-sm-0 ml-2">
                                    <h6><b>Select as Counselor:</b></h6>
                                    <select name="kr_id" id="kr_id" class="form-control">
                                        <?php
                                        $_selected = set_value('kr_id');

                                        foreach ($kr_all as $m) :
                                        if ($_selected == $m['kr_id']) {
                                            $s = "selected";
                                        } else {
                                            $s = "";
                                        }
                                        echo "<option value=" . $m['kr_id'] . " " . $s . ">" . $m['kr_nama_depan'] ." ". $m['kr_nama_belakang']. "</option>";
                                        endforeach
                                        ?>
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