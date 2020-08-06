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

    <h4 class="text-center mb-3"><u>Kelas yang ada</u></h4>

    <?= $this->session->flashdata('message'); ?>

    <table class="table table-bordered table-striped" style="font-size:14px;">
      <thead class="thead-dark">
        <tr style="height:60px;">
          <th class="text-center" width="5%">#</th>
          <th class="text-center">Nama</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $index = 0;
          foreach ($results->getCourses() as $course):
            $index++;
        ?>
          <tr>
            <td style="padding: 5px 3px 0px 3px;" class="text-center"><?= $index; ?></td>
            <td style='padding: 5px 3px 0px 13px;'><?= $course->getName() ?></td>
            <form action="<?= base_url('Classroom_CRUD/grade') ?>" method="post">
              <td style='padding: 5px 3px 0px 3px; width:70px;'>
                <input type="hidden" name="classroom_id" value="<?= $course->getId() ?>">
                <input type="hidden" name="classroom_nama" value="<?= $course->getName() ?>">
                <button type="submit" class="badge badge-success">
                  Import Nilai
                </button>
              </td>
            </form>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>

</div>
