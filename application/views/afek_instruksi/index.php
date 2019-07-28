<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Afective Score Instruction</u></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('Afek_instruksi/input');?>" method="POST">
              <h6><b><u>Score 1:</u></b></h6>
              <textarea rows="4" name="sk_instruksi_afek_1" class="form-control mb-3"><?= $sk['sk_instruksi_afek1'] ?></textarea>
              <h6><b><u>Score 2:</u></b></h6>
              <textarea rows="4" name="sk_instruksi_afek_2" class="form-control mb-3"><?= $sk['sk_instruksi_afek2'] ?></textarea>
              <h6><b><u>Score 3:</u></b></h6>
              <textarea rows="4" name="sk_instruksi_afek_3" class="form-control mb-2"><?= $sk['sk_instruksi_afek3'] ?></textarea>
              
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Update
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
