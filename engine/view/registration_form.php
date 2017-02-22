
<a href="<?=$this->getLink()?>/" class="link_reg"><?=$this->fLang('_back_')?></a>

<div class="login_form">
  <p class="inform"><?=$this->fLang('_required_fields_')?></p>
  <?php if(isset($data['error'])){ ?>
  <p class="error"><?=$this->fLang('_error_exists_')?></p>
  <?php } ?>
  <form action="" enctype="multipart/form-data" method="post" id="registration_form">
  
    <div class="inform_block">
      
      <p class="inform_form"><?=$this->fLang('_personal_data_')?></p>
      <div class="label_field">
        <label for="username"><?=$this->fLang('_username_')?> *</label>
        <input type="text" class="inp_field chek_data" id="username" name="username" value="<?=$this->checkData($data,'data','username')?>" />
        <p class="error username"><?=$this->checkData($data,'error','username')?></p>
      </div>
      
      <div class="label_field">
        <label for="photo"><?=$this->fLang('_photo_')?></label>
        <input type="file" class="hide" id="photo" name="photo" />
        <label class="inp_field_label" for="photo"></label>
        <p class="error"><?=$this->checkData($data,'error','photo')?></p>
      </div>
      
      <div class="label_field">
        <label for="date"><?=$this->fLang('_date_birth_')?> *</label>
        <select class="date_select chek_data" id="day" name="day">
          <option value=""><?=$this->fLang('_day_')?></option>
          <?php for($i=1;$i<=31;$i++) { ?>
            <option <?=(isset($data['data']['day']) && $data['data']['day']==$i)?'selected="selected"':''?> value="<?=$i?>"><?=($i<10)? '0'.$i : $i ?></option>
          <?php } ?>
        </select>
        <select class="date_select chek_data" id="month" name="month">
          <option value=""><?=$this->fLang('_month_')?></option>
          <?php for($i=1;$i<=12;$i++) { ?>
            <option <?=(isset($data['data']['month']) && $data['data']['month']==$i)?'selected="selected"':''?> value="<?=$i?>"><?=($i<10)? '0'.$i : $i ?></option>
          <?php } ?>
        </select>
        <select class="date_select chek_data" id="year" name="year">
          <option value=""><?=$this->fLang('_year_')?></option>
          <?php for($i=date('Y'); $i>=(date('Y')-100); $i--) { ?>
            <option <?=(isset($data['data']['year']) && $data['data']['year']==$i)?'selected="selected"':''?> value="<?=$i?>"><?=$i?></option>
          <?php } ?>
        </select>
        <p class="error date"><?=$this->checkData($data,'error','date')?></p>
      </div>
      
      <div class="label_field">
        <label for="gender"><?=$this->fLang('_select_gender_')?></label>
        <select class="inp_field chek_data" id="gender" name="gender">
          <option value=""></option>
          <option <?=(isset($data['data']['gender']) && $data['data']['gender']==1)?'selected="selected"':''?> value="1"><?=$this->fLang('_male_')?></option>
          <option <?=(isset($data['data']['gender']) && $data['data']['gender']==0)?'selected="selected"':''?>  value="0"><?=$this->fLang('_female_')?></option>
        </select>
        <p class="error gender"><?=$this->checkData($data,'error','gender')?></p>
      </div>
      
      <div class="label_field">
        <label for="about"><?=$this->fLang('_about_')?> *</label>
        <textarea class="textarea chek_data" id="about" name="about"><?=$this->checkData($data,'data','about')?></textarea>
        <p class="error about"><?=$this->checkData($data,'error','about')?></p>
      </div>
    
    </div>
    
    <div class="inform_block">
      
      <p class="inform_form"><?=$this->fLang('_contact_data_')?></p>
      <div class="label_field">
        <label for="phone"><?=$this->fLang('_phone_')?></label>
        <input type="text" class="inp_field chek_data" id="phone" name="phone" value="<?=$this->checkData($data,'data','phone')?>" />
        <p class="error phone"><?=$this->checkData($data,'error','phone')?></p>
      </div>
      
      <div class="label_field">
        <label for="email"><?=$this->fLang('_email_')?> * <span class="inform_email"><?=$this->fLang('_inform_mail_')?></span></label>
        <input type="text" class="inp_field chek_data" id="email" name="email" value="<?=$this->checkData($data,'data','email')?>" />
        <p class="error email"><?=$this->checkData($data,'error','email')?></p>
      </div>
      
    </div>
    
    <div class="inform_block">
      <div class="label_field">
        <label for="password"><?=$this->fLang('_password_')?> *</label>
        <input type="password" class="inp_field chek_data" id="password" name="password" />
        <p class="error password"><?=$this->checkData($data,'error','password')?></p>
      </div>
      
      <div class="label_field">
        <label for="confirm_password"><?=$this->fLang('_confirm_password_')?> *</label>
        <input type="password" class="inp_field chek_data" id="confirm_password" name="confirm_password" />
        <p class="error confirm_password"><?=$this->checkData($data,'error','confirm_password')?></p>
      </div>
    </div>
    
    <div>
      <input type="submit" class="butt" value="<?=$this->fLang('_register_')?>" />
    </div>
    
  </form>
</div>

<div class="hide out_field"><?=$this->fLang('_out_field_');?></div>
<div class="hide not_confirm_pass"><?=$this->fLang('_not_confirm_password_');?></div>
<div class="hide date_incorect"><?=$this->fLang('_date_incorect_');?></div>
<div class="hide email_incorect"><?=$this->fLang('_email_incorect_');?></div>