<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5 overflow-auto">

                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><u>Life Skill Description</u></h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form method="post" action="<?= base_url('cb_crud/set_lifeskill_proses_update'); ?>">
                            <input type="text" name="sk_id" value="<?= $sk_id ?>">
                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center"><b>Moral Behaviour</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1a">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1b">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1c">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2a">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2b">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2c">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center"><b>Emotional Awareness</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center"><b>Spirituality</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 4</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center"><b>Social Skill</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 4</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center"><b>Physical Fitness, Healthful Habit</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-sm btn-success mt-1" id="btn-save">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                        </form>

                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>