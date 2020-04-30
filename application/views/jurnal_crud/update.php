<style>
.grid-container {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 120px;
  padding-top: 50px;
}


.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.box2{
  /*align-self:start;*/
  grid-template-columns: 50% 50%;
}
</style>

<?php
  function return_hari($angka){
    if($angka == 1)
      return "Senin";
    elseif($angka == 2)
      return "Selasa";
    elseif($angka == 3)
      return "Rabu";
    elseif($angka == 4)
      return "Kamis";
    elseif($angka == 5)
      return "Jumat";
  }
?>

<div class="grid-container">

  <div class="box1">
    <h4 class="h4 text-gray-900 mt-3 text-center"><u><?= $title ?></u></h4>
    <h5 class="text-center"><?= ucwords(strtolower($mapel['mapel_nama'])) ?> - <?= ucwords(strtolower($bulan['bulan_nama'])) ?></h5>

    <?= $this->session->flashdata('message'); ?>
  </div>
  <div class="box1">

    <?php echo '<div class="alert alert-info alert-dismissible fade show">
            <button class="close" data-dismiss="alert" type="button">
                <span>&times;</span>
            </button>
            <strong>Perhatian:</strong> <br><br>
            Jangan input absen siswa yang sama lebih dari sekali pada jam yang sama
            <br><br>
            Baris yang bertanda merah merupakan jadwal baru yang dibuat oleh wakakur setelah anda melakukan perubahan terakhir, baris bertanda merah tidak akan tersimpan pada database
            <br><br>
            Baris yang bertanda hijau sudah direview oleh wali kelas, baris berwarna hijau tidak dapat dirubah lagi, sampai wali kelas membatalkan reviewnya
        </div>'; ?>

    <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/save_update'); ?>">
      <input type="hidden" name="bulan_id" value="<?=$bulan['bulan_id']?>">
      <input type="hidden" name="mapel_id" value="<?=$mapel['mapel_id']?>">
      <?php

      $counter = 0;
      foreach ($kelas_ajar as $k):
      $outline = return_outline_by_mapel_kelas($mapel_id, $k['jampel_kelas_id']);
      //var_dump($outline);
      $jampel = return_hari_by_kelas_mapel_kr($kr_id, $mapel_id, $k['jampel_kelas_id'],$t_id);
      echo '<div class="bg-primary text-center text-white p-3">'.$k['kelas_nama'].'</div>';
      for($minggu=1;$minggu<=5;$minggu++): ?>
        <div class="bg-secondary text-center mb-2">
          <label class="pt-3 pb-2 text-white"><b><u>Minggu ke: <?= $minggu ?></u></b></label>
        </div>
        <?php
          //var_dump($hari);
          for($hari=1;$hari<=5;$hari++):
            foreach ($jampel as $jp):
              if($jp['jampel_hari_ke'] == $hari):
                $jam_ke = return_jam_by_hari_kelas_mapel_kr($hari,$kr_id, $mapel_id, $k['jampel_kelas_id']);
                //var_dump($jam);
        ?>
            <label class="ml-1"><b><u><?= return_hari($hari) ?></u></b></label>
            <table class="table table-sm table-bordered" style="font-size:12px;">
              <thead>
                <th>Jam ke</th>
                <th>Outline</th>
                <th>Jumlah tidak masuk</th>
                <th>Data siswa tak masuk/keterangan</th>
              </thead>
              <tbody>
                <?php
                for($jam=1;$jam<=9;$jam++):
                  foreach ($jam_ke as $jm):
                    if($jm['jampel_ke'] == $jam):

                      //cari jurnal di mapel, kelas, jam, hari, minggu, bulan
                      $data = return_outline_siswa_tak_masuk($mapel_id, $k['jampel_kelas_id'], $jam, $hari, $minggu, $bulan['bulan_id']);
                      $red = "";
                      $hijau = "";
                      $dis = "";
                      if(!$data){
                        $red = "class='bg-danger'";
                      }else{
                        if($data['jurnal_review'] == 1){
                          $hijau = "class='bg-success text-white'";
                          $dis = "disabled";
                        }
                      }

                      //var_dump($data['jurnal_mapel_outline_id']);
                ?>
                  <tr <?= $red ?> <?= $hijau ?>>
                    <td style="width:60px;"><?= $jam ?>
                    <input type="hidden" name="jurnal_id[]" value="<?=$data['jurnal_id']?>" <?= $dis ?>>
                    <input type="hidden" name="jurnal_t_id[]" value="<?=$data['jurnal_t_id']?>" <?= $dis ?>></td>
                    <td>
                      <select name="jurnal_mapel_outline_id[]" style="width:100px;" <?= $dis ?>>
                        <option value='0'>-</option>
                        <?php
                          $s = "";
                          foreach ($outline as $o) :
                          if($data['jurnal_mapel_outline_id'] == $o['mapel_outline_id'])
                            $s = "selected";
                          else
                            $s = "";
                        ?>
                          <option value='<?=$o['mapel_outline_id'] ?>' <?= $s ?>>
                            <?= $o['mapel_outline_nama'] ?>
                          </option>
                        <?php endforeach ?>
                      </select>
                    </td>
                    <td>
                      <input type="hidden" id="d<?= $counter ?>" value="<?= $data['jurnal_d_s_id_absen']; ?>" <?= $dis ?>>

                      <select class="jumlah_siswa" rel="<?= $counter ?>" rel2="<?= $k['jampel_kelas_id'] ?>" <?= $dis ?>>
                        <?php
                          if($data['jurnal_d_s_id_absen']){
                            $s_mur = explode(",",$data['jurnal_d_s_id_absen']);
                            $s_ket = explode("{/}",$data['jurnal_d_s_id_ket']);
                          }
                          else
                            $s_mur = array();

                          // echo count($s_mur);
                          for($mur=0;$mur<=10;$mur++){
                            if($mur == count($s_mur))
                              echo '<option value="'.$mur.'" selected>'.$mur.'</option>';
                            else
                              echo '<option value="'.$mur.'">'.$mur.'</option>';
                          }
                        ?>
                      </select>
                    </td>
                    <td>
                      <div class="" id="<?= $counter ?>">
                        <?php
                          $sis_kelas = show_siswa_by_kelas($k['jampel_kelas_id']);
                        for($mur=0;$mur<count($s_mur);$mur++): ?>
                          <select class="siswa" name="c<?= $counter ?>[]" style="width:150px;" <?= $dis ?>>
                            <?php foreach ($sis_kelas as $sk):
                              $ss = "";
                              if($s_mur[$mur] == $sk['d_s_id'])
                                $ss = "selected";
                              else
                                $ss = "";
                            ?>
                              <option value="<?= $sk['d_s_id'] ?>" <?= $ss; ?>><?= $sk['sis_nama_depan'].' '.$sk['sis_nama_bel'] ?></option>
                            <?php endforeach; ?>
                          </select>
                          <input type="text" name="k<?= $counter ?>[]" value="<?= $s_ket[$mur] ?>" <?= $dis ?>>
                          <br>
                        <?php endfor; ?>
                      </div>
                      <input type="hidden" name="counter[]" value="<?= $counter ?>" style="width:40px;" <?= $dis ?>>
                      <input type="hidden" name="kelas_id[]" value="<?= $k['jampel_kelas_id'] ?>" style="width:40px;" <?= $dis ?>>
                      <input type="hidden" name="jurnal_jam_ke[]" value="<?= $jam ?>" style="width:40px;" <?= $dis ?>>
                      <input type="hidden" name="jurnal_hari_ke[]" value="<?= $hari ?>" style="width:40px;" <?= $dis ?>>
                      <input type="hidden" name="jurnal_minggu_ke[]" value="<?= $minggu ?>" style="width:40px;" <?= $dis ?>>
                    </td>

                  </tr>
                <?php
                    $counter++;
                    endif;
                  endforeach;
                endfor;
                ?>
              </tbody>
            </table>

        <?php
              endif;
            endforeach;
          endfor;
        endfor;
        endforeach;
        ?>
        <button type="submit" class="btn btn-success btn-block">
          <i class="fa fa-save"></i> SAVE
        </button>
    </form>

  </div>
</div>


<script>
$(document).ready(function() {

  $('.jumlah_siswa').change(function () {
    var jumlah_siswa = $(this).val();
    var counter = $(this).attr('rel');
    var kelas_id = $(this).attr('rel2');


    if(jumlah_siswa > 0){

      //alert(kelas_id);
      $.ajax(
      {
        type: "post",
        url: base_url + "API/get_siswa_by_kelas",
        data: {
          'kelas_id': kelas_id
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          var html = "";
          for (var j = 0; j < jumlah_siswa; j++) {
            html += `<select class="siswa" name="c${counter}[]" style="width:130px; fontsize:12px;">`;
              for (var i = 0; i < data.length; i++) {
                html += `<option value="${data[i].d_s_id}">${data[i].sis_nama_depan} ${data[i].sis_nama_bel}</option>`;
              }
            html += `</select>`;
            html += `<input type="text" name="k${counter}[]" style="width:130px; fontsize:12px;"><br>`;
          }
          $('#'+counter).html(html);

        }
      });
    }
    else{
      var html = "";
      $('#'+counter).html(html);
    }


  });


});
</script>
