    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Profile') ?>">
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
        //Administrator atau Super Admin
        echo'<div class="sidebar-heading">Administrator</div>
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master:</h6>
                  <a class="collapse-item" href='.base_url('Sekolah_CRUD').'>School</a>
                  <a class="collapse-item" href='.base_url('Tahun_CRUD').'>Year</a>
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
                  <a class="collapse-item" href=""></a>
                  <a class="collapse-item" href=""></a>
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
                  <a class="collapse-item" href='.base_url('Karyawan_CRUD').'>Employee</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
      }elseif($this->session->userdata('kr_jabatan_id')==4 && $this->session->userdata('kr_jabatan_id')){
        //jika dia wakakur
        echo'<div class="sidebar-heading">
              Curriculum
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master</h6>
                  <a class="collapse-item" href='.base_url('Kelas_CRUD').'>Class</a>
                  <a class="collapse-item" href='.base_url('Mapel_CRUD').'>Subject</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
      }elseif($this->session->userdata('kr_jabatan_id')==5 && $this->session->userdata('kr_jabatan_id')){
        //jika dia Kadiv
        echo'<div class="sidebar-heading">
              Head of Education Department
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Report</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master</h6>
                  <a class="collapse-item" href='.base_url('Karyawan_CRUD').'>Teacher Distribution</a>
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
