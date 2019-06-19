<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">List of Class, Subject & Affective Topic</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="Afek_CRUD/input" method="POST">

              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="arr_afek" id="arr_afek" class="form-control">
                    <option value="0">Select Class/Subject</option>
                    <?php foreach ($mapel_all as $m) : ?>
                      <option value='<?=$m['d_mpl_mapel_id'].'|'.$m['kelas_id']?>'>
                        <?= "(".$m['t_nama']." - ".$m['sk_nama'].") ".$m['kelas_nama']." (".$m['mapel_nama'].")" ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="cek_agama" class="form-control mb-3">
                      <option value='0'>Order By Name</option>
                      <option value='1'>Group By Religion</option>
                  </select>
                </div>
              </div>
              <div id="topik_afek_ajax">
              
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
