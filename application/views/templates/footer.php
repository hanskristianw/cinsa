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

    $('.dtinput').DataTable({
      ordering: false,
      paging: false,
      submitOnReturn: false,
      searching: false
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
      $("#uj_mid1_psi_persen").val(pasangan).change();
    });

    $('#uj_mid1_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_mid1_kog_persen").val(pasangan).change();
    });

    $('#uj_fin1_kog_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin1_psi_persen").val(pasangan).change();
    });

    $('#uj_fin1_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin1_kog_persen").val(pasangan).change();
    });

    $('#uj_mid2_kog_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_mid2_psi_persen").val(pasangan).change();
    });

    $('#uj_mid2_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_mid2_kog_persen").val(pasangan).change();
    });

    $('#uj_fin2_kog_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin2_psi_persen").val(pasangan).change();
    });

    $('#uj_fin2_psi_persen').on('change', function() {
      var pasangan = 100-$(this).val();
      $("#uj_fin2_kog_persen").val(pasangan).change();
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

    

  });
</script>

</html>
