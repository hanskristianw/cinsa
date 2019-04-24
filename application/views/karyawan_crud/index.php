
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <div class="row">
    <div class="col-lg-6">

      <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newModal">Add New Employee</a>

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

<!-- MODAL -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newModal">Add New Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control mb-2" id="menu" placeholder="First Name">
            <input type="text" class="form-control mb-2" id="menu" placeholder="Last Name">
            <input type="text" class="form-control mb-2" id="menu" placeholder="Username">
            <input type="text" class="form-control mb-2" id="menu" placeholder="Password">
            <input type="text" class="form-control mb-2" id="menu" placeholder="Employee Status">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>