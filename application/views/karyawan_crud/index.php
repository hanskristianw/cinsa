
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-6">

      <a href="<?= base_url('karyawan_crud/add') ?>" class="btn btn-primary mb-3">Add New Employee</a>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($kr_all as $m) : ?>
            <tr>
              <td><?= $m['kr_nama_depan'] ?></td>
              <td><?= $m['kr_nama_belakang'] ?></td>
              <td><?= $m['kr_username'] ?></td>
              <td></td>
              <td>
                  <a href="" class="badge badge-success">Edit</a>
                  <a href="" class="badge badge-danger">Delete</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->