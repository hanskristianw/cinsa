<style>
.grid-container {
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

      <?php
        $changelog = get_changelog();
        $date = date_create($changelog['changelog_tgl']);
      ?>

      <img src="<?= base_url('assets/img/profile/').$kr['kr_pp'] ?>" alt="Avatar" style="width:35%">
      <div class="alert alert-secondary mt-1 text-center" role="alert" style="font-size:13px;">
        Update fitur program dilakukan terakhir pada: <?= date_format($date,"d-m-Y"); ?>, untuk melihat daftar perubahan klik <a href="<?= base_url('Announcement_CRUD/changelog') ?>">disini</a>
      </div>
      <div class="text-center"><?= $this->session->flashdata('message'); ?></div>
      <h3 class="text-center"><b><?= $kr['kr_nama_depan'].' '.$kr['kr_nama_belakang'] ?></b></h3>
      <p class="text-center"><?= $kr['sk_nama'] ?><br>
      <?= $jabatan['jabatan_nama']?> <br>
      <b>User Created Since: </b><?= date('d F Y', $kr['kr_date_created']); ?></p>
  </div>

</div>
