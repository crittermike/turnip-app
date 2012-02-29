<div class="block first center">
  <div class="block-header"><h2>Register For <?=get_subdomain()?>'s Turnip</h2></div>
  <div class="block-content">
    <?php /*
    $email = array(
      'name'  => 'email',
      'id'  => 'email',
      'value'  => set_value('email'),
      'maxlength'  => 80,
      'size'  => 30,
    );
    $password = array(
      'name'  => 'password',
      'id'  => 'password',
      'value' => set_value('password'),
      'maxlength'  => $this->config->item('password_max_length', 'tank_auth'),
      'size'  => 30,
    );
    $confirm_password = array(
      'name'  => 'confirm_password',
      'id'  => 'confirm_password',
      'value' => set_value('confirm_password'),
      'maxlength'  => $this->config->item('password_max_length', 'tank_auth'),
      'size'  => 30,
    );
    $subdomain = array(
      'name'  => 'subdomain',
      'id'  => 'subdomain',
      'value' => set_value('subdomain'),
      'maxlength'  => 16,
      'size'  => 30,
    );
    $submit = array(
      'name' => 'register',
      'type' => 'submit',
      'content' => 'Register'
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
        <?php echo form_label('Email Address', $email['id']); ?>
        <?php echo form_input($email); ?>
      </p>

      <p>
        <?php echo form_label('Password', $password['id']); ?>
        <?php echo form_password($password); ?>
      </p>

      <p>
        <?php echo form_label('Confirm Password', $confirm_password['id']); ?>
        <?php echo form_password($confirm_password); ?>
      </p>

      <p>
        <?php echo form_label('goturnip.com Subdomain', $subdomain['id']); ?>
        <?php echo form_input($subdomain); ?>
      </p>

      <p>
        <?php echo form_button($submit); ?>
      </p>

    <?php echo form_close(); */?>

    <h3 class="aligncenter">Registration is closed.</h3>
  </div>
</div>
