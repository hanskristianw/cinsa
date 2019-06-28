<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
            </div>
            <div class="p-2"><?= $this->session->flashdata('message'); ?></div>

            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Status</th>
                  <th>Mapel</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kr_all as $m) : ?>
                  <tr>
                    <td><?= $m['kr_nama_depan'] ." ".$m['kr_nama_belakang'] ?></td>
                    <td><?= $m['kr_st_id'] ?></td>
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