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
      zoomType: 'x',
      margin: [20, 20, 20, 20]
    },
    title: {
      text: ''
    },
    xAxis: {
      type: 'datetime',
      maxZoom: 7 * 24 * 3600000, // seven days
      title: {
        text: null
      }
    },
    yAxis: {
      title: {
        text: 'Hours Worked',
        style: {
          color: '#000000',
          fontWeight: 'bold'
        }
      },
      min: 0,
      startOnTick: false,
      showFirstLabel: false
    },
    tooltip: {
      formatter: function() {
        return ''+
          '<b>' + this.series.name + '</b><br/>' + Highcharts.dateFormat('%a., %b. %e, %Y', this.x) + ' - ' +
          Highcharts.numberFormat(this.y, 2) + ' Hours';
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
    legend: {
      enabled: false
    },

    series: [
      <?php $numseries = count($series); ?>
      <?php $count = 0; ?>
      <?php foreach ($series as $line): ?>
        {
          <?php $count++; ?>
          name: "<?php echo $line['name']; ?>",
          pointInterval: 24 * 3600 * 1000,
          pointStart: Date.UTC(
            <?php echo substr($start, 0, 4); ?>,
            <?php echo substr($start, 5, 2) - 1; ?>,
            <?php echo substr($start, 8, 2); ?>),
          data: <?php echo json_encode($line['data']); ?>
        }<?php if ($count < $numseries) echo ','; ?>
      <?php endforeach; ?>
    ]
  });


});
</script>


<div style="height: 150px;" id="chart<?php echo $rand; ?>"></div>
