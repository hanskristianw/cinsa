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
      <h4 class="h4 text-gray-900"><b><u><?= $kelas['sk_nama'] ?></u></b></h4>
      <h4 class="h4 text-gray-900"><b><u>Afektif <?= $kelas['kelas_nama'] ?></u></b></h4>
      <h4 class="h4 text-gray-900 mb-4"><i><?= $mapel['mapel_nama']." ".$k_afek['k_afek_topik_nama'] ?></i></h4>

    </div>
    <?php echo '<div class="alert alert-danger alert-dismissible fade show">
            <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
            </button>
            <strong>PERHATIAN:</strong> Nilai tidak ditemukan, silahkan simpan nilai dengan menekan tombol dibawah
        </div>'; ?>

    <?php echo '<div class="alert alert-primary alert-dismissible fade show">
            <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
            </button>
            <div class="text-center">
            <strong>INFO:</strong> <br> A>=7.65 B>=6.3 C>=4.95 D<4.95 <br><br>
            <strong>SKOR:</strong> <br>
            1: '.$k_afek['k_afek_instruksi_1'].'<br>
            2: '.$k_afek['k_afek_instruksi_2'].'<br>
            3: '.$k_afek['k_afek_instruksi_3'].'

            <br></br><strong>INDIKATOR:</strong> <br>
            1: '.$k_afek['k_afek_1'].'<br>
            2: '.$k_afek['k_afek_2'].'<br>
            3: '.$k_afek['k_afek_3'].'
            </div>
        </div>'; ?>

    <div id="notif"></div>

    <form class="" action="<?= base_url('Afek_CRUD/save_input'); ?>" method="post" id="formafek" >
      <input type="hidden" value="<?= $kelas_id ?>" name="kelas_id">
      <input type="hidden" value="<?= $mapel_id ?>" name="mapel_id">
      <input type="hidden" value="<?= $k_afek_id ?>" name="k_afek_id">
      <input type="hidden" value = "0" id="afek_minggu_aktif" name="afek_minggu_aktif">
      <table class="table table-bordered table-hover table-sm table-striped" style='font-size:13px;overflow: auto;'>
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th colspan="3">Minggu 1 <select class="form-control form-control-sm mb-2 mt-2 option_minggu1" name="option_minggu1" id="option_minggu1">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
            </th>
            <th colspan="3">Minggu 2<select class="form-control form-control-sm mb-2 mt-2 option_minggu2" name="option_minggu2" id="option_minggu2">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
            </th>
            <th colspan="3">Minggu 3<select class="form-control form-control-sm mb-2 mt-2 option_minggu3" name="option_minggu3" id="option_minggu3">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
            </th>
            <th colspan="3">Minggu 4<select class="form-control form-control-sm mb-2 mt-2 option_minggu4" name="option_minggu4" id="option_minggu4">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
            </th>
            <th colspan="3">Minggu 5<select class="form-control form-control-sm mb-2 mt-2 option_minggu5" name="option_minggu5" id="option_minggu5">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
            </th>
            <th style="vertical-align:top">Hasil</th>
          </tr>
        </thead>
        <tbody>

          <?php
            $ag_temp = "xxx";
            $i = 1;
            foreach ($siswa_all as $m) :

              if($cek_agama == 1){
                $ag = $m['agama_nama'];
                if($ag != $ag_temp ){
                  echo '
                  <tr class="table-warning">
                    <td colspan="18" align="center">
                      <b>'.$ag.'</b>
                    </td>
                  </tr>';
                }
                $ag_temp = $ag;
              }
          ?>

            <tr>
              <td>
                <input type="hidden" value="<?= $m['d_s_id']; ?>" name="d_s_id[]">
                <?= $m['sis_no_induk']; ?>
              </td>
              <td style='width:250px;'>
                <?php
                  echo $m['sis_nama_depan']." ".$m['sis_nama_bel'];
                ?>
              </td>
              <?php
                //minggu 1
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a1 $i' name='minggu1a1[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a2 $i' name='minggu1a2[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu1 minggu1a3 $i' name='minggu1a3[]' value='3' min='1' max='3'></td>";

                //minggu 2
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a1 $i' name='minggu2a1[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a2 $i' name='minggu2a2[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu2 minggu2a3 $i' name='minggu2a3[]' value='3' min='1' max='3'></td>";

                //minggu 3
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a1 $i' name='minggu3a1[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a2 $i' name='minggu3a2[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu3 minggu3a3 $i' name='minggu3a3[]' value='3' min='1' max='3'></td>";

                //minggu 4
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a1 $i' name='minggu4a1[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a2 $i' name='minggu4a2[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu4 minggu4a3 $i' name='minggu4a3[]' value='3' min='1' max='3'></td>";

                //minggu 5
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a1 $i' name='minggu5a1[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a2 $i' name='minggu5a2[]' value='3' min='1' max='3'></td>";
                echo "<td><input type = 'number' required style='width: 32px;' class='minggu5 minggu5a3 $i' name='minggu5a3[]' value='3' min='1' max='3'></td>";

              ?>
              <td class="text-center">
                <div class='t<?=$i?>'>

                </div>
              </td>
            </tr>
          <?php $i++; endforeach ?>
        </tbody>
      </table>

      <div id="mingaktif"></div>

      <br>
      <button type="submit" class="btn btn-success mt-2 btnsimpafektif" id="btn-save">
        <i class="fa fa-save"></i>
        Simpan
      </button>

      <div id="pesanafek"></div>

    </form>
    <hr>
  </div>

</div>
