<?php
$title = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'value' => set_value('title')
);
$project = array(
	'name'	=> 'project',
	'id'	=> 'project',
	'value' => set_value('project')
);
$description = array(
	'name'	=> 'description',
	'id'	=> 'description',
	'value' => set_value('description')
);
$tags = array(
	'name'	=> 'tags',
	'id'	=> 'tags',
	'value' => set_value('tags')
);
$submit = array(
	'name'	=> 'submit',
	'content' => 'Add It!',
	'type' => 'submit',
	'class' => 'right'
);
?>

<div class="block first center">
  <div class="block-header"><h2>Create a Task</h2></div>
  <div class="block-content">
    <?php $errors = validation_errors(); ?>
    <?php if ($errors): ?>
      <div class="status error"><?php echo $errors; ?></div>
    <?php endif; ?>

    <?php $attributes = array('class' => 'alignleft', 'id' => 'addtask-form'); ?>
    <?php echo form_open_multipart('tasks/add', $attributes); ?>
      <span>
        <?php echo form_label('Title', 'title'); ?>
        <?php echo form_input($title); ?>
      </span>
      <span>
        <?php echo form_label('Project', 'project'); ?>
        <?php echo form_input($project); ?>
      </span>
      <span>
        <?php echo form_label('Description', 'description'); ?>
        <?php echo form_textarea($description); ?>
      </span>
      <span>
        <?php echo form_label('Tag1 Tag2 Tag3', 'tags'); ?>
        <?php echo form_input($tags); ?>
      </span>
      <?php echo form_button($submit); ?>

    <?php echo form_close(); ?>
  </div>
</div>
