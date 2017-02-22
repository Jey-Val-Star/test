<?php
/** 
  Модель приложения
*/ 
Class Model
{
  private $host = 'localhost';
  private $db = 'test_task';
  private $user = 'root';
  private $passw = '';
  private $mysqli = null;
  
  /** Подключение к бд */
  public function __construct()
  {
    $this->mysqli = new mysqli($this->host, $this->user, $this->passw, $this->db);
    
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    
    $this->mysqli->query('SET NAMES "utf8"');
  }
  
  /** Авторизация пользователя */
  public function authUser($data)
  {
     if (!($stmt = $this->mysqli->prepare("SELECT * FROM users WHERE email = (?)"))) {
        echo "Не удалось подготовить запрос: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        exit();
    }
    
    if (!$stmt->bind_param("s", $data['login'])) {
        echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    if (!$stmt->execute()) {
        echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    $res = $stmt->get_result();
    
    if($res->num_rows == 0)
    {
      return false;
    }
    
    $row = $res->fetch_assoc();
    
    //print_r($row);exit;
    
    if($row['password'] != crypt($data['password'], $row['salt']))
    {
      return false;
    }
    
    //session_start();
    
    $_SESSION['user_id'] = $row['id'];
    
    return $row;
  }
  
  /** Получаем пользователя по id */
  public function getUser($id=0)
  {
    if (!($stmt = $this->mysqli->prepare("SELECT * FROM users WHERE id = (?)"))) {
        echo "Не удалось подготовить запрос: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        exit();
    }
    
    if (!$stmt->bind_param("i", $id)) {
        echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    if (!$stmt->execute()) {
        echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    $res = $stmt->get_result();
    
    return $res->fetch_assoc();
  }
  
  /** Добавление нового пользователя в бд */
  public function addUser($data)
  {
    $sql = 'INSERT INTO `users`
       (`email`,`password`,`salt`,`username`,`photo`,`date_birth`,`gender`,`about`,`phone`,`date_reg`)
       VALUE (?,?,?, ?,?,?, ?,?,?,?)';
    
    if (!($stmt = $this->mysqli->prepare($sql))) {
        echo "Не удалось подготовить запрос: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        exit();
    }
    
    if (!$stmt->bind_param("ssssssisss", $data['email'], $data['password'], $data['salt'], $data['username'], $data['photo'], $data['date_birth'], $data['gender'],$data['about'],$data['phone'], $data['date_reg'])) {
        echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    if (!$stmt->execute()) {
        echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    return $this->mysqli->insert_id;
  }
  
  /** Проверка существования email в бд */
  public function chekEmail($email)
  {
    if (!($stmt = $this->mysqli->prepare("SELECT email FROM users WHERE email = (?)"))) {
        echo "Не удалось подготовить запрос: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        exit();
    }
    
    if (!$stmt->bind_param("s", $email)) {
        echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    if (!$stmt->execute()) {
        echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }
    
    $res = $stmt->get_result();
    
    return ($res->num_rows > 0) ? false : true;
  }
}