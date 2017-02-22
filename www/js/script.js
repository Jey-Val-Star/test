$(document).ready(function(){
  
    /** Добавление название файла в label  */
    $('#photo').change(function(){
        if($(this).val() != '') {
            $('.inp_field_label').text($(this).val().replace(/.+[\\\/]/, ""));
        }
        else
        {
            $('.inp_field_label').text('');
        }
    });
  
    /** Проверка ввода двнных в форму авторизации (login_form) */
    $('#login_form').submit(function(){
        var error = 0;

        // Проверка логина пользователя
        if($(this).find('#login').val() == ''){
            $('.login').html($('.out_field').text());
            error = 1;
        }
        
        // проверка пароля
        if($(this).find('#password').val() == ''){
            $('.password').html($('.out_field').text());
            error = 1;
        }
        
        // проверка ошибок
        if(error == 1)
        {
            return false
        }
        else
        {
            return true
        }
        
    });
    /** end login_form */
    
    /** Проверка ввода двнных в форму регистрации (registration_form) */
    $('#registration_form').submit(function(){
        var error = 0;

        // Проверка имени пользователя
        if($(this).find('#username').val() == ''){
            $('.username').html($('.out_field').text());
            error = 1;
        }
        
        // проверка даты - день
        var error_date = 0;
        var date_day = Number($(this).find('#day').val());
        
        if(date_day == ''){
            $('.date').html($('.out_field').text());
            error = 1;
            error_date = 1;
        }
        
        // проверка даты - месяц
        var date_month = Number($(this).find('#month').val());
        
        if(date_month == ''){
            $('.date').html($('.out_field').text());
            error = 1;
            error_date = 1;
        }
        
        // проверка даты - год
        var date_year = Number($(this).find('#year').val());
        
        if(date_year == ''){
            $('.date').html($('.out_field').text());
            error = 1;
            error_date = 1;
        }
        
        var d = new Date(date_year+'-'+date_month+'-'+date_day);
        
        if(error_date == 0)
        {
          if ((d.getFullYear() != date_year) || (d.getMonth() != (date_month - 1) ) || (d.getDate() != date_day)) 
          {
            $('.date').html($('.date_incorect').text());
            error = 1;
          }
        }
        
        // проверка пола
        if($(this).find('#gender').val() == ''){
            $('.gender').html($('.out_field').text());
            error = 1;
        }
        
        // проверка поля - "обо мне"
        if($(this).find('#about').val() == ''){
            $('.about').html($('.out_field').text());
            error = 1;
        }
        
        // проверка поля - "Email"
        var email = $(this).find('#email').val();
        
        if(email == ''){
            $('.email').html($('.out_field').text());
            error = 1;
        }
        else
        {
          var mail_reg = /^[a-z0-9_\.-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
          
          if(!mail_reg.test(email))
          {
            $('.email').html($('.email_incorect').text());
            error = 1;
          }
        }
        
        // проверяем корректность ввода телефона
        var phone = $(this).find('#phone').val();
        
        if(phone != '')
        {
          var phone_reg = /^[0-9\+]{6,10}/;
          if(!phone_reg.test(phone))
          {
            $('.phone').html($('.email_incorect').text());
            error = 1;
          }
        }
        
        // проверка поля - "Пароль"
        if($(this).find('#password').val() == ''){
            $('.password').html($('.out_field').text());
            error = 1;
        }
        
        // проверка поля - "Подтверждения пароля"
        if($(this).find('#confirm_password').val() != $(this).find('#password').val()){
            $('.confirm_password').html($('.not_confirm_pass').text());
            error = 1;
        }
        
        // проверка ошибок
        if(error == 1)
        {
            return false
        }
        else
        {
            return true
        }
        
    });
    /** end registration_form */
    
    /** Скрытие ошибок при изменении значения полей */
    $('.chek_data').focus(function(){
      var id = $(this).attr('id');
      if(id == 'day' || id == 'month' || id == 'year')
      {
        $('.date').text('');
      }
      else
      {
        $('.'+id).text('');
      }
    });
  
});
