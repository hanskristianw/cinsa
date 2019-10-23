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

      //echo $this->Menu->show_hello_world();

      if ($this->session->userdata('kr_jabatan_id') == 1 && $this->session->userdata('kr_jabatan_id')) {
        //Administrator atau Super Admin
        echo '<div class="sidebar-heading">Administrator</div>
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master:</h6>
                  <a class="collapse-item" href=' . base_url('Sekolah_CRUD') . '>School</a>
                  <a class="collapse-item" href=' . base_url('Tahun_CRUD') . '>Year</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider">';
      } elseif ($this->session->userdata('kr_jabatan_id') == 2 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia karyawan
        echo '<div class="sidebar-heading">
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
      } elseif ($this->session->userdata('kr_jabatan_id') == 3 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia HRD
        echo '<div class="sidebar-heading">
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
                  <a class="collapse-item" href=' . base_url('Karyawan_CRUD') . '>Employee</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
      } elseif ($this->session->userdata('kr_jabatan_id') == 4 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia wakakur
        echo '<div class="sidebar-heading">
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
                  <a class="collapse-item" href=' . base_url('Jenjang_CRUD') . '>1. Level</a>
                  <a class="collapse-item" href=' . base_url('Mapel_CRUD') . '>2. Subject</a>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD') . '>3. Topic</a>
                  <a class="collapse-item" href=' . base_url('Kelas_CRUD') . '>4. Class</a>
                  <a class="collapse-item" href=' . base_url('SSP_CRUD') . '>5. SSP</a>
                  <a class="collapse-item" href=' . base_url('MK_CRUD') . '>6. Special Subject</a>
                  <a class="collapse-item" href=' . base_url('Percent_CRUD') . '>7. Percentage</a>
                </div>
              </div>
            </li>


            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Grade</span>
              </a>
              <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Grade</h6>
                  <a class="collapse-item" href=' . base_url('Tes_CRUD') . '>1. Cognitive Psychomotor</a>
                  <a class="collapse-item" href=' . base_url('Uj_CRUD') . '>2. Mid & Final</a>
                  <a class="collapse-item" href=' . base_url('Afek_CRUD') . '>3. Affective</a>
                </div>
              </div>
            </li>

            
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Report</span>
              </a>
              <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Report</h6>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Grade Report</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>2. Affective</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD') . '>3. Student Report</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
      } elseif ($this->session->userdata('kr_jabatan_id') == 5 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia Kadiv
        echo '<div class="sidebar-heading">
              Head of Education Department
            </div>


            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-database"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Set</h6>
                  <a class="collapse-item" href=' . base_url('Sekolah_CRUD') . '>1. School</a>
                  <a class="collapse-item" href=' . base_url('Tahun_CRUD') . '>2. Year</a>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD') . '>3. Topic</a>
                  <a class="collapse-item" href=' . base_url('Konselor_CRUD') . '>4. Counselor</a>
                  <a class="collapse-item" href=' . base_url('Karakter_CRUD') . '>5. Character</a>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Grade</span>
              </a>
              <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Grade</h6>
                  <a class="collapse-item" href=' . base_url('Kadiv_CRUD/tes') . '>1. Cognitive Psychomotor</a>
                  <a class="collapse-item" href=' . base_url('Kadiv_CRUD/ujian') . '>2. Mid & Final</a>
                  <a class="collapse-item" href=' . base_url('Afek_CRUD') . '>3. Affective</a>
                </div>
              </div>
            </li>

            
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Report</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Show</h6>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Grade Report</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>2. Affective</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD') . '>3. Student Report</a>
                  <a class="collapse-item" href=' . base_url('Disjam_CRUD') . '>4. Hours Distribution</a>
                </div>
              </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">';

            
      } elseif ($this->session->userdata('kr_jabatan_id') == 6 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia TU
        echo '<div class="sidebar-heading">
              School Administrative
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Administrative</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master</h6>
                  <a class="collapse-item" href=' . base_url('Siswa_CRUD') . '>Student</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
      } elseif ($this->session->userdata('kr_jabatan_id') == 7 && $this->session->userdata('kr_jabatan_id')) {

        if (return_menu_kepsek()) {
          echo ' <div class="sidebar-heading">
                    Principal Menu
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-graduation-cap"></i>
                      <span>Principal</span>
                    </a>
                    <div id="collapse9" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Report</h6>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Grade Report</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>2. Student Report</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>3. Affective</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/Konseling') . '>4. Counseling</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }
        //var_dump(return_menu_kepsek());
        //jika dia Guru
        if (mapel_menu() >= 1) {
        echo '<div class="sidebar-heading">
            Subject Menu
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>Subject</span>
              </a>
              <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Set</h6>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD') . '>Topic</a>
                </div>
              </div>
            </li>
            
            <hr class="sidebar-divider d-none d-md-block">
            
            <div class="sidebar-heading">
              Grade Menu
            </div>
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Grade</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Grade</h6>
                  <a class="collapse-item" href=' . base_url('Tes_CRUD') . '>1. Cognitive Psychomotor</a>
                  <a class="collapse-item" href=' . base_url('Uj_CRUD') . '>2. Mid & Final</a>
                  <a class="collapse-item" href=' . base_url('Afek_CRUD') . '>3. Affective</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>4. Grade Report</a>
                </div>
              </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">';
        }

        if (wakasis_menu() >= 1) {
          echo '  <div class="sidebar-heading">
                    Vice Principal Menu
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fas fa-fw fa-handshake"></i>
                      <span>Vice Principal</span>
                    </a>
                    <div id="collapseOne3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('Wakasis_CRUD') . '>1. Moral Behaviour</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }

        if (konselor_menu() >= 1) {
          echo '  <div class="sidebar-heading">
                    Counselor Menu
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fas fa-fw fa-handshake"></i>
                      <span>Counselor</span>
                    </a>
                    <div id="collapseOne3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('K_afek_CRUD') . '>1. Affective Indicator</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD') . '>2. CB Topic</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/grade') . '>3. CB Grade</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/emo') . '>4. Emotional & Spirituality</a>
                        <a class="collapse-item" href=' . base_url('Konseling_CRUD') . '>5. Counseling Session</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
                  <div class="sidebar-heading">
                    Report Menu
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-chart-bar"></i>
                      <span>Report</span>
                    </a>
                    <div id="collapse9" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Report</h6>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>1. Affective</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/Report') . '>2. CB</a>
                        <a class="collapse-item" href=' . base_url('Konseling_CRUD/Report') . '>3. Counseling</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }

        if (walkel_menu() >= 1) {
          echo ' <div class="sidebar-heading">
                    Homeroom Menu
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-comment"></i>
                      <span>Homeroom</span>
                    </a>
                    <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Homeroom</h6>
                        <a class="collapse-item" href=' . base_url('Komen_CRUD/habit') . '>1. Habit, Social Skill</a>
                        <a class="collapse-item" href=' . base_url('Komen_CRUD') . '>2. Comment</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>3. Student Report</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }

        if (ssp_menu() >= 1) {
          echo ' <div class="sidebar-heading">
                    SSP
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-basketball-ball"></i>
                      <span>SSP</span>
                    </a>
                    <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Input</h6>
                        <a class="collapse-item" href=' . base_url('SSP_topik_CRUD') . '>1. Topic</a>
                        <a class="collapse-item" href=' . base_url('SSP_grade_CRUD') . '>2. Grade</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }

        if (scout_menu() >= 1) {
          echo ' <div class="sidebar-heading">
                    Scout
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse55" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-male"></i>
                      <span>Scout</span>
                    </a>
                    <div id="collapse55" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Input</h6>
                        <a class="collapse-item" href=' . base_url('Scout_CRUD') . '>Grade</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }
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