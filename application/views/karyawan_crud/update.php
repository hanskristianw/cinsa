<style>
.grid-container {
  display: grid;
  grid-template-columns: 15% 15% 15% 25% 15% 15%;
  grid-column-gap:4px;
  padding-right:3px;
}
.grid-container > div{
  text-align:left;
}

.grid-main {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 20px;
  padding-top: 20px;
}

.box1{
  /*align-self:start;*/
  grid-column:2/3;
  overflow: auto;
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}

</style>


<div class="grid-main">
    <div class="box1 mb-4">
      <div class="text-center">
          <h3 class="text-gray-900 mb-4"><u><?= $title ?></u></h1>
      </div>

      <?php
      $pendidikan = ["SD", "SMP", "SMA", "S1", "S2", "S3"];

      $marital = ["Lajang", "Menikah", "Lainnya"];
      ?>

      <form class="user" method="post" action="<?php echo base_url('Karyawan_CRUD/update'); ?>">

          <h4 class="text-danger mb-3"><u>HARUS DIISI</u></h4>
          <input type="hidden" class="_id" name="_id" value="<?= set_value('_id', $kr_update['kr_id']); ?>">

          <input type="hidden" name="is_update" value="1">

          <label for="kr_nama_depan"><b><u>Nama Depan</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_nama_depan" name="kr_nama_depan" value="<?= set_value('kr_nama_depan', $kr_update['kr_nama_depan']); ?>" required>

          <label for="kr_nama_belakang"><b><u>Nama Belakang</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_nama_belakang" name="kr_nama_belakang" value="<?= set_value('kr_nama_belakang', $kr_update['kr_nama_belakang']); ?>">

          <label for="kr_jabatan"><b><u>Jabatan</u>:</b></label>
          <select name="kr_jabatan_id" id="kr_jabatan_id" class="form-control form-control-sm mb-2">
              <?php
              $_selected = set_value('kr_jabatan_id', $kr_update['kr_jabatan_id']);

              foreach ($jabatan_all as $m) :
                  if ($_selected == $m['jabatan_id']) {
                      $s = "selected";
                  } else {
                      $s = "";
                  }
                  if ($m['jabatan_id'] != 1) {
                      echo "<option value=" . $m['jabatan_id'] . " " . $s . ">" . $m['jabatan_nama'] . "</option>";
                  }
              endforeach
              ?>
          </select>

          <label for="sk"><b><u>Unit</u>:</b></label>
          <select name="kr_sk_id" id="kr_sk_id" class="form-control form-control-sm mb-2">
              <?php
              $_selected = set_value('kr_sk_id', $kr_update['kr_sk_id']);

              foreach ($sk_all as $m) :
                  if ($_selected == $m['sk_id']) {
                      $s = "selected";
                  } else {
                      $s = "";
                  }
                  echo "<option value=" . $m['sk_id'] . " " . $s . ">" . $m['sk_nama'] . "</option>";
              endforeach
              ?>
          </select>

          <label for="kr_agama_id"><b><u>Agama</u>:</b></label>
          <select name="kr_agama_id" id="kr_agama_id" class="form-control form-control-sm mb-3">
              <?php
              $_selected = $kr_update['kr_agama_id'];
              foreach ($agama_all as $m) :
                  if ($_selected == $m['agama_id']) {
                      $s = "selected";
                  } else {
                      $s = "";
                  }
                  echo "<option value=" . $m['agama_id'] . " " . $s . ">" . $m['agama_nama'] . "</option>";
              endforeach
              ?>
          </select>

          <label for="st" style='display: block;'><b><u>History Status</u>:</b></label>
          <div class="history_ajax"></div>

          <h4 class="text-success mb-3 mt-4"><u>INFORMASI TAMBAHAN (Tidak harus diisi)</u></h4>

          <label for="kr_gelar_depan"><b><u>Gelar Depan (Dr, Prof)</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_gelar_depan" name="kr_gelar_depan" value="<?= $kr_update['kr_gelar_depan'] ?>">

          <label for="kr_gelar_belakang"><b><u>Gelar Belakang (S.kom, M.M)</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_gelar_belakang" name="kr_gelar_belakang" value="<?= $kr_update['kr_gelar_belakang'] ?>">

          <label for="kr_ktp"><b><u>No KTP</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_ktp" name="kr_ktp" value="<?= $kr_update['kr_ktp'] ?>">

          <label for="kr_alamat_ktp"><b><u>Alamat berdasarkan KTP</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_alamat_ktp" name="kr_alamat_ktp" value="<?= $kr_update['kr_alamat_ktp'] ?>">

          <label for="kr_alamat_tinggal"><b><u>Alamat Tinggal (boleh sama dengan KTP)</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_alamat_tinggal" name="kr_alamat_tinggal" value="<?= $kr_update['kr_alamat_tinggal'] ?>">

          <label for="kr_hp"><b><u>No Whats App</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_hp" name="kr_hp" value="<?= $kr_update['kr_hp'] ?>">

          <label for="kr_rumah"><b><u>No Telepon Rumah</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_rumah" name="kr_rumah" value="<?= $kr_update['kr_rumah'] ?>">

          <label for="kr_pendidikan_skrng"><b><u>Pendidikan Terakhir</u>:</b></label>
          <select name="kr_pendidikan_skrng" id="kr_pendidikan_skrng" class="form-control form-control-sm mb-2">
              <?php
              for ($i = 0; $i < count($pendidikan); $i++) {
                  if ($kr_update['kr_pendidikan_skrng'] == $pendidikan[$i])
                      echo '<option value="' . $pendidikan[$i] . '" selected>' . $pendidikan[$i] . '</option>';
                  else
                      echo '<option value="' . $pendidikan[$i] . '">' . $pendidikan[$i] . '</option>';
              }
              ?>
          </select>
          <label for="kr_pendidikan_univ"><b><u><i>Dari Sekolah atau Universitas</i></u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_pendidikan_univ" name="kr_pendidikan_univ" value="<?= $kr_update['kr_pendidikan_univ'] ?>">

          <label for="kr_npwp"><b><u>Nomor NPWP</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_npwp" name="kr_npwp" value="<?= $kr_update['kr_npwp'] ?>">

          <label for="kr_bca"><b><u>No Rekening BCA</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_bca" name="kr_bca" value="<?= $kr_update['kr_bca'] ?>">

          <label for="kr_mulai_tgl"><b><u>Tanggal Mulai Bekerja</u>:</b></label>
          <input type="date" class="form-control form-control-sm mb-2" id="kr_mulai_tgl" name="kr_mulai_tgl" value="<?= $kr_update['kr_mulai_tgl'] ?>">

          <h4 class="text-success mb-3 mt-4"><u>STATUS PERNIKAHAN (Tidak harus diisi)</u></h4>

          <label for="kr_marital"><b><u>Status</u>:</b></label>
          <select name="kr_marital" id="kr_marital" class="form-control form-control-sm mb-2">
              <?php
              for ($i = 0; $i < count($marital); $i++) {
                  if ($kr_update['kr_marital'] == $marital[$i])
                      echo '<option value="' . $marital[$i] . '" selected>' . ucfirst($marital[$i]) . '</option>';
                  else
                      echo '<option value="' . $marital[$i] . '">' . ucfirst($marital[$i]) . '</option>';
              }
              ?>
          </select>

          <label for="kr_anak1"><b><u>Nama anak pertama</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_anak1" name="kr_anak1" value="<?= $kr_update['kr_anak1'] ?>">

          <label for="kr_anak1_tanggal"><b><u>Tanggal Lahir</u>:</b></label>
          <input type="date" class="form-control form-control-sm mb-2" id="kr_anak1_tanggal" name="kr_anak1_tanggal" value="<?= $kr_update['kr_anak1_tanggal'] ?>">

          <label for="kr_anak2"><b><u>Nama anak kedua</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_anak2" name="kr_anak2" value="<?= $kr_update['kr_anak2'] ?>">

          <label for="kr_anak2_tanggal"><b><u>Tanggal Lahir</u>:</b></label>
          <input type="date" class="form-control form-control-sm mb-2" id="kr_anak2_tanggal" name="kr_anak2_tanggal" value="<?= $kr_update['kr_anak2_tanggal'] ?>">

          <label for="kr_anak3"><b><u>Nama anak ketiga</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_anak3" name="kr_anak3" value="<?= $kr_update['kr_anak3'] ?>">

          <label for="kr_anak3_tanggal"><b><u>Tanggal Lahir</u>:</b></label>
          <input type="date" class="form-control form-control-sm mb-2" id="kr_anak3_tanggal" name="kr_anak3_tanggal" value="<?= $kr_update['kr_anak3_tanggal'] ?>">

          <label for="kr_anak4"><b><u>Nama anak keempat</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_anak4" name="kr_anak4" value="<?= $kr_update['kr_anak4'] ?>">

          <label for="kr_anak4_tanggal"><b><u>Tanggal Lahir</u>:</b></label>
          <input type="date" class="form-control form-control-sm mb-2" id="kr_anak4_tanggal" name="kr_anak4_tanggal" value="<?= $kr_update['kr_anak4_tanggal'] ?>">

          <label for="kr_nama_pasangan"><b><u>Nama istri/suami</u>:</b></label>
          <input type="text" class="form-control form-control-sm mb-2" id="kr_nama_pasangan" name="kr_nama_pasangan" value="<?= $kr_update['kr_nama_pasangan'] ?>">

          <label for="kr_nikah_tanggal"><b><u>Tanggal Pernikahan</u>:</b></label>
          <input type="date" class="form-control form-control-sm mb-2" id="kr_nikah_tanggal" name="kr_nikah_tanggal" value="<?= $kr_update['kr_nikah_tanggal'] ?>">

          <button type="submit" class="btn btn-secondary btn-user btn-block">
              Update
          </button>
      </form>
      <hr>
  </div>

</div>


<script type="text/javascript">
    $(document).ready(function() {

        var kr_id = $('._id').val();

        $.ajax({
            type: "post",
            url: base_url + "API/get_history_st",
            data: {
                'kr_id': kr_id,
            },
            async: true,
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                if (data.length == 0) {
                    var html = 'No History Available';
                } else {
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
                        html += '<td style="padding: 0px 15px 0px 0px;">' + data[i].kr_h_status_tanggal + '</td>';
                        html += '<td style="padding: 0px 15px 0px 0px;">&rarr;</td>';
                        html += '<td style="padding: 0px 15px 0px 5px;">' + data[i].st_nama + '</td>';
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
