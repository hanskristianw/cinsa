<style>
  table.dataTable td {
    padding: 0px;
  }
</style>

<?php
  function time_duration($seconds, $use = null, $zeros = false)
  {
      // Define time periods
      $periods = array (
          'years'     => 31556926,
          'Months'    => 2629743,
          'weeks'     => 604800,
          'days'      => 86400,
          'hours'     => 3600,
          'minutes'   => 60,
          'seconds'   => 1
          );

      // Break into periods
      $seconds = (float) $seconds;
      $segments = array();
      foreach ($periods as $period => $value) {
          if ($use && strpos($use, $period[0]) === false) {
              continue;
          }
          $count = floor($seconds / $value);
          if ($count == 0 && !$zeros) {
              continue;
          }
          $segments[strtolower($period)] = $count;
          $seconds = $seconds % $value;
      }

      // Build the string
      $string = array();
      foreach ($segments as $key => $value) {
          $segment_name = substr($key, 0, -1);
          $segment = $value . ' ' . $segment_name;
          if ($value != 1) {
              $segment .= 's';
          }
          $string[] = $segment;
      }

      return implode(', ', $string);
  }
?>


<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg">
              <div class="p-5 overflow-auto">
                  <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4"><u>Employee Login Activity</u></h1>
                  </div>
                  
                  <?= $this->session->flashdata('message'); ?>

                  <table class="table-bordered dt compact">
                    <thead class="bg-info text-white">
                      <tr>
                        <th style='padding: 10px 0px 10px 15px; width: 100px;'>First Name</th>
                        <th style='padding: 10px 0px 10px 15px; width: 200px;'>Last Name</th>
                        <th style='padding: 10px 0px 10px 15px; width: 170px;'>Unit</th>
                        <th style='padding: 10px 0px 10px 15px;'>Last Login</th>
                        <th style='padding: 10px 0px 10px 15px;'>From</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($kr_all as $m) : 

                        $now = date("Y/m/d H:i:s");

                        $datetime1 = strtotime($m['kr_last_login']);
                        $datetime2 = strtotime($now);

                        $secs = $datetime2 - $datetime1;// == <seconds between the two times>
                        //$days = $secs / 86400;
                      ?>
                        
                        <tr>
                          <td style='padding: 5px 5px 0px 10px;'><?= $m['kr_nama_depan'] ?></td>
                          <td style='padding: 5px 5px 0px 10px;'><?= $m['kr_nama_belakang'] ?></td>
                          <td style='padding: 5px 5px 0px 10px;'><?= ucfirst(strtolower($m['sk_nama'])) ?></td>
                          

                          <?php if($secs > 1500000000): ?>
                            <td style='padding: 5px 5px 0px 10px;'>Never</td>
                          <?php else: ?>
                            <td style='padding: 5px 5px 0px 10px;'><?= time_duration($secs) ?> ago</td>
                          <?php endif; ?>
                          
                          <?php if($m['kr_last_login_ip']): ?>
                            <td style='padding: 5px 5px 0px 10px; width: 100px;'><?= $m['kr_last_login_ip'] ?></td>
                          <?php else: ?>
                            <td style='padding: 5px 5px 0px 10px; width: 100px;'>-</td>
                          <?php endif; ?>
                          
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                  <hr>
              </div>
            </div>
        </div>
        </div>
    </div>

</div>
