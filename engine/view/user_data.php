<div class="user_data">
  <div><a href="<?=$this->getLink()?>/logout" class="link_reg"><?=$this->fLang('_logout_')?></a></div>
  
  <?php if(!is_null($data['photo'])) { ?>
    <div class="center"><img src="/uploads/<?=$data['photo']?>" /></div>
  <?php } ?>
  
  <div class="label_field">
    <b class="label"><?=$this->fLang('_username_')?>:</b> <?=$data['username']?>
  </div>
  
  <div class="label_field">
    <b class="label"><?=$this->fLang('_gender_')?>:</b> <?=$this->fLang(($data['gender']==1)?'_male_':'_female_')?>
  </div>
  
  <div class="label_field">
    <b class="label"><?=$this->fLang('_date_birth_')?>:</b> <?=$data['date_birth']?>
  </div>
  
  <div class="label_field about">
    <b class="label"><?=$this->fLang('_about_')?>:</b> <?=$data['about']?>
  </div>
  
  
  
  <div class="label_field">
    <b class="label"><?=$this->fLang('_email_')?>:</b> <?=$data['email']?>
  </div>
  
  <?php if(!is_null($data['phone'])) { ?>
    <div><b class="label"><?=$this->fLang('_phone_')?>:</b> <?=$data['phone']?></div>
  <?php } ?>
  
  <div class="label_field">
    <b class="label"><?=$this->fLang('_date_reg_')?>:</b> <?=$data['date_reg']?>
  </div>
  
  
  
</div>