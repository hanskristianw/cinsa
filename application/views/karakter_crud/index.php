<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
              <div class="p-5 overflow-auto">
                  <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Character List</h1>
                  </div>

                  <?= $this->session->flashdata('message'); ?>

                  <a href="<?= base_url('karakter_crud/add') ?>" class="btn btn-primary mb-3">Add New</a>

                  <table class="table display compact table-hover dt">
                    <thead>
                      <tr>
                        <th>Character Name</th>
                        <th>Character A</th>
                        <th>Character B</th>
                        <th>Character C</th>
                        <th>Urutan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($karakter_all as $m) : ?>
                        <tr>
                          <td><?= $m['karakter_nama'] ?></td>
                          <td><?= $m['karakter_a'] ?></td>
                          <td><?= $m['karakter_b'] ?></td>
                          <td><?= $m['karakter_c'] ?></td>
                          <td><?= $m['karakter_urutan'] ?></td>
                          <td>
                            <div class="form-group row">
                              <form class="" action="<?= base_url('Karakter_CRUD/update') ?>" method="get">
                                <input type="hidden" name="_id" value=<?= $m['karakter_id'] ?>>
                                <button type="submit" class="badge badge-warning">
                                    Edit
                                </button>
                              </form>
                              <form class="" action="<?= base_url('Karakter_CRUD/edit_subject') ?>" method="post">
                                <input type="hidden" name="karakter_id" value=<?= $m['karakter_id'] ?>>
                                <button type="submit" class="badge badge-primary">
                                    Edit Subject
                                </button>
                              </form>
                              <form class="" action="<?= base_url('Karakter_CRUD/delete') ?>" method="post">
                                <input type="hidden" name="karakter_id" value=<?= $m['karakter_id'] ?>>
                                <button type="submit" class="badge badge-danger">
                                    Delete
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                  <hr>
              </div>
            </div>
        </div>
        </div>
    </div>

</div>
