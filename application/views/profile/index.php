<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5 p-5">
    <div class="card_custom">
      <img src="<?= base_url('assets/img/profile/').$kr['kr_pp'] ?>" alt="Avatar" style="width:40%">
      <div class="container_custom mt-3">.
        <div class="text-center"><?= $this->session->flashdata('message'); ?></div>
        <h3 class="text-center"><b><?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'] ?></b></h3> 
        <p class="text-center"><?= $kr['sk_nama'] ?><br>
        <?= $jabatan['jabatan_nama']?> <br>
        <b>User Created Since: </b><?= date('d F Y', $kr['kr_date_created']); ?></p> 
      </div>
    </div>
  </div>
</div>
