<div class="block first center">
  <div class="block-header"><h2>Delete Your Turnip Account</h2></div>
  <div class="block-content">
    <?php
    $password = array(
      'name'  => 'password',
      'id'  => 'password',
      'size'  => 30,
    );
    $submit = array(
      'name' => 'cancel',
      'type' => 'submit',
      'content' => 'Delete account'
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

      <?php echo form_button($submit); ?>

    <?php echo form_close(); ?>
  </div>
</div>
