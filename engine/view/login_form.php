<form method="post" action="" id="login_form" class="login_form">
<?php if(isset($data['error']['not_login'])){ ?>
  <p class="error"><?=$data['error']['not_login']?></p>
  <?php } ?>
  <div class="label_field">
    <label for="login"><?=$this->fLang('_login_')?></label>
    <input type="text" class="inp_field chek_data" id="login" name="login" value="<?=$this->checkData($data,'data','login')?>" />
    <p class="error login"><?=$this->checkData($data,'error','login')?></p>
  </div>
  <div class="label_field">
    <label for="password"><?=$this->fLang('_password_')?></label>
    <input type="password" class="inp_field chek_data" id="password" name="password" />
    <p class="error password"><?=$this->checkData($data,'error','password')?></p>
  </div>
  <div>
    <input type="submit" class="butt" value="<?=$this->fLang('_log_in_')?>" />
  </div>
  
  <a href="<?=$this->getLink()?>/registration" class="link_reg"><?=$this->fLang('_register_')?></a>
</form>

<div class="hide out_field"><?=$this->fLang('_out_field_');?></div>