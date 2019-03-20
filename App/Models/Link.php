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

        $query = 'SELECT * FROM category WHERE id>0';
        $res = $this->db->query($query);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $list = [];
        while ($row = $res->fetch()) {
            $list[] = $row;
        }
        return $list;
    }


    /**
     * Create new link.
     *
     * @param string $long - long lonk
     * @param string $short - short link
     * @return bool
     *
     */
    public function createLink($long, $short)
	{

        if(empty($short)){
            $short = $this->makeShortLink();
        }
        $query = 'INSERT INTO links SET `short`=:short, `long`=:long';
        $res = $this->db->prepare($query);
        if($res->execute(['short' => $short, 'long' => $long])){
            return $short;
        }
        return 0;
    }
		
    /**
	 * Check if short link has already been added 
     * @param string
     * @return bool true if
     */
    public function checkShort($short = 0)
	{
        $query = 'SELECT COUNT(*) FROM links WHERE `short`=:short';
        $stmt = $this->db->prepare($query);
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
        $pat = '/^[a-z0-9]{6,10}$/i';
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
        do {
            $count = rand(6,9);
            $result = '';
            $array = array_merge(range('a','z'), range('0','9'));
            for($i = 0; $i < $count; $i++){
                $result .= $array[mt_rand(0, 35)];
            }
        } while($this->checkShort($result) == false);

        return $result;
    }
}
