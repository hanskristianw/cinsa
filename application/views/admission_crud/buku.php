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
}
</style>


<div class="grid-container">

  <div class="box1 mb-3">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">
    <a href="<?= base_url('admission_crud/add_buku') ?>" class="btn btn-primary">&plus; Buku</a>
    <table class="table table-sm table-hover table-bordered mt-3" style="font-size:12px;">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Buku</th>
          <th>Harga Beli</th>
          <th>Harga Jual</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(count($b_all)>0): 
          $no = 1;
          foreach($b_all as $p) : ?>
          <tr>
            <td style='width:40px;'><?= $no ?></td>
            <td style='padding: 2px 5px 2px 5px;'><?= $p['buku_nama'] ?></td>
            <td><?= number_format($p['buku_harga_beli'],0,",","."); ?></td>
            <td><?= number_format($p['buku_harga_jual'],0,",","."); ?></td>
            <td style='width:100px;'>
              <div class="box2">
              <div>
              <form action="<?= base_url('Admission_CRUD/edit_buku') ?>" method="post">
                <input type="hidden" name="buku_id" value=<?= $p['buku_id'] ?>>
                <button type="submit" class="badge badge-warning">
                  Edit
                </button>
              </form>
              </div>
              <div>
              <form action="<?= base_url('Admission_CRUD/delete_buku') ?>" method="post">
                <input type="hidden" name="buku_id" value=<?= $p['buku_id'] ?>>
                <!-- <button type="submit" class="badge badge-danger">
                  Delete
                </button> -->
              </form>
              </div>
              </div>
            </td>
          </tr>
        <?php $no++; endforeach;
          else:
            echo "<td colspan='5' class='text-center text-danger'><b>No Data</b></td>";
          endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>

$(document).ready(function() {

  $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
  });

  $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert-danger").slideUp(500);
  });

});
</script>