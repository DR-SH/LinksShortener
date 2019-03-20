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
		if (!isset($_POST['long'])){  //если по маршруту не передавался POST, вывести ошибку		
			header ("HTTP/1.1 404 Not Found");
			header("Status: 404 Not Found");
			exit();			
		} 

		$long = $this->handleInput($_POST['long']); //long link
		$long = $this->makeAbsolut($long);
		$short = $this->handleInput($_POST['short']); //short link
		$errors = $this->checkErrors($long, $short);
		if($errors){
			echo json_encode(['status' => '0', 'errors' => $errors]);
		}
		else{
			$link = new Link;
			$result = $link->createLink($long, $short);
			if($result){
				echo json_encode(['status' => '1', 'short' => $result, 'long' => $long]);
			}
			else{
				echo json_encode(['status' => '0', 'errors' => ['Ошибка сервера']]);
			}

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

	/**
	 * Add 'http://' if link didn't have it
	 *
	 * @param string
	 * @return string
	 */
	private function makeAbsolut($text)
	{
		if(!parse_url($text, PHP_URL_SCHEME)){
			$text = 'http://'.$text;
		}
		return $text;
	}

}