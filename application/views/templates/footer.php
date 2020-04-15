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
         <h5 class="modal-title" id="exampleModalLabel">Logout?</h5>
         <button class="close" type="button" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
         </button>
       </div>
       <div class="modal-body">Tekan logout untuk mengakhiri sesi.</div>
       <div class="modal-footer">
         <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
         <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
       </div>
     </div>
   </div>
 </div>

 <div class="modal" id="myModal">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">
           <div id='judul_modal'></div>
         </h5>
         <button class="close" id="close_modal">&times;</button>
       </div>
       <div class="modal-body">
         <div id='isi_modal'></div>
       </div>
       <div class="modal-footer">
         <button class="btn btn-secondary" id="close_modal2">Close</button>
       </div>
     </div>
   </div>
 </div>


 <script src="<?= base_url('assets/'); ?>js/printThis.js"></script>
 <script src="<?= base_url('assets/'); ?>js/allJs.js"></script>
 <script src="<?= base_url('assets/'); ?>js/konselor.js"></script>
 <script src="<?= base_url('assets/'); ?>js/mapel_khusus.js"></script>
 <script src="<?= base_url('assets/'); ?>js/karakter.js"></script>
 <script src="<?= base_url('assets/'); ?>js/laporan.js"></script>
 <script src="<?= base_url('assets/'); ?>js/sb-admin-2.js"></script>
 <!-- Custom scripts for all pages-->


 </body>

 </html>