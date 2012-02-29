<div class="block first center">
  <div class="block-header"><h2>Change Your Password</h2></div>
  <div class="block-content">
    <?php
    $old_password = array(
      'name'	=> 'old_password',
      'id'	=> 'old_password',
      'value' => set_value('old_password'),
      'size' 	=> 30,
    );
    $new_password = array(
      'name'	=> 'new_password',
      'id'	=> 'new_password',
      'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
      'size'	=> 30,
    );
    $confirm_new_password = array(
      'name'	=> 'confirm_new_password',
      'id'	=> 'confirm_new_password',
      'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
      'size' 	=> 30,
    );
    $submit = array(
      'name' => 'change',
      'type' => 'submit',
      'content' => 'Change Password'
    );
    ?>

    <?php $valerrors = validation_errors(); ?>

    <?php if ($errors || $valerrors): ?>
      <div class="status error">
        <?php echo $valerrors; ?>

        <?php foreach ($errors as $error): ?>
          <?php echo $error; ?>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>

    <?php echo form_open($this->uri->uri_string()); ?>
      <p>
        <?php echo form_label('Old Password', $old_password['id']); ?>
        <?php echo form_password($old_password); ?>
      </p>
      <p>
        <?php echo form_label('New Password', $new_password['id']); ?>
        <?php echo form_password($new_password); ?>
      </p>
      <p>
        <?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
        <?php echo form_password($confirm_new_password); ?>
      </p>

      <?php echo form_button($submit); ?>

    <?php echo form_close(); ?>
  </div>
</div>
