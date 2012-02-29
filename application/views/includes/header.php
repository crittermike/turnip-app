<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

  <title><?=$title?> | Turnip</title>

  <link rel="stylesheet" href="/public/stylesheets/jqueryui.css" />
  <link rel="stylesheet" href="/public/stylesheets/pretty.css" />

  <link rel="shortcut icon" type="image/x-icon" href="/public/images/favicon.png">

  <!-- jQuery and jQuery UI -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js" type="text/javascript"></script>

  <!-- jQuery plugins -->
  <script src="/public/javascript/plugins/jquery.infieldlabels.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.jeditable.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.jeditable.datepicker.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.form.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.tablesort.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.autocomplete.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.gritter.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.timeconvert.js" type="text/javascript"></script>
  <script src="/public/javascript/plugins/jquery.highcharts.js" type="text/javascript"></script>

  <!-- Custom stuff -->
  <script src="/public/javascript/global.js" type="text/javascript"></script>
  <script src="/public/javascript/tasks.js" type="text/javascript"></script>
  <script src="/public/javascript/time.js" type="text/javascript"></script>
  <script src="/public/javascript/projects.js" type="text/javascript"></script>

</head>
<body <?php if (!$this->tank_auth->is_logged_in()) echo 'class="anonymous"'; ?>>

  <p id="account-links"><a href="/auth/account">your account</a> &nbsp;&nbsp; <a href="/auth/logout">logout</a></p>

  <div id="header">

    <ul id="nav">

      <?php $url = $this->uri->segment(1); ?>

      <li class="first<?php if ($url == '' || $url == 'time') echo ' active';?>">
        <a href="/time">Time</a>
      </li>

      <li <?php if ($url == 'tasks') echo 'class="active"';?>>
        <a href="/tasks">Tasks</a>
      </li>

      <li class="last<?php if ($url == 'projects') echo ' active';?>">
        <a href="/projects">Projects</a>
      </li>

    </ul>

    <?php if ($this->tank_auth->is_logged_in()): ?>
      <?php
      $time = array(
        'name'	=> 'timeform-time',
        'id'	  => 'timeform-time',
        'tabindex' => '1',
      );
      $project = array(
        'name'	=> 'timeform-project',
        'id'	  => 'timeform-project',
        'tabindex' => '2',
        'value' => isset($task->project) ? $task->project : ''
      );
      $description = array(
        'name'	=> 'timeform-description',
        'id'	  => 'timeform-description',
        'tabindex' => '3',
        'value' => isset($task->title) ? $task->title : ''
      );
      $submit = array(
        'name'	=> 'submit',
        'value' => 'submit',
        'type'  => 'submit',
        'content' => 'Add Time',
        'id'    => 'timeform-submit'
      );
      ?>
      <?php $attributes = array('class' => 'alignright', 'id' => 'addtime-form'); ?>
      <?php echo form_open('time/add', $attributes); ?>
        <div class="form">
          <span class="one">
            <?php echo form_label('0:45', 'timeform-time'); ?>
            <?php echo form_input($time); ?>
          </span>
          <span class="two">
            <?php echo form_label('XYZ Project', 'timeform-project'); ?>
            <?php echo form_input($project); ?>
          </span>
          <span class="three">
            <?php echo form_label('What were you working on?', 'timeform-description'); ?>
            <?php echo form_input($description); ?>
          </span>
          <span class="submit">
            <?php echo form_button($submit); ?>
          </span>
        </div>
      <?php echo form_close(); ?>
    <?php endif; ?>

  </div>


	<div id="container">

    <noscript>
      <div class="status error">JavaScript is required 'round here. Please? :)</div>
    </noscript>
