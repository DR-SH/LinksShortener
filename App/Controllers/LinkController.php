<?php
namespace App\Controllers;

use App\Models\Link;


/**
 * Class LinkController
 * @package App\Controllers
 */
class LinkController
{
    /**
     * Show the form for creating a short link.
     */
    public function actionIndex()
    {
        require_once(ROOT.'/Views/index.php');
    }
	
    /**
     * Create new short link
     */	
    public function actionCreate()
    {

		if (!isset($_POST['long'])) {     //if there is no post request then redirect to 404
			header ("HTTP/1.1 404 Not Found");
			echo '<h1>ОШИБКА 404</h1>';
			exit();			
		} 

		$long = $this->handleInput($_POST['long']);  //get the long link
		$long = $this->makeAbsolut($long);
		$short = $this->handleInput($_POST['short']);  //get the short link
		$errors = $this->checkErrors($long, $short); //validate entry

		// If any mistakes were found
		if($errors) {
			echo json_encode(['status' => '0', 'errors' => $errors]);
		}

		// If no mistakes were found
		else {
			$link = new Link;
			$result = $link->createLink($long, $short);
			if($result) {
				echo json_encode(['status' => '1', 'short' => $result, 'long' => $long]);
			}
			else {
				echo json_encode(['status' => '0', 'errors' => ['Ошибка сервера']]);
			}
		}
    }


	/**
	 * Get short link and redirect to long link from db.
	 * 
	 * @param array 
	 * 
     */
	public function actionGet($x)
    {
		$link = new Link;
		$result = $link->getLongLink($x[0]);
		if ($result){
			header("Location: $result");
		}
		else {
			header ("HTTP/1.1 404 Not Found");
			echo '<h1>ОШИБКА 404</h1>';
			exit();
		}
	}
	
    /**
     * Check if input data is correct.
     *
     * @param string $long long link
     * @param string $short short link
     * @return bool false or array
     */		
	private function checkErrors($long, $short)
	{
		$errors = [];
		$link = new Link;

		if(!$link->validateLong($long)) {
			$errors[] = 'Введите корректный URL';
		}
		
		if(!$link->validateShort($short)) {
			$errors[] = 'Ваша короткая ссылка должна содержать от 6 до 10 
			символов и состоять из латинских букв или цифр';
		}		
 		if(!$link->checkShort($short)) {
			$errors[] = 'Данная короткая ссылка уже занята. Попробуйте другую';			
		} 

		return (empty($errors)) ? 0 : $errors;
	}
	
	/**
	* Processing values from post request.
	*
	* @param string $text link
	* @return string
	*/
	private function handleInput($text)	
	{
		$trimmedText = htmlspecialchars(trim($text));
		return $trimmedText;
	}

	/**
	* Add 'http://' if link does not have it.
	*
	* @param string $text long link
	* @return string
	*/
	private function makeAbsolut($text)
	{
		if(!parse_url($text, PHP_URL_SCHEME)) {
			$text = 'http://'.$text;
		}
		return $text;
	}

}