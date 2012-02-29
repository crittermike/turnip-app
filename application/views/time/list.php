<div class="block">
  <div class="block-header"><h2>All Your Time</h2></div>
  <div class="block-content"><?php echo $allgraph; ?></div>
</div>

<div id="time-filter" class="hide">
	<h3><a href="#">Change Timeframe</a></h3>

	<div>
    <?php
    $startdate = array(
      'name'	=> 'time-start',
      'id'	  => 'time-start',
      'value' => $start
    );
    $enddate = array(
      'name'	=> 'time-end',
      'id'	  => 'time-end',
      'value' => $end
    );
    $submit = array(
      'name'	=> 'submit',
      'value' => 'submit',
      'type'  => 'submit',
      'content' => 'Update',
      'id'    => 'time-submit'
    );
    ?>
    <?php $attributes = array('class' => 'alignleft', 'id' => 'datefilter-form'); ?>
    <?php echo form_open('time', $attributes); ?>
      <span class="one">
        <?php echo form_label('Start Date', 'time-start'); ?>
        <?php echo form_input($startdate); ?>
      </span>
      <span class="two">
        <?php echo form_label('XYZ Project', 'time-end'); ?>
        <?php echo form_input($enddate); ?>
      </span>
      <span class="submit">
        <?php echo form_button($submit); ?>
      </span>
    <?php echo form_close(); ?>
	</div>

</div>

<div class="block first twothird">
  <div class="block-header"><h2>Time List</h2></div>
  <div class="block-content">
    <table cellpadding="0" cellspacing="0" id="time-list">
      <thead>
        <tr>
          <th>When</th>
          <th>Time</th>
          <th>Project</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($entries as $entry): ?>
          <tr>
            <td>
              <div id="date-<?php echo $entry->time_id; ?>" class="timetable-date"><?php echo $entry->date; ?></div>
            </td>
            <td>
              <div id="time-<?php echo $entry->time_id; ?>" class="timetable-time"><?php echo $entry->duration; ?></div>
            </td>
            <td>
              <div id="project-<?php echo $entry->time_id; ?>" class="timetable-project"><?php echo $entry->name; ?></div>
            </td>
            <td>
              <div id="description-<?php echo $entry->time_id; ?>" class="timetable-description"><?php echo $entry->description; ?></div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="block second onethird">
  <div class="block-header"><h2>Today - <?php echo decimal_to_time($daytotal); ?></h2></div>
  <div class="block-content"><?php echo $daygraph; ?></div>
</div>

<div class="block second onethird">
  <div class="block-header"><h2>This Week - <?php echo decimal_to_time($weektotal); ?></h2></div>
  <div class="block-content"><?php echo $weekgraph; ?></div>
</div>

<div class="block second onethird">
  <div class="block-header"><h2>This Month - <?php echo decimal_to_time($monthtotal); ?></h2></div>
  <div class="block-content"><?php echo $monthgraph; ?></div>
</div>
