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

      //var_dump(kpi_menu());



      if(kpi_menu()>0 && $this->session->userdata('kr_jabatan_id')){
        echo '<div class="sidebar-heading">KPI</div>
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwokpi" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Penilai PA & KPI</span>
              </a>
              <div id="collapseTwokpi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Nilai</h6>
                  <a class="collapse-item" href=' . base_url('PA_penilai_CRUD') . '>1. PA</a>
                  <a class="collapse-item" href=' . base_url('Hasil_KPI_CRUD') . '>2. Laporan</a>
                  <a class="collapse-item" href=' . base_url('Hasil_KPI_CRUD/rata') . '>3. Nilai PA Pribadi</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider">';
      }

      // if(cek_nilai_kpi_ada()>0 && $this->session->userdata('kr_jabatan_id')){
      //   echo '<div class="sidebar-heading">Lihat Penilaian</div>
      //       <li class="nav-item">
      //         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwokpilaporan" aria-expanded="true" aria-controls="collapseTwo">
      //           <i class="fas fa-fw fa-address-card"></i>
      //           <span>PA & KPI</span>
      //         </a>
      //         <div id="collapseTwokpilaporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      //           <div class="bg-white py-2 collapse-inner rounded">
      //             <h6 class="collapse-header">Nilai</h6>
      //             <a class="collapse-item" href=' . base_url('Lihat_nilai_kpi') . '>Lihat Nilai</a>
      //           </div>
      //         </div>
      //       </li>
      //
      //       <hr class="sidebar-divider">';
      // }

      if ($this->session->userdata('kr_jabatan_id') == 1 && $this->session->userdata('kr_jabatan_id')) {
        //Administrator atau Super Admin
        echo '<div class="sidebar-heading">Administrator</div>
            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Backend</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Master</h6>
                  <a class="collapse-item" href=' . base_url('Changelog_CRUD') . '>Changelog</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider">';

        echo '<div class="sidebar-heading">KPI - PA</div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master</span>
          </a>
          <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Master</h6>
              <a class="collapse-item" href=' . base_url('Jabatan_KPI_CRUD') . '>1. Jabatan</a>
              <a class="collapse-item" href=' . base_url('Persen_KPI_CRUD') . '>2. Persentase</a>
              <a class="collapse-item" href=' . base_url('Akses_KPI_PA') . '>3. Akses KPI - PA</a>
            </div>
          </div>
        </li>';

        echo '<div class="sidebar-heading">Laporan</div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo33" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book"></i>
            <span>KPI - PA</span>
          </a>
          <div id="collapseTwo33" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Rekap</h6>
              <a class="collapse-item" href=' . base_url('Rekap_PA_jabatan') . '>1. PA - jabatan</a>
              <a class="collapse-item" href=' . base_url('Rekap_PA_karyawan') . '>2. PA - karyawan</a>
            </div>
          </div>
        </li>

        <div class="sidebar-heading">Hapus</div>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo333" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-trash"></i>
            <span>Hapus</span>
          </a>
          <div id="collapseTwo333" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Hapus</h6>
              <a class="collapse-item" href=' . base_url('Hapus_PA') . '>1. Hapus nilai PA</a>
            </div>
          </div>
        </li>

        <hr class="sidebar-divider">';
      } elseif ($this->session->userdata('kr_jabatan_id') == 2 && $this->session->userdata('kr_jabatan_id')) {
        //jika dia karyawan
        // echo '<div class="sidebar-heading">
        //       Employee
        //     </div>
        //
        //     <li class="nav-item">
        //       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        //         <i class="fas fa-fw fa-cog"></i>
        //         <span>Master</span>
        //       </a>
        //       <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        //         <div class="bg-white py-2 collapse-inner rounded">
        //           <h6 class="collapse-header">Master</h6>
        //           <a class="collapse-item" href=""></a>
        //           <a class="collapse-item" href=""></a>
        //         </div>
        //       </div>
        //     </li>
        //
        //     <hr class="sidebar-divider d-none d-md-block">';
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
        //<a class="collapse-item" href=' . base_url('Percent_CRUD') . '>10. Persentase</a>
        echo '<div class="sidebar-heading">
              Wakakur
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
                  <a class="collapse-item" href=' . base_url('Topik_CRUD/outline') . '>3. Outline</a>
                  <a class="collapse-item" href=' . base_url('Jadwal_CRUD') . '>4. Jadwal Pelajaran</a>
                  <a class="collapse-item" href=' . base_url('Jurnal_CRUD') . '>5. Jurnal</a>
                  <a class="collapse-item" href=' . base_url('Topik_CRUD') . '>6. Topik</a>
                  <a class="collapse-item" href=' . base_url('Kelas_CRUD') . '>7. Kelas</a>
                  <a class="collapse-item" href=' . base_url('SSP_CRUD') . '>8. Extrakurikuler</a>
                  <a class="collapse-item" href=' . base_url('MK_CRUD') . '>9. Mapel Khusus</a>
                  <a class="collapse-item" href=' . base_url('Percent_CRUD') . '>10. Persentase</a>
                  <a class="collapse-item" href=' . base_url('Jadwal_CRUD/pengumuman') . '>11. Pengumuman</a>
                  <a class="collapse-item" href=' . base_url('Kelulusan_CRUD') . '>12. Kelulusan</a>
                </div>
              </div>
            </li>


            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-book"></i>
                <span>Nilai</span>
              </a>
              <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Nilai</h6>
                  <a class="collapse-item" href=' . base_url('Tes_CRUD') . '>1. Kognitif Psikomotor</a>
                  <a class="collapse-item" href=' . base_url('Uj_CRUD') . '>2. PTS & PAS</a>
                  <a class="collapse-item" href=' . base_url('Afek_CRUD') . '>3. Afektif</a>
                </div>
              </div>
            </li>


            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Laporan</span>
              </a>
              <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Laporan</h6>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Nilai</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>2. Afektif / Mapel</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>3. Afektif / Bulan</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>4. Extrakurikuler</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD') . '>5. Rapor (NSA)</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD/yppi') . '>6. Rapor (YPPI)</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>7. Life Skill</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/ptspas') . '>8. PTS & PAS</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/dkn') . '>9. DKN</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/bi') . '>10. Buku Induk</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/login_siswa_sekolah') . '>11. Login Siswa</a>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo33" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-trash"></i>
                <span>Hapus</span>
              </a>
              <div id="collapseTwo33" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Nilai</h6>
                  <a class="collapse-item" href=' . base_url('Hapus_Nilai_Mapel/ujian_index') . '>1. Hapus nilai UTS/UAS</a>
                  <a class="collapse-item" href=' . base_url('Hapus_Nilai_Mapel/topik_index') . '>2. Hapus nilai Topik</a>
                </div>
              </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">';

            echo '<div class="sidebar-heading">
                    Google
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse556" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-envelope"></i>
                      <span>Media</span>
                    </a>
                    <div id="collapse556" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Input</h6>
                        <a class="collapse-item" href=' . base_url('Classroom_CRUD') . '>1. Classroom</a>
                        <a class="collapse-item" href=' . base_url('Pembelajaran_CRUD') . '>2. Pembelajaran</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';


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
                  <h6 class="collapse-header">Nilai</h6>
                  <a class="collapse-item" href=' . base_url('Kadiv_CRUD/tes') . '>1. Kognitif Psikomotor</a>
                  <a class="collapse-item" href=' . base_url('Kadiv_CRUD/ujian') . '>2. PTS & PAS</a>
                  <a class="collapse-item" href=' . base_url('Afek_CRUD') . '>3. Afektif</a>
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
                  <h6 class="collapse-header">Laporan</h6>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Nilai</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/grade_history') . '>2. History Nilai</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>3. Afektif / Mapel</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>4. Afektif / Bulan</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>5. Extrakurikuler</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD') . '>6. Rapor (NSA)</a>
                  <a class="collapse-item" href=' . base_url('Report_CRUD/yppi') . '>7. Rapor (YPPI)</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>8. Life Skill</a>
                  <a class="collapse-item" href=' . base_url('Disjam_CRUD') . '>9. Disjam</a>
                  <a class="collapse-item" href=' . base_url('Kadiv_CRUD/last_login') . '>10. Aktifitas Login</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/ptspas') . '>11. PTS & PAS</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/dkn') . '>12. DKN</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/bi') . '>13. Buku Induk</a>
                  <a class="collapse-item" href=' . base_url('Event_crud/laporan') . '>14. Event</a>
                  <a class="collapse-item" href=' . base_url('laporan_crud/login_siswa_sekolah') . '>15. Login Siswa</a>
                </div>
              </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">';

            echo '<div class="sidebar-heading">
                    Google
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse556" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-envelope"></i>
                      <span>Media</span>
                    </a>
                    <div id="collapse556" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('Pembelajaran_CRUD') . '>Pembelajaran</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
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
                  <a class="collapse-item" href=' . base_url('Siswa_CRUD') . '>Siswa</a>
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
                    Kepsek
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-database"></i>
                      <span>Master</span>
                    </a>
                    <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('Jadwal_CRUD/pengumuman') . '>Pengumuman</a>
                      </div>
                    </div>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-graduation-cap"></i>
                      <span>Laporan</span>
                    </a>
                    <div id="collapse9" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Laporan</h6>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>1. Nilai</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>2. Afektif / Mapel</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>3. Afektif / Bulan</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>4. Ekstrakurikuler</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>5. Rapor</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/Konseling') . '>6. Konseling</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>7. Life Skill</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/ptspas') . '>8. PTS & PAS</a>
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
            Mapel
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
                  <a class="collapse-item" href=' . base_url('Tes_CRUD') . '>1. Kognitif Psikomotor</a>
                  <a class="collapse-item" href=' . base_url('Uj_CRUD') . '>2. PTS & PAS</a>
                  <a class="collapse-item" href=' . base_url('Afek_CRUD') . '>3. Afektif</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_index') . '>4. Rangkuman Nilai</a>
                  <a class="collapse-item" href=' . base_url('Laporan_CRUD/final_report') . '>5. Laporan Nilai Akhir</a>
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
                    Konselor
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fas fa-fw fa-handshake"></i>
                      <span>Konselor</span>
                    </a>
                    <div id="collapseOne3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('K_afek_CRUD') . '>1. Indikator Afektif</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD') . '>2. Topik CB</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/grade') . '>3. Nilai CB</a>
                        <a class="collapse-item" href=' . base_url('Konseling_CRUD') . '>4. Sesi Konseling</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">

                  <div class="sidebar-heading">
                    Life Skill
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fas fa-fw fa-users"></i>
                      <span>Life Skill</span>
                    </a>
                    <div id="collapseOne4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Set</h6>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/set_lifeskill') . '>1. Deskripsi Life Skill</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/emo') . '>2. Emotional & Spirituality</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">

                  <div class="sidebar-heading">
                    Rapor
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-chart-bar"></i>
                      <span>Rapor</span>
                    </a>
                    <div id="collapse9" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Report</h6>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new') . '>1. Afektif / Mapel</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/afektif_new2') . '>2. Afektif / Bulan</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/Report') . '>3. CB</a>
                        <a class="collapse-item" href=' . base_url('Konseling_CRUD/Report') . '>4. Konseling</a>
                        <a class="collapse-item" href=' . base_url('laporan_crud/Report_life') . '>5. Life Skill</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>6. Rapor (NSA)</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD/yppi') . '>7. Rapor (YPPI)</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }

        if (walkel_menu() >= 1) {
          echo ' <div class="sidebar-heading">
                    Wali Kelas
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-comment"></i>
                      <span>Wali Kelas</span>
                    </a>
                    <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Wali Kelas</h6>
                        <a class="collapse-item" href=' . base_url('Komen_CRUD') . '>1. Komentar</a>
                        <a class="collapse-item" href=' . base_url('CB_CRUD/habit_index') . '>2. Habit, Social Skill</a>
                        <a class="collapse-item" href=' . base_url('Report_CRUD') . '>3. Rapor NSA</a>
                        <a class="collapse-item" href=' . base_url('Absent_CRUD') . '>4. Absensi</a>
                        <a class="collapse-item" href=' . base_url('Review_CRUD') . '>5. Review Jurnal</a>
                        <a class="collapse-item" href=' . base_url('Review_CRUD/cancel_review') . '>6. Batalkan Review</a>
                        <a class="collapse-item" href=' . base_url('Komen_CRUD/upload_pdf_yppi') . '>7. Rapor PDF (YPPI)</a>
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
                        <a class="collapse-item" href=' . base_url('Ortu_CRUD/naik_kelas') . '>2. Kenaikan Kelas</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }

        if (ssp_menu() >= 1) {
          echo ' <div class="sidebar-heading">
                    Extrakurikuler
                  </div>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-basketball-ball"></i>
                      <span>Extrakurikuler</span>
                    </a>
                    <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Input</h6>
                        <a class="collapse-item" href=' . base_url('SSP_topik_CRUD') . '>1. Topik</a>
                        <a class="collapse-item" href=' . base_url('SSP_grade_CRUD') . '>2. Nilai</a>
                        <a class="collapse-item" href=' . base_url('Laporan_CRUD/summary_ssp_index') . '>3. Laporan Nilai</a>
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
                        <a class="collapse-item" href=' . base_url('Scout_CRUD') . '>Nilai</a>
                      </div>
                    </div>
                  </li>
                  <hr class="sidebar-divider d-none d-md-block">
            ';
        }
        echo '<div class="sidebar-heading">
                Google
              </div>
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse556" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-fw fa-envelope"></i>
                  <span>Media</span>
                </a>
                <div id="collapse556" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Input</h6>
                    <a class="collapse-item" href=' . base_url('Classroom_CRUD') . '>1. Classroom</a>
                    <a class="collapse-item" href=' . base_url('Pembelajaran_CRUD') . '>2. Pembelajaran</a>
                  </div>
                </div>
              </li>
              <hr class="sidebar-divider d-none d-md-block">
        ';

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
        // echo '<div class="sidebar-heading">
        //           Admission
        //         </div>
        //         <li class="nav-item">
        //           <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsead" aria-expanded="true" aria-controls="collapseTwo">
        //             <i class="fas fa-fw fa-book"></i>
        //             <span>Buku</span>
        //           </a>
        //           <div id="collapsead" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        //             <div class="bg-white py-2 collapse-inner rounded">
        //               <h6 class="collapse-header">Set</h6>
        //               <a class="collapse-item" href=' . base_url('Admission_CRUD/penerbit') . '>1. Penerbit</a>
        //               <a class="collapse-item" href=' . base_url('Admission_CRUD/buku') . '>2. Buku</a>
        //               <a class="collapse-item" href=' . base_url('Admission_CRUD/penjualan') . '>3. Penjualan Buku</a>
        //             </div>
        //           </div>
        //         </li>
        //         <hr class="sidebar-divider d-none d-md-block">
        //         ';

        echo '<div class="sidebar-heading">
                  Admission
                </div>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsead" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Siswa</span>
                  </a>
                  <div id="collapsead" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Lihat</h6>
                      <a class="collapse-item" href=' . base_url('Sibling_CRUD') . '>Sibling</a>
                    </div>
                  </div>
                </li>
                <hr class="sidebar-divider d-none d-md-block">';



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
