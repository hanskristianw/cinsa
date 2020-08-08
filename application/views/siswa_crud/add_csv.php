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
  /* overflow: auto; */
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}

</style>

<script src="<?= base_url('assets/'); ?>js/papaparse.min.js"></script>

<div class="grid-main">

  <div class="box1 text-center">
    <h1 class="h4 text-gray-900 mb-4 mt-4"><u><?= $title ?></u></h1>
  </div>
  <div class="box1">
    <div class="alert alert-primary pt-4" role="alert">
      <b>Silahkan import siswa dengan tahun ajaran yang sama, misal semua kelas X, semua kelas VII, semua kelas 1</b><br><br>
      <b>Yang harus ada:</b>
      <ul>
        <li>No Induk</li>
        <li>Nama depan siswa</li>
        <li>Kode tahun Ajaran</li>
        <li>Kode agama</li>
      </ul>


      <b>Contoh format excel (jangan lupa save as CSV):</b>
      <img class="mt-3" src="<?= base_url('assets/img/contoh.jpg')?>" height="350px" alt="Contoh" style="-moz-border-radius: 0px;-webkit-border-radius: 0px;border-radius: 0px;">
    </div>
  </div>




  <div class="box1 mb-4">
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="upload-csv" accept=".csv">
      <label class="custom-file-label" for="image">Pilih CSV</label>
    </div>


	  <button class="btn btn-secondary btn-user mt-3" id="btn-upload-csv">Preview</button>

  </div>
  <div class="box1 mb-4">
      <div id="report_csv"></div>
      <?= $this->session->flashdata('message'); ?>
  </div>
    <div class="box1" id="detail_csv_siswa" style="display: none;">
      <form class="user" method="post" action="<?= base_url('Siswa_CRUD/add_csv_proses'); ?>">
        <input type="hidden" name="sis_sk_id" value="<?= $sk_id ?>">
        <label><b>Angkatan Siswa di jenjang:</b></label><br>
        <label><b>Contoh:</b></label><br>
        <label>- Jika import ketika siswa di kelas XI tahun ajaran 2019/2020, berarti angkatan masuk siswa seharusnya adalah 2018/2019</label>
        <label>- Jika import ketika siswa di kelas X tahun ajaran 2019/2020, berarti angkatan masuk tetap 2019/2020</label>
        <select name="sis_t_id" class="form-control form-control-sm mb-2">
          <?php foreach ($t as $m) : ?>
            <option value='<?= $m['t_id'] ?>'>
              <?= $m['t_nama']; ?>
            </option>
          <?php endforeach ?>
        </select>
        <div id="tbl-data"></div>
      <form>
    </div>

</div>


<script type="text/javascript">

  function return_combo_agama(agama){
    var a = ["Kristen", "Katolik", "Islam", "Hindu", "Budha", "Konghucu", "Others"];
    var s = "";
    ht = '<select name="sis_agama[]">';
    var i;
    for(i=0;i<a.length;i++){
      if(agama-1 == i)
        s = "selected";
      else
        s = "";

      ht += `<option ${s} value ="${i+1}">${a[i]}</option>`;

    }
    ht += "</select>";

    return ht;
  }

  function return_combo_jk(jk){
    var a = ["Laki-laki", "Perempuan"];
    var s = "";
    ht = '<select name="sis_jk[]">';
    var i;
    for(i=0;i<a.length;i++){
      if(jk-1 == i)
        s = "selected";
      else
        s = "";

      ht += `<option ${s} value ="${i+1}">${a[i]}</option>`;

    }
    ht += "</select>";

    return ht;
  }

  let btn_upload = document.getElementById('btn-upload-csv').addEventListener('click', ()=> {
    $("#detail_csv_siswa").show();

    $('#report_csv').html('<div class="alert alert-warning">memproses....</div>');
    Papa.parse(document.getElementById('upload-csv').files[0], {
    	download: true,
    	header: false,
      skipEmptyLines: 'greedy',
    	complete: function(data) {

        $('#report_csv').html('<div class="alert alert-success">Berhasil membaca CSV, untuk menyimpan tekan tombol save dibawah</div>');
        var html = "";
    		//console.log(data.data.length);
    		//console.log(data.data[0][0]);

        var i;
        html += `
        <label class="mt-3 text-danger"><b>Jumlah Murid: ${data.data.length}</b></label>
        <table class="table table-sm" style="font-size:11px;">
                <thead>
                  <tr>
                    <th>No Induk</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Agama</th>
                    <th>Gender</th>
                  </tr>
                </thead>
                <tbody>`;
        for (i = 0; i < data.data.length; i++) {
          html += `<tr style="height:18px;">
                    <td><input type="text" required style="height:15px;" name="sis_no_induk[]" value="${data.data[i][0]}"></td>
                    <td><input type="text" required style="height:15px;" name="sis_nama_depan[]" value="${data.data[i][1]}"></td>
                    <td><input type="text" style="height:15px;" name="sis_nama_bel[]" value="${data.data[i][2]}"></td>
                    <td>${return_combo_agama(data.data[i][3])}</td>
                    <td>${return_combo_jk(data.data[i][4])}</td>
                   </tr>`;
        }
        html += `</tbody></table>

                  <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                  </button>`;

        //console.log(html);
        $('#tbl-data').html(html);

    	}
    });
  });

</script>
