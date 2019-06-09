<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">List of Class & Subject</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="Uj_CRUD/input" method="POST">
              <select name="arr" class="form-control mb-3">
                <?php foreach ($mapel_all as $m) : ?>
                  <option value='<?=$m['d_mpl_mapel_id'].'|'.$m['kelas_id']?>'>
                    <?= "(".$m['t_nama'].") ".$m['kelas_nama']." (".$m['mapel_nama'].")" ?>
                  </option>
                <?php endforeach ?>
              </select>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                  Insert Mid & Final
              </button>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
