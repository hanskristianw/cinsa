<style>
  .grid-container {
    display: grid;
    grid-template-columns: 5% 90% 5%;
    grid-column-gap: 3px;
    padding: 10px;
    margin: 20px;
    box-shadow: 5px 5px 5px 5px;
    overflow: auto;
    padding-bottom: 120px;
    padding-top: 50px;
  }


  .box1 {
    /*align-self:start;*/
    grid-column: 2/3;
  }

  .box2 {
    /*align-self:start;*/
    margin-top: 20px;
    grid-column: 2/3;
    display: grid;
    grid-template-columns: 100%;
    margin-right: 20px;
  }
</style>


<div class="grid-container">
  <div class="box2">
    <?php

    //var_dump($jadwal[0]['jampel_id']);

    $hari = ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];

    $mapel = return_mapel_by_kelas($kelas['kelas_id']);
    ?>

    <div class="text-center mt-4 bg-info text-white p-2 mb-4" style="border-radius: 25px;">
      <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
      <img src="<?= base_url('assets/img/jadwal.png'); ?>" width="50px;">
      <b><?= $kelas['kelas_nama'] ?></b>
    </div>

    <form action="<?= base_url('Jadwal_CRUD/jadwal_update_proses'); ?>" method="POST">

      <input type="hidden" name="kelas_id" id="kelas_id" value="<?= $kelas['kelas_id'] ?>">
      <?php
      $index = 0;
      for ($i = 0; $i < count($hari); $i++) : ?>
        <div>
          <label><b><u><?= $hari[$i] ?></u></b></label>

          <table class="rapot mb-2">
            <thead>
              <tr>
                <th>Jam Ke</th>
                <th>Mapel</th>
                <th>Pengajar</th>
                <th>Jam Mulai</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($j = 0; $j < 9; $j++) : ?>
                <tr>
                  <td style="text-align:center; width:40px;"><?= $j + 1 ?></td>
                  <td style="width:70px; text-align:center;">

                    <input type="hidden" name="jampel_id[]" value="<?= $jadwal[$index]['jampel_id'] ?>">

                    <select name="jampel_mapel_id[]" class="mapel_id" id="<?= $i + 1 ?>_<?= $j + 1 ?>" rel="<?= $jadwal[$index]['jampel_id'] ?>">
                      <option value="0">-</option>
                      <?php foreach ($mapel as $m) : ?>
                        <?php if ($m['mapel_id'] == $jadwal[$index]['jampel_mapel_id']) : ?>
                          <option value="<?= $m['mapel_id'] ?>" selected><?= $m['mapel_sing'] ?></option>
                        <?php else : ?>
                          <option value="<?= $m['mapel_id'] ?>"><?= $m['mapel_sing'] ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td style="text-align:center; width:200px;">

                    <!-- hari, jam  -->
                    <input type="hidden" id="p_<?= $i + 1 ?>_<?= $j + 1 ?>" value="<?= $jadwal[$index]['jampel_kr_id'] ?>">

                    <div id="pengajar_<?= $i + 1 ?>_<?= $j + 1 ?>">


                    </div>
                  </td>
                  <td style="text-align:center;">
                    <input type="time" name="jampel_jam_mulai[]" value="<?= $jadwal[$index]['jampel_jam_mulai'] ?>">
                  </td>
                </tr>
              <?php $index++;
              endfor; ?>
            </tbody>
          </table>
        </div>
      <?php
      endfor;
      echo "<br>";
      ?>

      <button type="submit" class="btn btn-primary btn-block">
        <i class="fa fa-save"></i> UPDATE
      </button>
    </form>
  </div>
</div>



<script>
  $(document).ready(function() {

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

    $('.mapel_id').each(function() {
      $(this).change(function() {
        //hari_jam
        str = $(this).attr('id');
        var dt = str.split('_');
        var hari = dt[0];
        var jam = dt[1];
        // console.log(hari);
        // console.log(jam);
        //mapel_id

        var jampel_id = $(this).attr('rel');

        $('#pengajar_' + hari + '_' + jam).html('');

        var p = $('#p_' + hari + '_' + jam).val();

        var mapel_id = $(this).val();
        var kelas_id = $('#kelas_id').val();

        if (mapel_id == 0) {
          var html = '';
          html += `<input type="hidden" name="jampel_id_aktif[]" value="${jampel_id}">`;
          html += `<input type="hidden" name="jampel_kr_id[]" value="0">`;

          $('#pengajar_' + hari + '_' + jam).html(html);

        } else {
          $.ajax({
            type: "post",
            url: base_url + "API/get_pengajar_by_mapel",
            data: {
              'mapel_id': mapel_id,
              'kelas_id': kelas_id
            },
            async: true,
            dataType: 'json',
            success: function(data) {
              //console.log(jampel_id);
              var html = '';

              if (data.length != 0) {
                //sudah ada outline
                html += `<input type="hidden" name="jampel_id_aktif[]" value="${jampel_id}">`;
                html += `<select name="jampel_kr_id[]">`;
                for (var i = 0; i < data.length; i++) {
                  if (data[i].kr_nama_depan) {
                    if (data[i].kr_id == p) {
                      html += `<option value="${data[i].kr_id}" selected>${data[i].kr_nama_depan} ${data[i].kr_nama_belakang}</option>`;
                    } else {
                      html += `<option value="${data[i].kr_id}">${data[i].kr_nama_depan} ${data[i].kr_nama_belakang}</option>`;
                    }
                  }
                }
                html += `</select>`;

              } else {
                //belum ada pengajar
                html += '<div class="text-center text-danger m-2"><b>--Pengajar Belum Diset, silahkan set pada halaman master - kelas--</b></div>';
              }


              $('#pengajar_' + hari + '_' + jam).html(html);

            }
          });
        }





      });
    }).change();

  });
</script>