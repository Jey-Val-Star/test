<?php

/** 
 * Файл контроллер
 */
class Controller extends Engine{
  
  public $data = null; // для данных
  
  /** Метод индекс - авторизация или отображение данных */
  public function index()
  {
    session_start();
    
    if(isset($_SESSION['user_id']))
    {
      $model = new Model();
        
      $userData = $model->getUser($_SESSION['user_id']);
      
      $this->view('user_data',$userData);
    }
    else if(!empty($_POST))
    {
      $this->_checkPost();
      
      $this->_checkPassword(false, false);
      
      if(!isset($this->data['error']))
      {
        $model = new Model();
        
        $userData = $model->authUser($this->data['data']);
        
        if(!$userData)
        {
          $this->data['error']['not_login'] = $this->fLang('_not_login_');
          $this->view('login_form',$this->data);
        }
        else
        {
          $this->view('user_data',$userData);
        }
      }
      else
      {
        $this->view('login_form',$this->data);
      }
    }
    else
    {
      $this->view('login_form');
    }
  }
  
  /** метод разавторизации пользователя */
  public function logout()
  {
    session_start();
    unset($_SESSION['user_id']);
    session_destroy();
    
    header('Location: /');
  }
  
  /** Метод вывода формы регистрации, и регистрация пользователей */
  public function registration()
  {
    if(!empty($_POST))
    { 
      $this->_checkPost();
      
      $this->_checkPhone();
      
      if(!isset($this->data['error']))
      {
        $this->_checkPassword();
        
        $this->_uploadFile();
      }

      if(isset($this->data['error']))
      {
        $this->view('registration_form', $this->data);
      }
      else
      { 
        $model = new Model();
        
        if($model->chekEmail($this->data['data']['email']))
        {
          $this->_getDateBirth();
          
          $this->data['data']['date_reg'] = date('Y-m-d H:i:s');
          
          $model->addUser($this->data['data']);
          
          $this->view('registration_confirm');
        }
        else
        {
          $this->data['error']['email'] = $this->fLang('_email_exists_');
          
          $this->view('registration_form', $this->data);
        }
      }
    }
    else
    {
      $this->view('registration_form');
    }
  }
  
  /** Метод проверки данных пришедших из формы */ 
  private function _checkPost($password=false)
  {
    foreach($_POST as $key=>$val)
    {
      if(($val == '') && $key != 'phone' && $key != 'photo')
      {
        if($key=='day' || $key=='month' || $key=='year')
        {
          $this->data['error']['date'] = $this->fLang('_out_field_');
        }
        else
        {
          $this->data['error'][$key] = $this->fLang('_out_field_');
        }
      }
      else
      {
        if($key=='email')
        {
          if(!preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $val))
          {
            $this->data['error'][$key] = $this->fLang('_email_incorect_');
          }
        }
        
        if($key=='day' || $key=='month' || $key=='year' || $key=='gender')
        {
          $this->data['data'][$key] = (int)$val;
        }
        else if($key !== 'confirm_password' && $key !== 'password')
        {
          $this->data['data'][$key] = ($val!='') ? $this->_protectionData($val) : null;
        }
      }
    }
  }
  
  private function _checkPhone()
  {
    if (!preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $this->data['data']['phone']))
    {
      $this->data['error']['phone'] = $this->fLang('_phone_incorect_');
    }
  }
  
  /** Метод загрузки файла */
  private function _uploadFile()
  {
    if (!empty($_FILES['photo']['name']))
    {
      $storeFolder = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
      
      $file_ext =  strtolower(strrchr($_FILES['photo']['name'],'.'));
      
      $mime = getimagesize($_FILES['photo']['tmp_name']);
      
      $arrayType = array('.jpg','.png','.jpeg');
      
      if(in_array($file_ext,$arrayType) && ($mime['mime'] === $_FILES['photo']['type']))
      {
        $time = ceil(microtime(true)*1000);
        $file_name = date('YmdHis').$time.$file_ext;
        
        $uploaded_file  = $storeFolder . $file_name;
        
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $uploaded_file))
        {
          //добавление названия файла в массив данных пользователя
          $this->_imageSize($uploaded_file, 200);
          $this->data['data']['photo'] = $file_name;
        }
      }
      else
      {
        $this->data['error']['photo'] = $this->fLang('_photo_incorect_');
      }
    }
  }
  
  /** Метод установки даты рождения */
  private function _getDateBirth()
  {
    if(checkdate($this->data['data']['month'], $this->data['data']['day'], $this->data['data']['year']))
    {
      $this->data['data']['date_birth'] = $this->data['data']['year'].'-'.$this->data['data']['month'].'-'.$this->data['data']['day'];
      
      unset($this->data['data']['year']);
      unset($this->data['data']['month']);
      unset($this->data['data']['day']); 
    }
    else
    {
      $this->data['error']['date'] = $this->fLang('_date_incorect_');
    }
  }
  
  /** Метод изменения размера изображения */
  private function _imageSize($file, $width)
  {
    list($widthImage, $heightImage, $type) = getimagesize($file);
    
  	if (!$widthImage || !$heightImage) {
  		return;
    }
    
    $types = array('','gif','jpeg','png');
    
    $ext = $types[$type];
    
    if ($ext) {
      $func = 'imagecreatefrom'.$ext;
      $img = $func($file);
    } else {
		  return;
    }

  	$height = $width/($widthImage/$heightImage);
  
  	$img_o = imagecreatetruecolor($width, $height);
    
  	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $width, $height, $widthImage, $heightImage);
    
  	if ($type == 2) {
  		return imagejpeg($img_o,$file,100);
  	} else {
  		$func = 'image'.$ext;
  		return $func($img_o,$file);
  	}
  }
  
  /** Метод очистки удаления скобок html */
  private function _protectionData($data = '')
  {
    if($data != '') 
    {
      $data = str_replace(array('<','>'), '|', $data);
    }
    
    return $data;
  }
  
  /** Проверка ввода пароля */
  private function _checkPassword($hash=true, $confirm = true)
  {
    if($_POST['password'] !== '')
    {
      if(!$confirm)
      {
        $_POST['confirm_password'] = $_POST['password'];
      }
      
      if($_POST['password']==$_POST['confirm_password'])
      {
        $this->data['data']['password'] = ($hash) ? $this->_hashPassword() : $_POST['password'];
      }
      else
      {
        $this->data['error']['confirm_password'] = $this->fLang('_not_confirm_password_');
      }
    }
    else
    {
      $this->data['error']['password'] = $this->fLang('_not_password_');
    }
  }
  
  /** Хеширование пароля с солью */
  private function _hashPassword()
  {
    $salt = md5(uniqid('nhaw723#@', true));
    $salt = substr(strtr(base64_encode($salt), '+', '.'), 0, 22);
    
    $this->data['data']['salt'] = $salt;
    
    return crypt($_POST['password'], $salt);
  }
}