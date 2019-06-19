 <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Yayasan Pendidikan dan Pengajaran Indonesia</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
  <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

</body>

<script type="text/javascript">
  $(document).ready(function() {
    $('.custom-file-input').on('change',function(){
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    $('.dt').DataTable({
      "ordering": false
    });

    $(window).keydown(function(event){
      if((event.keyCode == 13) && ($(event.target)[0]!=$("number")[0])) {
          event.preventDefault();
          return false;
      }
    });

    $('input[type=number]').each(function(){
      $(this).keydown(function(e)
      {
          var key = e.charCode || e.keyCode || 0;
          // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
          // home, end, period, and numpad decimal
          return (
              // numbers
                  key >= 48 && key <= 57 ||
              // Numeric keypad
                  key >= 96 && key <= 105 ||
              // Backspace and Tab and Enter
                  key == 8 || key == 9 || key == 13 ||
              // Home and End
                  key == 35 || key == 36 ||
              // left and right arrows
                  key == 37 || key == 39 ||
              // Del and Ins
                  key == 46 || key == 45);
      });

      $(this).change(function () {
          var max = parseInt($(this).attr('max'));
          var min = parseInt($(this).attr('min'));
          if ($(this).val() > max)
          {
              $(this).val(max);
          }
          else if ($(this).val() < min)
          {
              $(this).val(min);
          }

          if( !$(this).val() ) {
              $(this).val(0);
          }
      });
    });


    ////////////////////////////////////
    //////UJIAN - INPUT/UPDATE//////////
    ////////////////////////////////////

    $('#uj_mid1_kog_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_mid1_psi_persen").val(pasangan);
    });

    $('#uj_mid1_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_mid1_kog_persen").val(pasangan);
    });

    $('#uj_fin1_kog_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin1_psi_persen").val(pasangan);
    });

    $('#uj_fin1_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin1_kog_persen").val(pasangan);
    });

    $('#uj_mid2_kog_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_mid2_psi_persen").val(pasangan);
    });

    $('#uj_mid2_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_mid2_kog_persen").val(pasangan);
    });

    $('#uj_fin2_kog_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin2_psi_persen").val(pasangan);
    });

    $('#uj_fin2_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin2_kog_persen").val(pasangan);
    });


    $('.kin').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin').index(this) + 1;
          $('.kin').eq(index).focus();
      }
    });

    $('.kin2').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin2').index(this) + 1;
          $('.kin2').eq(index).focus();
      }
    });

    $('.kin3').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin3').index(this) + 1;
          $('.kin3').eq(index).focus();
      }
    });

    $('.kin4').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin4').index(this) + 1;
          $('.kin4').eq(index).focus();
      }
    });

    $('.kin5').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin5').index(this) + 1;
          $('.kin5').eq(index).focus();
      }
    });

    $('.kin6').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin6').index(this) + 1;
          $('.kin6').eq(index).focus();
      }
    });

    $('.kin7').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin7').index(this) + 1;
          $('.kin7').eq(index).focus();
      }
    });

    $('.kin8').keydown(function (e) {
      if (e.which === 13) {
          var index = $('.kin8').index(this) + 1;
          $('.kin8').eq(index).focus();
      }
    });
    /////////////////////////////
    //////END////////////////////
    /////////////////////////////

    ////////////////////////////////////
    //////COGNITIVE - PSYSCHOMOTOR//////
    //////////////INDEX/////////////////
    $('#kog_quiz_persen').on('change', function() {
      var total = 100-$(this).val()-$("#kog_test_persen").val()-$("#kog_ass_persen").val();;
      
      if(total == 0){
        $("#btn-save").removeAttr('disabled');
        $('#notif').html("");
      }else{
        $("#btn-save").attr('disabled','disabled');
        $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
      }
      
    });

    $('#kog_test_persen').on('change', function() {
      var total = 100-$(this).val()-$("#kog_quiz_persen").val()-$("#kog_ass_persen").val();;
      
      if(total == 0){
        $("#btn-save").removeAttr('disabled');
        $('#notif').html("");
      }else{
        $("#btn-save").attr('disabled','disabled');
        $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
      }
    });

    $('#kog_ass_persen').on('change', function() {
      var total = 100-$(this).val()-$("#kog_quiz_persen").val()-$("#kog_test_persen").val();;
      
      if(total == 0){
        $("#btn-save").removeAttr('disabled');
        $('#notif').html("");
      }else{
        $("#btn-save").attr('disabled','disabled');
        $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
      }
    });

    $('#psi_quiz_persen').on('change', function() {
      var total = 100-$(this).val()-$("#psi_test_persen").val()-$("#psi_ass_persen").val();;
      
      if(total == 0){
        $("#btn-save").removeAttr('disabled');
        $('#notif').html("");
      }else{
        $("#btn-save").attr('disabled','disabled');
        $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
      }
      
    });

    $('#psi_test_persen').on('change', function() {
      var total = 100-$(this).val()-$("#psi_quiz_persen").val()-$("#psi_ass_persen").val();;
      
      if(total == 0){
        $("#btn-save").removeAttr('disabled');
        $('#notif').html("");
      }else{
        $("#btn-save").attr('disabled','disabled');
        $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
      }
    });

    $('#psi_ass_persen').on('change', function() {
      var total = 100-$(this).val()-$("#psi_quiz_persen").val()-$("#psi_test_persen").val();;
      
      if(total == 0){
        $("#btn-save").removeAttr('disabled');
        $('#notif').html("");
      }else{
        $("#btn-save").attr('disabled','disabled');
        $('#notif').html("<div class='alert alert-danger'>Check Total Percentage</div>");
      }
    });
    

    $('#arr_cog_psy').change(function(){ 
        var id=$(this).val();
        
        if(id == 0){
          $('#topik_ajax').html("");
        }

        $.ajax(
        {
            type: "post",
            url: "<?php echo base_url(); ?>Tes_CRUD/get_topik",
            data:{
                'id':id,
            },
            async : true,
            dataType : 'json',
            success:function(data)
            {
              //console.log(data);
              if(data.length == 0){
                var html = '<div class="text-center mb-3 text-danger"><b>--No Topic, Please add Topic--</b></div>';
              }else{
                var html = '<select name="topik_id" id="topik_id" class="form-control mb-3">';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].topik_id+'>'+data[i].topik_nama+'</option>';
                }
                html += '</select>';

                html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
                html += 'Insert Cog & Psy';
                html += '</button>';
              }
              
              $('#topik_ajax').html(html);
              
            }
        });
    }); 
    /////////////////////////////
    //////END////////////////////
    /////////////////////////////
    ////////////////////////////////////
    //////COGNITIVE - PSYSCHOMOTOR//////
    //////////////INDEX/////////////////
    $('#arr_afek').change(function(){ 
        var id=$(this).val();
        
        if(id == 0){
          $('#topik_afek_ajax').html("");
        }

        $.ajax(
        {
            type: "post",
            url: "<?php echo base_url(); ?>Afek_CRUD/get_topik",
            data:{
                'id':id,
            },
            async : true,
            dataType : 'json',
            success:function(data)
            {
              //console.log(data);
              if(data.length == 0){
                var html = '<div class="text-center mb-3 text-danger"><b>--No Topic, Please add Topic--</b></div>';
              }else{
                var html = '<select name="k_afek_id" id="k_afek_id" class="form-control mb-3">';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].k_afek_id+'>'+data[i].bulan_nama+' ('+data[i].k_afek_topik_nama+')</option>';
                }
                html += '</select>';

                html += '<button type="submit" class="btn btn-primary btn-user btn-block">';
                html += 'Insert Affective';
                html += '</button>';
              }
              
              $('#topik_afek_ajax').html(html);
              
            }
        });
    }); 

    $("#option_minggu1").change(function () {

      var aktif1 = $("#option_minggu1").val();

      if(aktif1 == 0){
          $('input[type=number].minggu1').val('0')
          $('input[type=number].minggu1').attr("disabled", true);

      }else{
          $('input[type=number].minggu1').val('3')
          $('input[type=number].minggu1').attr("disabled", false);
      } 
    });

    $("#option_minggu2").change(function () {

      var aktif2 = $("#option_minggu2").val();

      if(aktif2 == 0){
          $('input[type=number].minggu2').val('0')
          $('input[type=number].minggu2').attr("disabled", true);
      }else{
          $('input[type=number].minggu2').val('3')
          $('input[type=number].minggu2').attr("disabled", false);
      } 
    });

    $("#option_minggu3").change(function () {

      var aktif3 = $("#option_minggu3").val();

      if(aktif3 == 0){
          $('input[type=number].minggu3').val('0')
          $('input[type=number].minggu3').attr("disabled", true);
      }else{
          $('input[type=number].minggu3').val('3')
          $('input[type=number].minggu3').attr("disabled", false);
      } 
    });

    $("#option_minggu4").change(function () {

      var aktif4 = $("#option_minggu4").val();

      if(aktif4 == 0){
          $('input[type=number].minggu4').val('0')
          $('input[type=number].minggu4').attr("disabled", true);
      }else{
          $('input[type=number].minggu4').val('3')
          $('input[type=number].minggu4').attr("disabled", false);
      } 
    });

    $("#option_minggu5").change(function () {

      var aktif5 = $("#option_minggu5").val();

      if(aktif5 == 0){
          $('input[type=number].minggu5').val('0')
          $('input[type=number].minggu5').attr("disabled", true);
      }else{
          $('input[type=number].minggu5').val('3')
          $('input[type=number].minggu5').attr("disabled", false);
      } 
    });
    /////////////////////////////
    //////END////////////////////
    /////////////////////////////

  });
</script>

</html>
