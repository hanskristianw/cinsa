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

  <div class="box1 text-center">
    <h1 class="h4 text-gray-900 mb-4 mt-4"><u>Upload Rapor YPPI</u></h1>
  </div>

  <div class="box1">
      <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">
    <select name="kelas_id" id="kelas_id_upload" class="form-control form-control-sm">
      <option value="0">Pilih Kelas</option>
      <?php foreach ($kelas_all as $m) : ?>
        <option value='<?= $m['kelas_id'] ?>'>
          <?= $m['kelas_nama']." (".$m['sk_nama']." ".$m['t_nama'].")" ?>
        </option>
      <?php endforeach ?>
    </select>

    <div id="detail_upload">

    </div>

  </div>

</div>

<script type="text/javascript">

  function return_warna(a){
    if(!a)
      return "bg-danger";
    else
      return "";
  }

  //setTimeout("self.close()", 5000 );

  $('#kelas_id_upload').change(function () {
    $('#detail_upload').html("");
    var id = $(this).val();

    //alert(id);
    if (id == 0) {
      $('#detail_upload').html("");
    }
    else {

      $.ajax(
        {
          type: "post",
          url: base_url + "Komen_CRUD/get_siswa",
          data: {
            'id': id,
          },
          async: true,
          dataType: 'json',
          success: function (data) {
            //console.log(data);
            if (data.length == 0) {
              var html = '<div class="text-center mb-3 text-danger"><b>--Belum ada siswa, hubungi waka kurikulum--</b></div>';
            } else {
              var html = '';
              var i;

              html += '<table class="table table-hover table-sm table-bordered mt-4" style="font-size:13px;">';
              html += `<thead class="thead-dark">
                        <tr>
                          <th rowspan="3" class="text-center">Nama</th>
                          <th colspan="4" class="text-center">Semester 1</th>
                          <th colspan="4" class="text-center">Semester 2</th>
                        </tr>
                        <tr>
                          <th class="text-center" colspan="2">Sisipan</th>
                          <th class="text-center" colspan="2">Semester</th>
                          <th class="text-center" colspan="2">Sisipan</th>
                          <th class="text-center" colspan="2">Semester</th>
                        </tr>
                        <tr>
                          <th class="text-center">Status</th>
                          <th class="text-center">Action</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Action</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Action</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>`;

              for (i = 0; i < data.length; i++) {
                html += '<tr>';
                html += `<td>${data[i].sis_nama_depan} ${data[i].sis_nama_bel}</td>`;



                //sem 1 sisipan
                html += `<td style="width:40px;" class="${return_warna(data[i].yppi_1_sis)}">`;
                if(data[i].yppi_1_sis){
                  html += `<a href="${base_url}assets/img/raporyppi/${data[i].yppi_1_sis}" target="_blank">Preview</a>`;
                }
                html += `</td>`;

                html += `<td style="width:40px;">
                          <form action="${base_url}/komen_crud/upload_pdf_yppi_proses" method="POST" target="_blank">
                            <input type="hidden" name="d_s_id" value="${data[i].d_s_id}">
                            <input type="hidden" name="nama_siswa" value="${data[i].sis_nama_depan} ${data[i].sis_nama_bel}">
                            <input type="hidden" name="jenis_upload" value="0">
                            <button type="submit" class="badge badge-success btn-sm ml-2">
                              Upload
                            </button>
                          </form>
                        </td>`;

                //sem 1 semester
                html += `<td style="width:40px;" class="${return_warna(data[i].yppi_1_sem)}">`;
                if(data[i].yppi_1_sem){
                  html += `<a href="${base_url}assets/img/raporyppi/${data[i].yppi_1_sem}" target="_blank">Preview</a>`;
                }
                html += `</td>`;

                html += `<td style="width:40px;">
                          <form action="${base_url}komen_crud/upload_pdf_yppi_proses" method="POST" target="_blank">
                            <input type="hidden" name="d_s_id" value="${data[i].d_s_id}">
                            <input type="hidden" name="nama_siswa" value="${data[i].sis_nama_depan} ${data[i].sis_nama_bel}">
                            <input type="hidden" name="jenis_upload" value="1">
                            <button type="submit" class="badge badge-success btn-sm ml-2">
                              Upload
                            </button>
                          </form>
                        </td>`;


                //sem 2 sisipan
                html += `<td style="width:40px;" class="${return_warna(data[i].yppi_2_sis)}">`;
                if(data[i].yppi_2_sis){
                  html += `<a href="${base_url}assets/img/raporyppi/${data[i].yppi_2_sis}" target="_blank">Preview</a>`;
                }
                html += `</td>`;

                html += `<td style="width:40px;">
                          <form action="${base_url}komen_crud/upload_pdf_yppi_proses" method="POST" target="_blank">
                            <input type="hidden" name="d_s_id" value="${data[i].d_s_id}">
                            <input type="hidden" name="nama_siswa" value="${data[i].sis_nama_depan} ${data[i].sis_nama_bel}">
                            <input type="hidden" name="jenis_upload" value="2">
                            <button type="submit" class="badge badge-success btn-sm ml-2">
                              Upload
                            </button>
                          </form>
                        </td>`;


                //sem 2 semester
                html += `<td style="width:40px;" class="${return_warna(data[i].yppi_2_sem)}">`;
                if(data[i].yppi_2_sem){
                  html += `<a href="${base_url}assets/img/raporyppi/${data[i].yppi_2_sem}" target="_blank">Preview</a>`;
                }
                html += `</td>`;
                html += `<td style="width:40px;">
                          <form action="${base_url}komen_crud/upload_pdf_yppi_proses" method="POST" target="_blank">
                            <input type="hidden" name="d_s_id" value="${data[i].d_s_id}">
                            <input type="hidden" name="nama_siswa" value="${data[i].sis_nama_depan} ${data[i].sis_nama_bel}">
                            <input type="hidden" name="jenis_upload" value="3">
                            <button type="submit" class="badge badge-success btn-sm ml-2">
                              Upload
                            </button>
                          </form>
                        </td>`;

                html += '</tr>';
              }
              html += `</tbody>
                      </table>`;

            }

            $('#detail_upload').html(html);
          }
        });
    }
  });
</script>
