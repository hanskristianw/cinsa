<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">List of Topic</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <table class="table display compact table-hover dt">
              <thead>
                <tr>
                  <th>Subject/School</th>
                  <th>Topic</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($mapel_all as $m) : ?>
                  <tr>
                    <td><?= $m['mapel_nama']." (".$m['sk_nama'].")" ?></td>
                    <td>
                      <?php
                        $topik_id = explode(",", $m['topik_id']);
                        $topik_nama = explode(",", $m['topik_nama']);
                        if($topik_id[0] != ""){
                          for ($i=0;$i<count($topik_id);$i++){
                              echo '<div>'.$topik_nama[$i].
                                '<div class="form-group row">
                                  <form action="Topik_CRUD/edit" method="GET">
                                    <input type="hidden" name="_id" value='.$topik_id[$i].'>
                                    <input type="hidden" name="_mapelid" value='.$m['mapel_id'].'>
                                    <button type="submit" class="badge badge-success">
                                    <i class="fa fa-edit"></i>
                                      Edit Topic
                                    </button>
                                  </form>
                                  <form action="Topik_CRUD/delete" method="POST">
                                    <input type="hidden" value='.$topik_id[$i].'>
                                    <button type="submit" class="badge badge-danger">
                                    <i class="fa fa-trash-alt"></i>
                                      Delete Topic
                                    </button>
                                  </form>
                                </div>
                                <hr>
                              </div>';
                          }
                        }else{
                          echo '<div class="text-danger"><b>- NO TOPIC -</b></div>';
                        }
                      ?>
                    </td>
                    <td>
                      <div class="form-group row">
                        <form class="" action="Topik_CRUD/add" method="get">
                          <input type="hidden" name="_id" value=<?= $m['mapel_id'] ?>>
                          <button type="submit" class="form-control btn-primary mt-2">
                          <i class="fa fa-plus"></i>
                            Topic
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
