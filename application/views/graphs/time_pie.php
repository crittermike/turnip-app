<?php if (count($sumtimes) > 0): ?>

  <?php $rand = rand(0, 100000); ?>

  <script type="text/javascript">

    Highcharts.setOptions({
      colors: [
        '#556270',
        '#4ECDC4',
        '#C7F464',
        '#FF6B6B',
        '#C44D58'
      ]
    });

    var chart;
    $(document).ready(function() {
      chart = new Highcharts.Chart({
        chart: {
          renderTo: 'chart<?php echo $rand; ?>',
          margin: [0, 0, 0, 0]
        },
        title: {
          text: ''
        },
        plotArea: {
          shadow: null,
          borderWidth: null,
          backgroundColor: null
        },
        tooltip: {
          formatter: function() {
            return '<b>' + this.point.name + '</b>: '+ this.y +' Hours';
          },
          backgroundColor: {
            linearGradient: [0, 0, 0, 50],
            stops: [
              [0, 'rgba(60, 60, 60, .9)'],
              [1, 'rgba(21, 21, 21, .8)']
            ]
          },
          borderWidth: 0,
          style: {
            color: '#FFF'
          }
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
              enabled: false
            }
          }
        },
        legend: {
          enabled: false
        },
        series: [{
          type: 'pie',
          name: 'Time Usage',
          data: [
            <?php $numseries = count($sumtimes); ?>

            <?php $count = 0; ?>

            <?php foreach ($sumtimes as $project => $time): ?>
              [
                <?php $count++; ?>
                <?php echo "'" . $project . "', " . $time; ?>
              ]<?php if ($count < $numseries) echo ','; ?>
            <?php endforeach; ?>

          ]
        }]
      });
    });
  </script>

  <div style="height: 150px;" id="chart<?php echo $rand; ?>"></div>

<?php else: ?>
  <h3 class="aligncenter">No time tracked.</h3>
<?php endif; ?>
