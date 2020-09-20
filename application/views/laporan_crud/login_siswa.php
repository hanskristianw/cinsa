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
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}
</style>


<div class="grid-container">

  <div class="box1">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">


    <div class="alert alert-warning alert-dismissible fade show">
        <button class="close" data-dismiss="alert" type="button">
            <span>&times;</span>
        </button>
        <strong>Perhatian:</strong><br>
        1. Agar menghasilkan pola yang unik, username adalah gabungan dari no induk dan no urut siswa (dalam database)<br>
        2. Password sama dengan username
        <br><br>
        Supaya daftar siswa tidak terlalu panjang, silahkan melakukan update kelulusan di menu master - kelulusan
    </div>

    <table class="table table-sm table-bordered table-striped" style="font-size:14px;">
      <thead class="thead-dark">
        <tr style="height:50px;">
          <th class="align-middle text-center" style="width:10%;">No Induk</th>
          <th class="align-middle text-center" style="width:8%;">No Urut</th>
          <th class="align-middle text-center">Nama</th>
          <th class="align-middle text-center">Username</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($siswa_all as $s): ?>
          <tr>
            <td class="text-center"><?= $s['sis_no_induk'] ?></td>
            <td class="text-center"><?= $s['sis_id'] ?></td>
            <td class="text-center"><?= $s['sis_nama_depan'].' '.$s['sis_nama_bel'] ?></td>
            <td class="text-center"><?= $s['sis_username'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>

<script>
  $(document).ready(function () {

    // $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
    //   $(".alert-success").slideUp(500);
    // });

  });
</script>
