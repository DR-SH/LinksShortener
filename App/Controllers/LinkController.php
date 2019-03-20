<?php
namespace App\Controllers;

use App\Models\Link;


class LinkController
{
    /**
     * Show the form for creating a short link.
     */
    public function actionIndex()
    {
        require_once(ROOT.'/views/index.php');
    }
	
    /**
     * Create new short link
     */	
    public function actionCreate()
    {
		if (!isset($_POST['test'])){  //если по маршруту не передавался POST, вывести ошибку		
			header ("HTTP/1.1 404 Not Found");
			header("Status: 404 Not Found");
			exit();			
		} 

		$long = $this->handleInput($_POST['long']); //long link
		$short = $this->handleInput($_POST['short']); //short link
		$errors = $this->checkErrors($long, $short);
		if($errors){
			var_dump($errors);
		}
		else{
			$link = new Link;
			var_dump($link->createLink($long, $short));
			 echo 'добавлены! в БД значения '.$long.' и '.$short;
		}
    }	 
	 
	 
	 
    public function actionShow($x)
    {
		var_dump($x);
		echo 'show';
    }
	
	
   /**
     * Check if input data is ok
     *
     * @param string
     * @param string
     * @return bool false or array
     */		
	private function checkErrors($long, $short)
	{
		$errors = [];
		$link = new Link;
		if(!$link->validateLong($long)){
			$errors[] = 'Введите корректный URL';
		}
		
		if(!$link->validateShort($short)){
			$errors[] = 'Ваша короткая ссылка должна содержать от 6 до 10 
			символов и состоять из латинских букв или цифр';
		}		
 		if(!$link->checkShort($short)){
			$errors[] = 'Данная короткая ссылка уже занята. Попробуйте другую';			
		} 

		return (empty($errors)) ? 0 : $errors;
	}
	
   /**
     * Processing values from post request 
     *
     * @param string
     * @return string
     */	
	private function handleInput($text)	
	{
		$trimmedText = htmlspecialchars(trim($text));
		return $trimmedText;
	}
	

}