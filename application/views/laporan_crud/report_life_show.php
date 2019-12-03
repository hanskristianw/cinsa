<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center mb-4">
              <h1 class="h4 text-gray-900"><u><b>Laporan Nilai Life Skill</b></u></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <?php 

              function returnMerah($nilai){
                if($nilai == "C" || $nilai == "D"){
                  return "background-color:#f2b796;";
                }
              }

              foreach($kelas_all as $n) :
                $siswa = show_life_skill_by_kelas($n['kelas_id']);
            ?>

              <h6><u><?= $n['kelas_nama'] ?></u></h6>
              <table class="rapot">
                <thead>
                  <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama</th>
                    <th colspan="2">Emotional</th>
                    <th colspan="2">Spirituality</th>
                    <th colspan="2">Moral Behaviour</th>
                    <th colspan="2">Social Skill</th>
                    <th colspan="2">Physical Fitness</th>
                  </tr>
                  <tr>
                    <th>Sem 1</th>
                    <th>Sem 2</th>
                    <th>Sem 1</th>
                    <th>Sem 2</th>
                    <th>Sem 1</th>
                    <th>Sem 2</th>
                    <th>Sem 1</th>
                    <th>Sem 2</th>
                    <th>Sem 1</th>
                    <th>Sem 2</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  foreach($siswa as $o) :
                ?>
                  <tr>
                    <td style="padding: 0px 0px 0px 5px; width: 50px;"><?= $o['sis_no_induk'] ?></td>
                    <td style="padding: 0px 0px 0px 5px; width: 250px;"><?= $o['sis_nama_depan'] .' '. $o['sis_nama_bel'] ?></td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['emo_sem1'])) ?>">
                      <?= return_abjad_base4($o['emo_sem1']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['emo_sem2'])) ?>">
                      <?= return_abjad_base4($o['emo_sem2']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['spirit_sem1'])) ?>">
                      <?= return_abjad_base4($o['spirit_sem1']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['spirit_sem2'])) ?>">
                      <?= return_abjad_base4($o['spirit_sem2']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['moralb_lo'])) ?>">
                      <?= return_abjad_base4($o['moralb_lo']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['moralb_lo2'])) ?>">
                      <?= return_abjad_base4($o['moralb_lo2']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['ss_sem1'])) ?>">
                      <?= return_abjad_base4($o['ss_sem1']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['ss_sem2'])) ?>">
                      <?= return_abjad_base4($o['ss_sem2']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['pfhf_sem1'])) ?>">
                      <?= return_abjad_base4($o['pfhf_sem1']) ?>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['pfhf_sem2'])) ?>">
                      <?= return_abjad_base4($o['pfhf_sem2']) ?>
                    </td>
                  </tr>
                  
                <?php endforeach ?>
                
                </tbody>
              </table>

              <br>

            <?php endforeach ?>


              
              
          </div>
        </div>
      </div>
    </div>
  </div>

</div>