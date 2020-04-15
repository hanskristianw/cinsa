<?php
function return_jenis_rapor($num)
{
  if ($num == 1)
    return "Sisipan";
  elseif ($num == 2)
    return "Semester";
}
?>

<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Daftar Tahun Ajaran</u></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('tahun_crud/add') ?>" class="btn btn-primary mb-3">Tambah Tahun</a>

            <table class="table table-sm table-bordered" style="font-size:14px;">
              <thead>
                <tr class="bg-dark text-white">
                  <th style="height: 50px;" class="align-middle  text-center">Tahun Ajaran</th>
                  <th class="align-middle text-center">Tanggal Mulai</th>
                  <th class="align-middle text-center">Tanggal Berakhir</th>
                  <th class="align-middle text-center">Semester Aktif untuk Siswa</th>
                  <th class="align-middle text-center">Jenis Rapor yang dapat dilihat<br>oleh Siswa</th>
                  <th class="align-middle text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($tahun_all as $m) : ?>
                  <tr>
                    <td class="align-middle text-center"><?= $m['t_nama'] ?></td>
                    <td class="align-middle text-center"><?= date("d-m-Y", strtotime($m['t_awal'])) ?></td>
                    <td class="align-middle text-center"><?= date("d-m-Y", strtotime($m['t_akhir'])) ?></td>
                    <td class="align-middle text-center"><?= $m['t_sem_aktif'] ?></td>
                    <td class="align-middle text-center"><?= return_jenis_rapor($m['t_jenis_rapor']) ?></td>
                    <td class="align-middle text-center">
                      <form class="" action="<?= base_url('Tahun_CRUD/update') ?>" method="get">
                        <input type="hidden" name="_id" value=<?= $m['t_id'] ?>>
                        <button type="submit" class="badge badge-warning">
                          Edit
                        </button>
                      </form>
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