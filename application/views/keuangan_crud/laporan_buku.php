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
  padding-top: 10px;
  display: grid;
  grid-template-columns: 50% 50%;
  grid-column-gap:5px;
}
</style>


<div class="grid-container">

  <div class="box1 mb-3">
    <h5 class="text-center"><b><u>Laporan Penjualan Buku</u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <select name="t_id" id="t_laporan_buku" class="form-control form-control-sm">
      <option value="0">Pilih Periode</option>
      <?php foreach($t_all as $t): ?>
        <option value="<?= $t['t_id'] ?>"><?= $t['t_nama'] ?></option>
      <?php endforeach; ?>
    </select>
    <div id="laporan_buku_ajax"></div>
    <div class="box2" style="display:none;">
      <div>
        <input type="button" name="print_rekap" id="print_rekap" class="btn btn-block btn-success" value="Print">
      </div>
      <div>
        <input type="button" name="print_rekap" id="export_excel" class="btn btn-block btn-primary" value="Export to Excel">
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {

  function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
  $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
  });

  $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-danger").slideUp(500);
  });

  $('#t_laporan_buku').change(function () {
    var t_id = $(this).val();

    $('#laporan_buku_ajax').html("");

    if(t_id>0){
      //alert(sk_id);
      $('.box2').show();
      $.ajax(
      {
        type: "post",
        url: base_url + "Keuangan_CRUD/get_laporan_buku",
        data: {
          't_id': t_id
        },
        async: true,
        dataType: 'json',
        success: function (data) {
          //console.log(data);
          if (data.length == 0) {
            var html = '<div class="text-center text-light">Laporan Penjualan Belum Tersedia</div>';
          } else {
            var selisih = 0;
            var total = 0;
            var html = `
              <div id="print_area">
              <div style="height:50px;"></div>
              <table class="rapot mt-2">
               <thead>
                 <tr>
                   <th>Buku</th>
                   <th>Penerbit</th>
                   <th>Siswa</th>
                   <th>Harga Beli</th>
                   <th>Harga Jual</th>
                   <th>Selisih</th>
                 </tr>
               </thead>
               <tbody>`;
            for (i = 0; i < data.length; i++) {
              html += `<tr>
                         <td style="padding-left:5px; padding-right:5px;">${data[i].buku_nama}</td>
                         <td style="padding-left:5px; padding-right:5px;">${data[i].penerbit_nama}</td>`;

              if(data[i].sis_baru_nama){
                html += `<td style="padding-left:5px; padding-right:5px;">${data[i].sis_baru_nama}</td>`;
              }else{
                html += `<td style="padding-left:5px; padding-right:5px;">${data[i].sis_nama_depan} ${data[i].sis_nama_bel}</td>`;
              }
              selisih = data[i].buku_harga_jual - data[i].buku_harga_beli;
              total += selisih;
              html += `<td style="padding-left:5px; padding-right:5px;">${numberWithCommas(data[i].buku_harga_beli)}</td>
                       <td style="padding-left:5px; padding-right:5px;">${numberWithCommas(data[i].buku_harga_jual)}</td>
                       <td style="padding-left:5px; padding-right:5px;">${numberWithCommas(selisih)}</td>
                       `;
              html += `</tr>`;
            }
            html += `
              <tr>
                <td colspan="4" style="text-align:right; padding-left:5px; padding-right:5px;">Total:</td>
                <td colspan="4" style="padding-left:5px; padding-right:5px;">${numberWithCommas(total)}</td>
              </tr>
             </tbody>
             </table>
             </div>
             `;
          }

          $('#laporan_buku_ajax').html(html);
        }
      });
    }else{
      $('.box2').hide();
    }

  });


});
</script>