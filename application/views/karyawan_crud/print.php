<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div id="print_area">
              <?php
                $tanggal_ttd = date('d-m-Y');

                $tanggal_arr = explode("-",$tanggal_ttd);

                function return_garis($a){
                  if($a == "")
                    return "____________________________________________________________________________________";
                  elseif($a == "0000-00-00")
                    return "____________________________________________________________________________________";
                  else
                    return $a;
                }
              ?>
              <table class="hrd">
                <tr>
                  <th style='width: 180px;'>
                    YPPI <br>
                    <img src="<?= base_url('assets/img/profile/yppi.png'); ?>" width="100px" class="img-fluid rounded-circle"><br>
                    SURABAYA
                  </th>
                  <td style="font-size:18px;text-align:center;font-weight:550; vertical-align:top; padding: 30px 0px 0px 0px;">
                    LAPORAN STATUS KARYAWAN <br> No:
                  </td>
                  <td style="font-size:14px;text-align:center;font-weight:550; vertical-align:top; padding: 30px 0px 0px 0px;">
                    DIVISI <br> SDM & HUKUM <br> Tgl:
                    <?= $tanggal_arr[0] .' '. return_nama_bulan_indo($tanggal_arr[0]) .' '.$tanggal_arr[2] ?>
                  </td>
                </tr>
                <tr>
                  <td style="border: none; padding: 10px 0px 0px 10px;">Nama Lengkap</td>
                  <td colspan="2" style="border: none; padding: 10px 0px 0px 0px;">: <?= $kr_update['kr_nama_depan'] .' '. $kr_update['kr_nama_belakang'] ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Agama</td>
                  <td colspan="2" style="border: none;">: </td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Unit</td>
                  <td colspan="2" style="border: none;">: <?= $kr_update['sk_nama'] ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Status Kepegawaian</td>
                  <td colspan="2" style="border: none;">: </td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Jabatan</td>
                  <td colspan="2" style="border: none;">: </td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Tanggal Mulai bekerja</td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_mulai_tgl']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Telp</td>
                  <td style="border: none;" colspan="2">HP:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;"></td>
                  <td style="border: none;" colspan="2">Rumah:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 15px 0px 0px 10px;"><b>PERUBAHAN STATUS</b></td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Data karyawan</td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">No. NPWP</td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_npwp']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">No. Rekening BCA</td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_bca']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Status Perkawinan</td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Tanggal Menikah</td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Nama Suami/istri</td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_nama_pasangan']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Nama Anak</td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_anak1']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Tempat/tgl lahir:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_anak2']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Tempat/tgl lahir:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_anak3']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Tempat/tgl lahir:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_anak4']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Tempat/tgl lahir:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Lain-lain</td>
                  <td colspan="2" style="border: none;">: ____________________________________________________________________________________</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Tanggal:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Alamat</td>
                  <td colspan="2" style="border: none;">:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Alamat KTP</td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_alamat_ktp']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Alamat tinggal sekarang</td>
                  <td colspan="2" style="border: none;">: <?= return_garis($kr_update['kr_alamat_tinggal']) ?></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 10px;">Pendidikan</td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Saat masuk YPPI</td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Alumni:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Lulus Tahun:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Pendidikan saat ini</td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Alumni:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;"></td>
                  <td colspan="2" style="border: none;">Lulus Tahun:</td>
                </tr>
                <tr>
                  <td style="border: none; padding: 0px 0px 0px 15px;">Lain-lain</td>
                  <td colspan="2" style="border: none;"></td>
                </tr>
                <tr>
                  <td colspan="3" style="border: none; padding: 15px 0px 0px 10px;">Demikian laporan status karyawan ini saya buat dengan sebenarnya dengan dilampiri bukti yang ada</td>
                </tr>
                <tr>
                  

                  <td colspan="3" style="border: none; padding: 0px 0px 0px 10px;">
                    <br>Surabaya, <?= $tanggal_arr[0] .' '. return_nama_bulan_indo($tanggal_arr[0]) .' '.$tanggal_arr[2] ?><br>
                    Yang melaporkan,<br><br><br>
                    _____________________________________________<br>
                    <?= $kr_update['kr_nama_depan'] .' '. $kr_update['kr_nama_belakang'] ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="border: none; padding: 0px 0px 0px 10px;"><br>
                    <i>
                    <b><u>Lampiran:</u></b><br>
                    * Foto Copy KTP <br>
                    * Foto Copy KSK <br>
                    * Ijazah terakhir & Sertifikat lain <br>
                    * Akta kematian suami/istri (jika ada) <br>
                    * Foto Copy semua SK yg diterbitkan YPPI <br>
                    &nbsp Mulai awal sampai sekarang</i>
                  </td>
                  <td style="border: none;">
                    <i>
                    * Pas foto 4x6 2 Lembar <br>
                    * Foto Copy No Rek BCA <br>
                    * Foto Copy NPWP <br>
                    * Foto Copy Kartu BPJS</i>
                  </td>
                </tr>
              </table>

            </div>
            <br>
            <input type="button" name="print_rekap" id="print_rekap" class="btn btn-success" value="Print">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
