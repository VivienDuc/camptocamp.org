<?php use_helper('Form', 'MyForm', 'Ajax', 'Link', 'JavascriptQueue', 'MyMinify'); ?>

<div id="fake_div">

<?php
// handle non ajax error form
echo global_form_errors_tag();

//echo form_tag('@user_edit');
echo c2c_form_remote_tag('@signUp');

echo tips_tag('After subscription you will receive an email with a generated password, to confirm, login within %1% days',
              array('%1%' => sfConfig::get('app_pending_users_lifetime')));

echo group_tag('Username:', 'login_name', 'input_tag', $sf_params->get('login_name'), array('autofocus' => 'autofocus', 'class' => 'long_input'));
echo group_tag('Email:', 'email', 'input_tag', $sf_params->get('email'), array('class' => 'long_input', 'type' => 'email'));
echo content_tag('div', __('Did you mean %1%?', array('%1%' => '<a class="suggested-email"></a>')),
                 array('class' => 'email-suggestion', 'style' => 'display:none'));
echo group_tag('Copy following string:', 'captcha', 'input_tag', null, array('class' => 'long_input')); ?>
    <img src="<?php echo url_for('@sf_captcha'); ?>" alt="captcha" title="<?php echo __('Copy following string:') ?>" />
    <p class="tips"><?php echo __('captcha test is case-insensitive') ?></p>
  <p style="margin-top:20px"><?php echo c2c_submit_tag(__('Signup')) ?> <?php echo login_link_to() ?></p>
</form>
<?php
// load mailcheck, helps users correctly entering their email
echo javascript_queue("$.ajax({ url: '" . minify_get_combined_files_url(array('/static/js/mailcheck.min.js', '/static/js/mailcheck.c2c.js')) . "',
dataType: 'script', cache: true });");
