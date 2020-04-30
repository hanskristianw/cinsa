    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

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
                  <a class="collapse-item" href=' . base_url('Sekolah_CRUD') . '>Unit</a>
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
        // echo '<div class="sidebar-heading">
        //             Suggestion/Critics
        //           </div>
        //           <li class="nav-item">
        //             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse556" aria-expanded="true" aria-controls="collapseTwo">
        //               <i class="fas fa-fw fa-envelope"></i>
        //               <span>Suggestion/Critics</span>
        //             </a>
        //             <div id="collapse556" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        //               <div class="bg-white py-2 collapse-inner rounded">
        //                 <h6 class="collapse-header">Input</h6>
        //                 <a class="collapse-item" href=' . base_url('Suggest_CRUD') . '>Suggestion</a>
        //               </div>
        //             </div>
        //           </li>
        //           <hr class="sidebar-divider d-none d-md-block">
        //     ';
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
                  <a class="collapse-item" href=' . base_url('Jenjang_CRUD') . '>1. Jenjang</a>
                  <a class="collapse-item" href=' . base_url('Mapel_CRUD') . '>2. Mapel</a>
                  <a class="collapse-item" href=' . base_url('Jadwal_CRUD') . '>3. Jadwal Pelajaran</a>
                  <a class="collapse-item" href=' . base_url('Jurnal_CRUD') . '>4. Jurnal</a>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD') . '>5. Topik</a>
                  <a class="collapse-item" href=' . base_url('Kelas_CRUD') . '>6. Kelas</a>
                  <a class="collapse-item" href=' . base_url('SSP_CRUD') . '>7. Extrakurikuler</a>
                  <a class="collapse-item" href=' . base_url('MK_CRUD') . '>8. Mapel Khusus</a>
                  <a class="collapse-item" href=' . base_url('Percent_CRUD') . '>9. Persentase</a>
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
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Grade</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>2. Affective / Subject</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>3. Affective / Month</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>4. Extracurricular</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD') . '>5. Report Card (NSA)</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD/yppi') . '>6. Report Card (YPPI)</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>7. Life Skill</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/ptspas') . '>8. PTS/PAS</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/dkn') . '>9. DKN</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/bi') . '>10. Buku Induk</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';


        // echo '<div class="sidebar-heading">
        //             Suggestion/Critics
        //           </div>
        //           <li class="nav-item">
        //             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse556" aria-expanded="true" aria-controls="collapseTwo">
        //               <i class="fas fa-fw fa-envelope"></i>
        //               <span>Suggestion/Critics</span>
        //             </a>
        //             <div id="collapse556" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        //               <div class="bg-white py-2 collapse-inner rounded">
        //                 <h6 class="collapse-header">Input</h6>
        //                 <a class="collapse-item" href=' . base_url('Suggest_CRUD') . '>Suggestion</a>
        //               </div>
        //             </div>
        //           </li>
        //           <hr class="sidebar-divider d-none d-md-block">
        //     ';
      } elseif ($this->session->userdata('kr_jabatan_id') == 5 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia Kadiv
        echo '<div class="sidebar-heading">
              Divisi Pendidikan
            </div>


            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-database"></i>
                <span>Master</span>
              </a>
              <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Set</h6>
                  <a class="collapse-item" href=' . base_url('Sekolah_CRUD') . '>1. Unit</a>
                  <a class="collapse-item" href=' . base_url('Tahun_CRUD') . '>2. Tahun</a>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD') . '>3. Topik</a>
                  <a class="collapse-item" href=' . base_url('Jadwal_CRUD') . '>4. Jadwal Pelajaran</a>
                  <a class="collapse-item" href=' . base_url('Jurnal_CRUD') . '>5. Jurnal</a>
                  <a class="collapse-item" href=' . base_url('Konselor_CRUD') . '>6. Konselor</a>
                  <a class="collapse-item" href=' . base_url('Karakter_CRUD') . '>7. Karakter</a>
                  <a class="collapse-item" href=' . base_url('CB_CRUD/set_lifeskill') . '>8. Life Skill</a>
                  <a class="collapse-item" href=' . base_url('Event_CRUD') . '>9. Event</a>
                  <a class="collapse-item" href=' . base_url('Disjam_CRUD/set_beban') . '>10. Tambahan Beban Jam</a>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Nilai</span>
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
                <span>Laporan</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Show</h6>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Grade</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/grade_history') . '>2. Grade History</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>3. Affective / Subject</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>4. Affective / Month</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>5. Extracurricular</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD') . '>6. Report Card (NSA)</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD/yppi') . '>7. Report Card (YPPI)</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>8. Life Skill</a>
                  <a class="collapse-item" href=' . base_url('Disjam_CRUD') . '>9. Disjam</a>
                  <a class="collapse-item" href=' . base_url('Kadiv_CRUD/last_login') . '>10. Login Activity</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/ptspas') . '>11. PTS/PAS</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/dkn') . '>12. DKN</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/bi') . '>13. Buku Induk</a>
                  <a class="collapse-item" href=' . base_url('Event_crud/laporan') . '>14. Event</a>
                </div>
              </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">';


      } elseif ($this->session->userdata('kr_jabatan_id') == 6 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia TU
        echo '<div class="sidebar-heading">
              Tata Usaha
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Tata Usaha</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master</h6>
                  <a class="collapse-item" href=' . base_url('Siswa_CRUD') . '>Murid</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';

        // echo '<div class="sidebar-heading">
        //             Suggestion/Critics
        //           </div>
        //           <li class="nav-item">
        //             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse556" aria-expanded="true" aria-controls="collapseTwo">
        //               <i class="fas fa-fw fa-envelope"></i>
        //               <span>Suggestion/Critics</span>
        //             </a>
        //             <div id="collapse556" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        //               <div class="bg-white py-2 collapse-inner rounded">
        //                 <h6 class="collapse-header">Input</h6>
        //                 <a class="collapse-item" href=' . base_url('Suggest_CRUD') . '>Suggestion</a>
        //               </div>
        //             </div>
        //           </li>
        //           <hr class="sidebar-divider d-none d-md-block">
        //     ';
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
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Grade</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>2. Affective / Subject</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>3. Affective / Month</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>4. Extracurricular</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>5. Report Card</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/Konseling') . '>6. Counseling</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>7. Life Skill</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/ptspas') . '>8. PTS/PAS</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/dkn') . '>9. DKN</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/bi') . '>10. Buku Induk</a>
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
            Menu Mapel
            </div>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Mapel</span>
              </a>
              <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Set</h6>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD') . '>1. Topik</a>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD/outline') . '>2. Outline</a>
                  <a class="collapse-item" href=' . base_url('Jurnal_CRUD') . '>3. Input Jurnal</a>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Nilai</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Nilai</h6>
                  <a class="collapse-item" href=' . base_url('Tes_CRUD') . '>1. Cognitive Psychomotor</a>
                  <a class="collapse-item" href=' . base_url('Uj_CRUD') . '>2. Mid & Final</a>
                  <a class="collapse-item" href=' . base_url('Afek_CRUD') . '>3. Affective</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>4. Grade Report</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/final_report') . '>5. Final Grade Report</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';
        }

        if (wakasis_menu() >= 1) {

          echo '
            <div class="sidebar-heading">
              Kesiswaan
            </div>
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne41" aria-expanded="true" aria-controls="collapseOne">
                  <i class="fas fa-fw fa-users"></i>
                  <span>Master</span>
                </a>
                <div id="collapseOne41" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Set</h6>
                    <a class="collapse-item" href=' . base_url('Wakasis_CRUD/pelanggaran') . '>1. Kategori Pelanggaran</a>
                    <a class="collapse-item" href=' . base_url('Wakasis_CRUD/jenis') . '>2. Jenis Pelanggaran</a>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne">
                  <i class="fas fa-fw fa-users"></i>
                  <span>Life Skill</span>
                </a>
                <div id="collapseOne4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Set</h6>
                    <a class="collapse-item" href=' . base_url('CB_CRUD/moral_index') . '>Moral Behaviour</a>
                  </div>
                </div>
              </li>
              <hr class="sidebar-divider d-none d-md-block">';
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
                        <a class="collapse-item" href=' . base_url('Konseling_CRUD') . '>4. Counseling Session</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">

                  <div class="sidebar-heading">
                    Life Skill Menu
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fas fa-fw fa-users"></i>
                      <span>Life Skill</span>
                    </a>
                    <div id="collapseOne4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/set_lifeskill') . '>1. Life Skill Description</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/emo') . '>2. Emotional & Spirituality</a>
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
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>1. Affective / Subject</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>2. Affective / Month</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/Report') . '>3. CB</a>
                        <a class="collapse-item" href=' . base_url('Konseling_CRUD/Report') . '>4. Counseling</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>5. Life Skill</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>6. Report Card (NSA)</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD/yppi') . '>7. Report Card (YPPI)</a>
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
                        <a class="collapse-item" href=' . base_url('Komen_CRUD') . '>1. Comment</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/habit_index') . '>2. Habit, Social Skill</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>3. Report Card</a>
                        <a class="collapse-item" href=' . base_url('Absent_CRUD') . '>4. Absent</a>
                        <a class="collapse-item" href=' . base_url('Review_CRUD') . '>5. Jurnal Review</a>
                        <a class="collapse-item" href=' . base_url('Review_CRUD/cancel_review') . '>6. Cancel Review</a>
                      </div>
                    </div>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrtu" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-globe"></i>
                      <span>Rapor Online</span>
                    </a>
                    <div id="collapseOrtu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('Ortu_CRUD') . '>1. Hak Akses</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }

        if (ssp_menu() >= 1) {
          echo ' <div class="sidebar-heading">
                    Extracurricular
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-basketball-ball"></i>
                      <span>Extracurricular</span>
                    </a>
                    <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Input</h6>
                        <a class="collapse-item" href=' . base_url('SSP_topik_CRUD') . '>1. Topic</a>
                        <a class="collapse-item" href=' . base_url('SSP_grade_CRUD') . '>2. Grade</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>3. Grade Report</a>
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


        // echo '<div class="sidebar-heading">
        //         Suggestion/Critics
        //       </div>
        //       <li class="nav-item">
        //         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse556" aria-expanded="true" aria-controls="collapseTwo">
        //           <i class="fas fa-fw fa-envelope"></i>
        //           <span>Suggestion/Critics</span>
        //         </a>
        //         <div id="collapse556" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        //           <div class="bg-white py-2 collapse-inner rounded">
        //             <h6 class="collapse-header">Input</h6>
        //             <a class="collapse-item" href=' . base_url('Suggest_CRUD') . '>Suggestion</a>
        //           </div>
        //         </div>
        //       </li>
        //       <hr class="sidebar-divider d-none d-md-block">
        // ';
      } elseif ($this->session->userdata('kr_jabatan_id') == 8) {
        echo '<div class="sidebar-heading">
                  Admission
                </div>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsead" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Buku</span>
                  </a>
                  <div id="collapsead" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Set</h6>
                      <a class="collapse-item" href=' . base_url('Admission_CRUD/penerbit') . '>1. Penerbit</a>
                      <a class="collapse-item" href=' . base_url('Admission_CRUD/buku') . '>2. Buku</a>
                      <a class="collapse-item" href=' . base_url('Admission_CRUD/penjualan') . '>3. Penjualan Buku</a>
                    </div>
                  </div>
                </li>
                <hr class="sidebar-divider d-none d-md-block">
                ';
      } elseif ($this->session->userdata('kr_jabatan_id') == 9) {
        //KEUANGAN
        echo '<div class="sidebar-heading">
                Keuangan
              </div>
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsead" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-fw fa-book"></i>
                  <span>Buku</span>
                </a>
                <div id="collapsead" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Set</h6>
                    <a class="collapse-item" href=' . base_url('Keuangan_CRUD/konfirmasi_buku') . '>1. Konfirmasi</a>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseadl" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-fw fa-print"></i>
                  <span>Laporan</span>
                </a>
                <div id="collapseadl" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Lihat</h6>
                    <a class="collapse-item" href=' . base_url('Keuangan_CRUD/laporan_buku') . '>1. Penjualan Buku</a>
                  </div>
                </div>
              </li>
              <hr class="sidebar-divider d-none d-md-block">
              ';
      }
      ?>



      <!-- Divider -->

      <!-- Heading -->

    </ul>
    <!-- End of Sidebar -->
