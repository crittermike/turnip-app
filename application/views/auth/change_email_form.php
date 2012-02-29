<div class="block first center">
  <div class="block-header"><h2>Change Your Email Address</h2></div>
  <div class="block-content">
    <?php
    $password = array(
      'name'  => 'password',
      'id'  => 'password',
      'size'  => 30,
    );
    $email = array(
      'name'  => 'email',
      'id'  => 'email',
      'value'  => set_value('email'),
      'maxlength'  => 80,
      'size'  => 30,
    );
    $submit = array(
      'name' => 'change',
      'type' => 'submit',
      'content' => 'Send confirmation email'
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
        <?php echo form_label('Password', $password['id']); ?>
        <?php echo form_password($password); ?>
      </p>
      <p>
        <?php echo form_label('New email address', $email['id']); ?>
        <?php echo form_input($email); ?>
      </p>

      <?php echo form_button($submit); ?>

    <?php echo form_close(); ?>
  </div>
</div>
