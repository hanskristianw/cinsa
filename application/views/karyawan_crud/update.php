<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
            <div class="p-5">
                <div class="text-center">
                    <h3 class="text-gray-900 mb-4"><u><?= $title ?></u></h1>
                </div>

                <?php
                    $pendidikan = ["SD","SMP","SMA","S1","S2","S3"];
                    
                    $marital = ["single","married","others"];
                ?>
                
                <form class="user" method="post" action="<?php echo base_url('Karyawan_CRUD/update'); ?>">
                    
                    <h4 class="text-danger mb-3"><u>REQUIRED FIELD</u></h4>
                    <input type="hidden" class="_id" name="_id" value="<?= set_value('_id',$kr_update['kr_id']); ?>">
                    
                    <input type="hidden" name="is_update" value="1">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_nama_depan"><b><u>First Name</u>:</b></label>
                            <input type="text" class="form-control" id="kr_nama_depan" name="kr_nama_depan" value="<?= set_value('kr_nama_depan',$kr_update['kr_nama_depan']); ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="kr_nama_belakang"><b><u>Last Name</u>:</b></label>
                            <input type="text" class="form-control" id="kr_nama_belakang" name="kr_nama_belakang" value="<?= set_value('kr_nama_belakang',$kr_update['kr_nama_belakang']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label for="kr_jabatan"><b><u>Position</u>:</b></label>
                            <select name="kr_jabatan_id" id="kr_jabatan_id" class="form-control">
                                <?php
                                    $_selected = set_value('kr_jabatan_id',$kr_update['kr_jabatan_id']);
                                    
                                    foreach($jabatan_all as $m) :
                                        if($_selected == $m['jabatan_id']){
                                            $s = "selected";
                                        }
                                        else{
                                            $s = "";
                                        }
                                        if($m['jabatan_id']!=1){
                                            echo "<option value=".$m['jabatan_id']." ".$s.">".$m['jabatan_nama']."</option>";
                                        }
                                    endforeach
                                ?>
                            </select>
                            
                            <label for="sk" class="mt-3"><b><u>Unit</u>:</b></label>
                            <select name="kr_sk_id" id="kr_sk_id" class="form-control">
                                <?php
                                    $_selected = set_value('kr_sk_id',$kr_update['kr_sk_id']);
                                    
                                    foreach($sk_all as $m) :
                                        if($_selected == $m['sk_id']){
                                            $s = "selected";
                                        }
                                        else{
                                            $s = "";
                                        }
                                        echo "<option value=".$m['sk_id']." ".$s.">".$m['sk_nama']."</option>";
                                    endforeach
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-sm-6">
                            
                            <label for="st" style='display: block;'><b><u>History Status</u>:</b></label>
                            <div class="history_ajax"></div>
                        </div>
                    </div>

                    <div style='height: 20px;'></div>
                    <h4 class="text-success mb-3 mt-4"><u>ADDITIONAL INFORMATION (OPTIONAL)</u></h4>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_gelar_depan"><b><u>First Name Title (Dr, Prof)</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_gelar_depan" name="kr_gelar_depan" value="<?= $kr_update['kr_gelar_depan'] ?>">
                            
                            <label for="kr_ktp"><b><u>ID number</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_ktp" name="kr_ktp" value="<?= $kr_update['kr_ktp'] ?>">

                            <label for="kr_alamat_ktp"><b><u>Address Based On ID</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_alamat_ktp" name="kr_alamat_ktp" value="<?= $kr_update['kr_alamat_ktp'] ?>">
                            
                            <label for="kr_alamat_tinggal"><b><u>Current Address</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_alamat_tinggal" name="kr_alamat_tinggal" value="<?= $kr_update['kr_alamat_tinggal'] ?>">

                            <div class="form-group row mt-4">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="kr_pendidikan_skrng"><b><u>Current Education</u>:</b></label>
                                    <select name="kr_pendidikan_skrng" id="kr_pendidikan_skrng" class="form-control">
                                    <?php
                                        for($i=0;$i<count($pendidikan);$i++){
                                            if($kr_update['kr_pendidikan_skrng'] == $pendidikan[$i])
                                                echo '<option value="'.$pendidikan[$i].'" selected>'.$pendidikan[$i].'</option>';
                                            else
                                                echo '<option value="'.$pendidikan[$i].'">'.$pendidikan[$i].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="kr_pendidikan_univ"><b><u><i>From</i></u>:</b></label>
                                    <input type="text" class="form-control mb-2" id="kr_pendidikan_univ" name="kr_pendidikan_univ" value="<?= $kr_update['kr_pendidikan_univ'] ?>">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <label for="kr_gelar_belakang"><b><u>Last Name Title (S.kom, M.M)</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_gelar_belakang" name="kr_gelar_belakang" value="<?= $kr_update['kr_gelar_belakang'] ?>">

                            <label for="kr_npwp"><b><u>NPWP number</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_npwp" name="kr_npwp" value="<?= $kr_update['kr_npwp'] ?>">

                            <label for="kr_bca"><b><u>BCA Account Number</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_bca" name="kr_bca" value="<?= $kr_update['kr_bca'] ?>">

                            <label for="kr_mulai_tgl"><b><u>Date started work</u>:</b></label>
                            <input type="date" class="form-control mb-2" id="kr_mulai_tgl" name="kr_mulai_tgl" value="<?= $kr_update['kr_mulai_tgl'] ?>">
                        </div>
                    </div>

                    <div style='height: 20px;'></div>
                    <h4 class="text-success mb-3 mt-4"><u>MARITAL STATUS (OPTIONAL)</u></h4>
                    
                    <div class="form-group row mt-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_marital"><b><u>Status</u>:</b></label>
                            <select name="kr_marital" id="kr_marital" class="form-control mb-2">
                            <?php
                                for($i=0;$i<count($marital);$i++){
                                    if($kr_update['kr_marital'] == $marital[$i])
                                        echo '<option value="'.$marital[$i].'" selected>'.ucfirst($marital[$i]).'</option>';
                                    else
                                        echo '<option value="'.$marital[$i].'">'.ucfirst($marital[$i]).'</option>';
                                }
                            ?>
                            </select>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak1"><b><u>1st Child's name</u>:</b></label>
                                    <input type="text" class="form-control mb-2" id="kr_anak1" name="kr_anak1" value="<?= $kr_update['kr_anak1'] ?>">
                                </div>
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak1_tanggal"><b><u>Born Date</u>:</b></label>
                                    <input type="date" class="form-control mb-2" id="kr_anak1_tanggal" name="kr_anak1_tanggal" value="<?= $kr_update['kr_anak1_tanggal'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak2"><b><u>2nd Child's name</u>:</b></label>
                                    <input type="text" class="form-control mb-2" id="kr_anak2" name="kr_anak2" value="<?= $kr_update['kr_anak2'] ?>">
                                </div>
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak2_tanggal"><b><u>Born Date</u>:</b></label>
                                    <input type="date" class="form-control mb-2" id="kr_anak2_tanggal" name="kr_anak2_tanggal" value="<?= $kr_update['kr_anak2_tanggal'] ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak3"><b><u>3rd Child's name</u>:</b></label>
                                    <input type="text" class="form-control mb-2" id="kr_anak3" name="kr_anak3" value="<?= $kr_update['kr_anak3'] ?>">
                                </div>
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak3_tanggal"><b><u>Born Date</u>:</b></label>
                                    <input type="date" class="form-control mb-2" id="kr_anak3_tanggal" name="kr_anak3_tanggal" value="<?= $kr_update['kr_anak3_tanggal'] ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak4"><b><u>4th Child's name</u>:</b></label>
                                    <input type="text" class="form-control mb-2" id="kr_anak4" name="kr_anak4" value="<?= $kr_update['kr_anak4'] ?>">
                                </div>
                                <div class="col-sm-6 mb-sm-0">
                                    <label for="kr_anak4_tanggal"><b><u>Born Date</u>:</b></label>
                                    <input type="date" class="form-control mb-2" id="kr_anak4_tanggal" name="kr_anak4_tanggal" value="<?= $kr_update['kr_anak4_tanggal'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kr_nama_pasangan"><b><u>Husband / wife&apos;s name</u>:</b></label>
                            <input type="text" class="form-control mb-2" id="kr_nama_pasangan" name="kr_nama_pasangan" value="<?= $kr_update['kr_nama_pasangan'] ?>">

                            <label for="kr_nikah_tanggal"><b><u>Date married</u>:</b></label>
                            <input type="date" class="form-control mb-2" id="kr_nikah_tanggal" name="kr_nikah_tanggal" value="<?= $kr_update['kr_nikah_tanggal'] ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
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


<script type = "text/javascript">
  $(document).ready(function () {

    var kr_id = $('._id').val();

    $.ajax(
    {
        type: "post",
        url: base_url + "API/get_history_st",
        data: {
          'kr_id': kr_id,
        },
        async: true,
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            if (data.length == 0) {
                var html = 'No History Available';
            } 
            else {
                var i;

                var html = '';
                
                html += '<table>';
                html += '<thead>';
                html += '<th style="padding: 0px 5px 0px 5px;">Date</th>';
                html += '<th></th>';
                html += '<th style="padding: 0px 5px 0px 5px;">Status</th>';
                html += '</thead>';
                html += '<tbody>';
                for (i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td style="padding: 0px 15px 0px 0px;">'+data[i].kr_h_status_tanggal+'</td>';
                    html += '<td style="padding: 0px 15px 0px 0px;">&rarr;</td>';
                    html += '<td style="padding: 0px 15px 0px 5px;">'+data[i].st_nama+'</td>';
                    html += '<td>';
                    html += '</td>';
                    html += '</tr>';
                }
                html += '</tbody>';
                html += '</table>';
            
            }

            $('.history_ajax').html(html);
        }
    });

    

  });
</script>