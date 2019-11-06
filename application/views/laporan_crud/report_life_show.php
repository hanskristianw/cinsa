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
                      <a href='javascript:void(0)' class="emo-sem1" rel='<?= $o['emo_aware_ex'] ?>' rel2='<?= $o['emo_aware_so'] ?>' rel3='<?= $o['emo_aware_ne'] ?>'>
                        <?= return_abjad_base4($o['emo_sem1']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['emo_sem2'])) ?>">
                      <a href='javascript:void(0)' class="emo-sem2" rel='<?= $o['emo_aware_ex2'] ?>' rel2='<?= $o['emo_aware_so2'] ?>' rel3='<?= $o['emo_aware_ne2'] ?>'>
                        <?= return_abjad_base4($o['emo_sem2']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['spirit_sem1'])) ?>">
                      <a href='javascript:void(0)' class="spr-sem1" rel='<?= $o['spirit_coping'] ?>' rel2='<?= $o['spirit_emo'] ?>' rel3='<?= $o['spirit_grate'] ?>' rel4='<?= $o['spirit_ref'] ?>'>
                        <?= return_abjad_base4($o['spirit_sem1']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['spirit_sem2'])) ?>">
                      <a href='javascript:void(0)' class="spr-sem2" rel='<?= $o['spirit_coping2'] ?>' rel2='<?= $o['spirit_emo2'] ?>' rel3='<?= $o['spirit_grate2'] ?>' rel4='<?= $o['spirit_ref2'] ?>'>
                        <?= return_abjad_base4($o['spirit_sem2']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['mb_sem1'])) ?>">
                      <a href='javascript:void(0)' class="mb-sem1" rel='<?= $o['moralb_lo'] ?>' rel2='<?= $o['moralb_so'] ?>'>
                        <?= return_abjad_base4($o['mb_sem1']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['mb_sem2'])) ?>">
                      <a href='javascript:void(0)' class="mb-sem2" rel='<?= $o['moralb_lo2'] ?>' rel2='<?= $o['moralb_so2'] ?>'>
                        <?= return_abjad_base4($o['mb_sem2']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['ss_sem1'])) ?>">
                      <a href='javascript:void(0)' class="ss-sem1" rel='<?= $o['ss_relationship'] ?>' rel2='<?= $o['ss_cooperation'] ?>' rel3='<?= $o['ss_conflict'] ?>' rel4='<?= $o['ss_self_a'] ?>'>
                        <?= return_abjad_base4($o['ss_sem1']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['ss_sem2'])) ?>">
                      <a href='javascript:void(0)' class="ss-sem2" rel='<?= $o['ss_relationship2'] ?>' rel2='<?= $o['ss_cooperation2'] ?>' rel3='<?= $o['ss_conflict2'] ?>' rel4='<?= $o['ss_self_a2'] ?>'>
                        <?= return_abjad_base4($o['ss_sem2']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['pfhf_sem1'])) ?>">
                      <a href='javascript:void(0)' class="pf-sem1" rel='<?= $o['pfhf_absent'] ?>' rel2='<?= $o['pfhf_uks'] ?>' rel3='<?= $o['pfhf_tardiness'] ?>'>
                        <?= return_abjad_base4($o['pfhf_sem1']) ?>
                      </a>
                    </td>
                    <td style="text-align:center;<?= returnMerah(return_abjad_base4($o['pfhf_sem2'])) ?>">
                      <a href='javascript:void(0)' class="pf-sem2" rel='<?= $o['pfhf_absent2'] ?>' rel2='<?= $o['pfhf_uks2'] ?>' rel3='<?= $o['pfhf_tardiness2'] ?>'>
                        <?= return_abjad_base4($o['pfhf_sem2']) ?>
                      </a>
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

<script type = "text/javascript">
  $(document).ready(function () {
    $(".emo-sem1").on('click', function () {
      var emo_aware_ex = $(this).attr("rel");
      var emo_aware_so = $(this).attr("rel2");
      var emo_aware_ne = $(this).attr("rel3");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Expressive</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(emo_aware_ex)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Self Control</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(emo_aware_so)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Negative Emotions</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(emo_aware_ne)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".emo-sem2").on('click', function () {
      var emo_aware_ex = $(this).attr("rel");
      var emo_aware_so = $(this).attr("rel2");
      var emo_aware_ne = $(this).attr("rel3");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Expressive</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(emo_aware_ex)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Self Control</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(emo_aware_so)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Negative Emotions</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(emo_aware_ne)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".spr-sem1").on('click', function () {
      var cop = $(this).attr("rel");
      var res = $(this).attr("rel2");
      var gra = $(this).attr("rel3");
      var ref = $(this).attr("rel4");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Coping Adversities</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(cop)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Emotional Resilience</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(res)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Grateful</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(gra)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Reflective</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(ref)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".spr-sem2").on('click', function () {
      var cop = $(this).attr("rel");
      var res = $(this).attr("rel2");
      var gra = $(this).attr("rel3");
      var ref = $(this).attr("rel4");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Coping Adversities</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(cop)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Emotional Resilience</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(res)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Grateful</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(gra)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Reflective</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(ref)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".mb-sem1").on('click', function () {
      var lo = $(this).attr("rel");
      var so = $(this).attr("rel2");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Light Offences</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(lo)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Severe Offences</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(so)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".mb-sem2").on('click', function () {
      var lo = $(this).attr("rel");
      var so = $(this).attr("rel2");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Light Offences</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(lo)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Severe Offences</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(so)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".ss-sem1").on('click', function () {
      var re = $(this).attr("rel");
      var coop = $(this).attr("rel2");
      var con = $(this).attr("rel3");
      var sa = $(this).attr("rel4");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Relationship</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(re)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Cooperation</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(coop)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Conflict</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(con)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Self-Appraisal</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(sa)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".ss-sem2").on('click', function () {
      var re = $(this).attr("rel");
      var coop = $(this).attr("rel2");
      var con = $(this).attr("rel3");
      var sa = $(this).attr("rel4");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Relationship</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(re)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Cooperation</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(coop)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Conflict</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(con)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Self-Appraisal</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(sa)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".pf-sem1").on('click', function () {
      var ab = $(this).attr("rel");
      var uks = $(this).attr("rel2");
      var tar = $(this).attr("rel3");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Absent</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(ab)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>UKS</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(uks)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Tardy</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(tar)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });

    $(".pf-sem2").on('click', function () {
      var ab = $(this).attr("rel");
      var uks = $(this).attr("rel2");
      var tar = $(this).attr("rel3");

      $("#judul_modal").html("Detail Nilai");

      var html = '';
      html += "<table class='rapot'>";
      html += "<thead>";
      html += "<tr>";
      html += "<th>Jenis</th>";
      html += "<th>Nilai</th>";
      html += "</tr>";
      html += "</thead>";
      html += "<tbody>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Absent</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(ab)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>UKS</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(uks)+"</td>";
      html += "</tr>";
      html += "<tr>";
      html += "<td style='padding: 0px 0px 0px 5px;'>Tardy</td>";
      html += "<td style='text-align:center;'>"+returnNilaiLF(tar)+"</td>";
      html += "</tr>";
      html += "</tbody>";
      html += "</table>";
      
      $('#isi_modal').html(html);
      $("#myModal").show();

    });
    
    
    function returnNilaiLF(nilai){
      if(nilai=="4")
        return "A";
      else if(nilai=="3")
        return "B";
      else if(nilai=="2")
        return "C";
      else if(nilai=="1")
        return "D"
      else
        return " ";
    }

  });
</script>