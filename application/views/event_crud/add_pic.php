<style>
.grid-container {
  display: grid;
  grid-template-columns: 100%;
  grid-column-gap:3px;
  padding: 10px;
  margin-left: 10%;
  margin-right: 10%;
  margin-bottom: 50px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
}
</style>

<div class="grid-container">

  <div class="text-center mt-3">
    <h1 class="h4 text-gray-900"><u><?= $title ?></u></h1>
  </div>
  
  <?php
    if (isset($error)){
        echo $error;
    }
  ?>
  <form method="post" action="<?= base_url('event_crud/save_pic') ?>" enctype="multipart/form-data">
    <div class="custom-file mt-2">
      <input type="hidden" value="<?= $event_id ?>" name="event_id">
      <input type="file" class="custom-file-input" id="image" name="image" required>
      <label class="custom-file-label" for="image">Choose Image</label>
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
      Add Image
    </button>
  </form>
  <hr>

</div>


<script type="text/javascript">

  $(document).ready(function() {
    
    // $('.custom-file-input2').on('change', function () {
    //   let fileName = $(this).val().split('\\').pop();
    //   $(this).next('.custom-file-label2').addClass("selected").html(fileName);
    // });


  });

</script>