    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Home') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-desktop"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SAS</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

    <!-- MANAJEMEN MENU -->
    <?php

      if($this->session->userdata('kr_jabatan_id')==1 && $this->session->userdata('kr_jabatan_id')){
        //Administrator
        echo'<div class="sidebar-heading">Administrator</div>
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master:</h6>
                  <a class="collapse-item" href="buttons.html">Tahun Ajaran</a>
                  <a class="collapse-item" href="cards.html">Semester</a>
                  <a class="collapse-item" href="cards.html">Sekolah</a>
                  <a class="collapse-item" href="cards.html">Jabatan</a>
                  <a class="collapse-item" href="cards.html">Struktur</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider">';
      }elseif($this->session->userdata('kr_jabatan_id')==2 && $this->session->userdata('kr_jabatan_id')){
        //jika dia karyawan
        echo'<div class="sidebar-heading">
              Employee
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master</h6>
                  <a class="collapse-item" href="buttons.html">Topik</a>
                  <a class="collapse-item" href="cards.html">Nilai</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
      }elseif($this->session->userdata('kr_jabatan_id')==3 && $this->session->userdata('kr_jabatan_id')){
        //jika dia HRD
        echo'<div class="sidebar-heading">
              HRD
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master</h6>
                  <a class="collapse-item" href='.base_url('karyawan_crud').'>Employee</a>
                  <a class="collapse-item" href="cards.html">Absensi</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
      }
    ?>



      <!-- Divider -->

      <!-- Heading -->


      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
