<?php
$content = array(
	'name'	=> 'content',
	'id'	=> 'content',
	'value' => set_value('content')
);
$submit = array(
	'name'	=> 'submit',
	'id'	  => 'submit',
	'value' => 'submit',
	'content' => 'Save',
	'type' => 'submit',
	'class' => 'right'
);
$submitclose = array(
	'name'	=> 'submitclose',
	'id'	  => 'submitclose',
	'value' => 'submitclose',
	'content' => 'Save And Close Task',
	'type' => 'submit',
	'class' => 'right'
);
$submitopen = array(
	'name'	=> 'submitopen',
	'id'	  => 'submitopen',
	'value' => 'submitopen',
	'content' => 'Save And Reopen Task',
	'type' => 'submit',
	'class' => 'right hide'
);
?>

<?php $errors = validation_errors(); ?>
<?php if ($errors): ?>
  <div class="status error"><?php echo $errors; ?></div>
<?php endif; ?>

  <?php $attributes = array('class' => 'alignleft', 'id' => 'addcomment-form'); ?>
  <?php echo form_open('comments/add', $attributes); ?>

    <div class="form">
      <?php echo form_textarea($content); ?>

      <?php echo form_hidden('task_id', $task->id); ?>

      <?php echo form_button($submitclose); ?>
      <?php echo form_button($submitopen); ?>
      <?php echo form_button($submit); ?>
    </div>
  <?php echo form_close(); ?>
