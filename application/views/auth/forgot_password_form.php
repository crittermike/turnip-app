<div class="block first center">
  <div class="block-header"><h2>Forgot Your Password?</h2></div>
  <div class="block-content">
    <?php
    $login = array(
      'name'	=> 'login',
      'id'	=> 'login',
      'value' => set_value('login'),
      'maxlength'	=> 80,
      'size'	=> 30,
    );
    $submit = array(
      'name' => 'reset',
      'type' => 'submit',
      'content' => 'Get a new password'
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
        <?php echo form_label("Email", $login['id']); ?>
        <?php echo form_input($login); ?>
      </p>
        <?php echo form_button($submit); ?>

    <?php echo form_close(); ?>
  </div>
</div>
