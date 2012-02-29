<div class="block first center">
  <div class="block-header"><h2>Log In To <?=get_subdomain()?>'s Turnip</h2></div>
  <div class="block-content">
    <?php
    $login = array(
      'name'  => 'login',
      'id'  => 'login',
      'value' => set_value('login'),
      'maxlength'  => 80,
      'size'  => 30,
    );
    $login_label = 'Email';
    $password = array(
      'name'  => 'password',
      'id'  => 'password',
      'size'  => 30,
    );
    $remember = array(
      'name'  => 'remember',
      'id'  => 'remember',
      'value'  => 1,
      'checked'  => set_value('remember'),
      'style' => 'margin:0;padding:0',
    );
    $captcha = array(
      'name'  => 'captcha',
      'id'  => 'captcha',
      'maxlength'  => 8,
    );
    $submit = array(
      'name' => 'submit',
      'type' => 'submit',
      'content' => 'Come On In'
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
        <?php echo form_label($login_label, $login['id']); ?>
        <?php echo form_input($login); ?>
      </p>
      <p>
        <?php echo form_label('Password', $password['id']); ?>
        <?php echo form_password($password); ?>
      </p>
      <p>
        <?php echo form_checkbox($remember); ?>
        <?php echo form_label('Remember me', $remember['id']); ?>&nbsp;&nbsp;&nbsp;
        <?php echo form_button($submit); ?>
      </p>
      <p class="center">
        Or did you <?php echo anchor('/auth/forgot_password/', 'forget your password'); ?>?
      </p>

    <?php echo form_close(); ?>
  </div>
</div>
