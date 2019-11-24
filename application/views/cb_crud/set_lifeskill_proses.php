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
                            <input type="hidden" name="sk_id" value="<?= $sk_id ?>">
                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center bg-secondary text-white p-3"><b>Moral Behaviour</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1" value="<?= $l['mb_ind_1'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1a" value="<?= $l['mb_ind_1a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1b" value="<?= $l['mb_ind_1b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_1c" value="<?= $l['mb_ind_1c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2" value="<?= $l['mb_ind_2'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2a" value="<?= $l['mb_ind_2a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2b" value="<?= $l['mb_ind_2b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="mb_ind_2c" value="<?= $l['mb_ind_2c'] ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center bg-secondary text-white p-3"><b>Emotional Awareness</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_1" value="<?= $l['emo_ind_1'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_1a" value="<?= $l['emo_ind_1a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_1b" value="<?= $l['emo_ind_1b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_1c" value="<?= $l['emo_ind_1c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_2" value="<?= $l['emo_ind_2'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_2a" value="<?= $l['emo_ind_2a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_2b" value="<?= $l['emo_ind_2b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_2c" value="<?= $l['emo_ind_2c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_3" value="<?= $l['emo_ind_3'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_3a" value="<?= $l['emo_ind_3a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_3b" value="<?= $l['emo_ind_3b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="emo_ind_3c" value="<?= $l['emo_ind_3c'] ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center bg-secondary text-white p-3"><b>Spirituality</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_1" value="<?= $l['spr_ind_1'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_1a" value="<?= $l['spr_ind_1a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_1b" value="<?= $l['spr_ind_1b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_1c" value="<?= $l['spr_ind_1c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_2" value="<?= $l['spr_ind_2'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_2a" value="<?= $l['spr_ind_2a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_2b" value="<?= $l['spr_ind_2b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_2c" value="<?= $l['spr_ind_2c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_3" value="<?= $l['spr_ind_3'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_3a" value="<?= $l['spr_ind_3a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_3b" value="<?= $l['spr_ind_3b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_3c" value="<?= $l['spr_ind_3c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 4</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_4" value="<?= $l['spr_ind_4'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_4a" value="<?= $l['spr_ind_4a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_4b" value="<?= $l['spr_ind_4b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="spr_ind_4c" value="<?= $l['spr_ind_4c'] ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center bg-secondary text-white p-3"><b>Social Skill</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_1" value="<?= $l['ss_ind_1'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_1a" value="<?= $l['ss_ind_1a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_1b" value="<?= $l['ss_ind_1b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_1c" value="<?= $l['ss_ind_1c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_2" value="<?= $l['ss_ind_2'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_2a" value="<?= $l['ss_ind_2a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_2b" value="<?= $l['ss_ind_2b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_2c" value="<?= $l['ss_ind_2c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_3" value="<?= $l['ss_ind_3'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_3a" value="<?= $l['ss_ind_3a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_3b" value="<?= $l['ss_ind_3b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_3c" value="<?= $l['ss_ind_3c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 4</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_4" value="<?= $l['ss_ind_4'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_4a" value="<?= $l['ss_ind_4a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_4b" value="<?= $l['ss_ind_4b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="ss_ind_4c" value="<?= $l['ss_ind_4c'] ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered" style='font-size:11px;'>
                                <thead>
                                    <tr>
                                        <td colspan="4" class="text-center bg-secondary text-white p-3"><b>Physical Fitness, Healthful Habit</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Indicator 1</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_1" value="<?= $l['pf_ind_1'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_1a" value="<?= $l['pf_ind_1a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_1b" value="<?= $l['pf_ind_1b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_1c" value="<?= $l['pf_ind_1c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 2</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_2" value="<?= $l['pf_ind_2'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_2a" value="<?= $l['pf_ind_2a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_2b" value="<?= $l['pf_ind_2b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_2c" value="<?= $l['pf_ind_2c'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Indicator 3</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_3" value="<?= $l['pf_ind_3'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc a</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_3a" value="<?= $l['pf_ind_3a'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc b</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_3b" value="<?= $l['pf_ind_3b'] ?>">
                                        </td>
                                        <td>
                                            <label>Desc c</label>
                                            <input type="text" class="form-control form-control-sm" name="pf_ind_3c" value="<?= $l['pf_ind_3c'] ?>">
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