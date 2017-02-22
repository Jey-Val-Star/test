<?php
/**
 * Основной класс приложения 
 */
class Engine{
  
  private $lang = []; // массив с текстом
  
  private $linkLang = 'ru'; // язык приложения по умолчанию RU
  
  public $title = ''; // Заголовок страницы
  
  /** Я использовал конструктор для дальнейшего выполнения приложения, 
    * но можно обойтись и без него - указав метод после создания объекта */
  public function __construct()
  {
    $this->rout();
  }
  
  /** Метод проверки доступных языков */ 
  private function checkLang($lang)
  {
    $langs = ['en']; // в массиве не указан язык по умолчанию (ru) что бы не было дублей страниц
    return in_array($lang, $langs);
  }
  
  /** Метод разбора адресной строки и определение методов и языков */
  private function rout()
  {
    
    $arr_uri =  explode('?',$_SERVER['REQUEST_URI']);
    $arr_uri = explode('/',trim(reset($arr_uri),'/'));
    
    if($arr_uri[0]=='')
    {
      $action = 'index';
    }
    else
    {
      $i=0;
      
      if($this->checkLang($arr_uri[0]))
      {
        $this->linkLang = $arr_uri[0];
        $i=1;
      }
      
      $action = (isset($arr_uri[$i]) && $arr_uri[$i] != '')? ltrim($arr_uri[$i],'_') : 'index';
    }
    
    unset($arr_uri);
    unset($i);
    
    $this->getLang();
    
    $this->getAction($action);
  }
  
  
  /** Проверка и обращение к методу или 404 */
  private function getAction($action)
  { 
    // А если метода нет - то 404
    if(method_exists($this, $action))
    {
      $this->$action();
    }
    else
    {
      $this->view('error_404');
    }
  }
  
  /** Подключаем языковой файл */
  private function getLang()
  {
    $path = __DIR__ . '/langs/'.$this->linkLang.'.php';
    
    if(file_exists($path))
    {
      include_once $path; 
    }
    else
    {
      include_once __DIR__ . '/langs/ru.php';
    }
    
    $this->lang=$arr_langs;
  }
  
  /** Метод вывода информации (рендеринг) */
  public function view($view, $data=null)
  {
    $path = __DIR__ . '/view/';
    
    include $path . 'header.php';
    include $path . 'languages.php';
    
    include $path . $view.'.php';
    
    include $path . 'footer.php';
  }
  
  /** Определения языка для ссылок */
  public function getLink()
  {
    return ($this->linkLang != 'ru') ?  '/'.$this->linkLang : '';
  }
  
  /** Метод подстановки слов в зависимости от выбранного языка */
  public function fLang($key)
  {
    // чтобы программа не выдавала ошибок если нет индекса языка
    return (isset($this->lang[$key])) ? $this->lang[$key] : $key ; 
  }
  
  /** Метод определения ссылки при смене языка */
  public function langChange()
  {
    $langUri = substr(trim($_SERVER['REQUEST_URI'],'/'), 0, 2);
    
    if($this->checkLang($langUri))
    {
      return substr($_SERVER['REQUEST_URI'], 3);
    }
    
    return $_SERVER['REQUEST_URI'];
    
  }
  
  /** метод проверки данных */
  public function checkData($data=null,$key=null,$val=null)
  {
    return (isset($data[$key][$val])) ? $data[$key][$val] : null;
  }
}