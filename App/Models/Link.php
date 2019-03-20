<?php
namespace App\Models;

use App\Components\Db;
use PDO;
use PDOException;
class Link
{
    private $db;
    
    public function __construct()
    {
        $this->db = Db::connect();
    }


    public static function show()
    {

        $pdoquery = 'SELECT * FROM category WHERE id>0';
        $res = $this->db->query($pdoquery);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $list = [];
        while ($row = $res->fetch()) {
            $list[] = $row;
        }
        return $list;
    }


    /**
     * @param $array[name, link, status]
     * @return bool
     *
     */
    public function createLink($long, $short)
	{

        if(empty($short)){
            $short = $this->makeShortLink();
        }
        $pdoquery = 'INSERT INTO links SET `short`=:short, `long`=:long';
        $res = $this->db->prepare($pdoquery);
        $res->bindParam(':name', $array['name'], PDO::PARAM_INT);
        $res->bindParam(':link', $array['link'], PDO::PARAM_INT);
        return $res->execute(['short' => $short, 'long' => $long]);
    }
		
    /**
	 * Check if short link has already been added 
     * @param string
     * @return bool true if
     */
    public function checkShort($short = 0)
	{
        $pdoquery = 'SELECT COUNT(*) FROM links WHERE `short`=:short';
        $stmt = $this->db->prepare($pdoquery);
        $stmt->execute(['short' => $short]);
        return ($stmt->fetchColumn() > 0) ? false : true ;
    }

    /**
     * Create table
     *
     * @return bool
     */
    public function createTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `links`(`short` VARCHAR(10) NOT NULL PRIMARY KEY, `long` TEXT)';
        return $this->db->exec($sql);
    }
    /**
     * Delete table
     *
     * @return bool
     */
    public function deleteTable()
    {
        $sql = 'DROP TABLE IF EXISTS `links`';
        return $this->db->exec($sql);
    }
    /**
     * Validate long URl
     *
     * @param string
     * @return bool
     */
    public function validateLong($long)
    {
        $pat = '/^(https?:\/\/)?([\w\.]+)\.([a-z]{2,6}\.?)(\/[\S]*)*\/?$/i';
        return preg_match($pat, $long);
    }

    /**
     * Validate short link
     *
     * @param string
     * @return bool
     */
    public function validateShort($short)
    {
        if (empty($short)){
            return true;
        }
        $pat = '/^[a-z0-9]{5,10}$/i';
        return preg_match($pat, $short);
    }

    /**
     * Generate random link
     *
     * @param int
     * @return string
     */
    private function makeShortLink()
    {
       // do{
            $count = rand(6,9);
            $result = '';
            $array = array_merge(range('a','z'), range('0','9'));
            for($i = 0; $i < $count; $i++){
                $result .= $array[mt_rand(0, 35)];
            }
        //} while($this->checkShort($result));

        return $result;
    }
}
