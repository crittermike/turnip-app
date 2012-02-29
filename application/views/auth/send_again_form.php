<div class="block first center">
  <div class="block-header"><h2>Resend The Activation Email</h2></div>
  <div class="block-content">
    <?php
    $email = array(
      'name'  => 'email',
      'id'  => 'email',
      'value'  => set_value('email'),
      'maxlength'  => 80,
      'size'  => 30,
    );
    $submit = array(
      'name' => 'send',
      'type' => 'submit',
      'content' => 'Send'
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
      <?php echo form_button($submit); ?>
    <?php echo form_close(); ?>
  </div>
</div>
