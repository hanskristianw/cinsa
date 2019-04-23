
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Welcome to <?= $title; ?></h1>
  <div class="card mb-3" style="max-width: 540px;">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img src="<?= base_url('assets/img/profile/').$kr['kr_pp'] ?>" class="card-img">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'] ?></h5>
          <p class="card-text"><small class="text-muted">User since: <?= date('d F Y', $kr['kr_date_created']); ?></small></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->