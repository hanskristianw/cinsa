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
            <strong>PERHATIAN:</strong> <br><br>
            Jangan input siswa yang sama lebih dari sekali pada jam yang sama, hal ini akan menyebabkan kekacauan proses review oleh wali kelas
            <br><br>Sebelum melakukan submit data, <b>PASTIKAN SELURUH JADWAL BENAR</b>
            <br><br>Jurnal sebaiknya diisi pada bulan yang sama dan tepat waktu, jika terlambat mengisi dan jadwal mengajar dirubah oleh wakakur, maka seluruh jadwal pengisian akan mengikuti jadwal yang baru
            </div>'; ?>

    <form class="user" method="post" action="<?= base_url('Jurnal_CRUD/save_jurnal'); ?>">
      <input type="hidden" name="t_id" value="<?=$t_id ?>">
      <input type="hidden" name="bulan_id" value="<?=$bulan['bulan_id']?>">
      <input type="hidden" name="mapel_id" value="<?=$mapel['mapel_id']?>">
      <?php

      $counter = 0;
      if($kelas_ajar):
      foreach ($kelas_ajar as $k):
      $outline = return_outline_by_mapel_kelas($mapel_id, $k['jampel_kelas_id']);
      //var_dump($outline);
      $jampel = return_hari_by_kelas_mapel_kr($kr_id, $mapel_id, $k['jampel_kelas_id'],$t_id);
      //var_dump($jampel);
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
                <th>Data siswa tak masuk / keterangan</th>
              </thead>
              <tbody>
                <?php
                for($jam=1;$jam<=9;$jam++):
                  foreach ($jam_ke as $jm):
                    if($jm['jampel_ke'] == $jam):
                ?>
                  <tr>
                    <td style="width:60px;"><?= $jam ?></td>
                    <td>
                      <select name="jurnal_mapel_outline_id[]" style="width:100px;">
                        <option value='0'>-</option>
                        <?php foreach ($outline as $o) : ?>
                          <option value='<?=$o['mapel_outline_id'] ?>'>
                            <?= $o['mapel_outline_nama'] ?>
                          </option>
                        <?php endforeach ?>
                      </select>
                    </td>
                    <td>
                      <select class="jumlah_siswa" rel="<?= $counter ?>" rel2="<?= $k['jampel_kelas_id'] ?>">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                      </select>
                    </td>
                    <td>
                      <div class="" id="<?= $counter ?>">

                      </div>
                      <input type="hidden" name="counter[]" value="<?= $counter ?>" style="width:40px;">
                      <input type="hidden" name="kelas_id[]" value="<?= $k['jampel_kelas_id'] ?>" style="width:40px;">
                      <input type="hidden" name="jurnal_jam_ke[]" value="<?= $jam ?>" style="width:40px;">
                      <input type="hidden" name="jurnal_hari_ke[]" value="<?= $hari ?>" style="width:40px;">
                      <input type="hidden" name="jurnal_minggu_ke[]" value="<?= $minggu ?>" style="width:40px;">

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
        <?php
          else:
            echo "<div class='text-center text-danger'><h5>-Anda tidak mempunyai jadwal pelajaran pada tahun ini, silahkan konsultasikan pada wakakur unit anda-</h5></div>";
          endif;
        ?>
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
