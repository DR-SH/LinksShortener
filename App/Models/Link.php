<?php
namespace App\Models;

use App\Components\Db;
use PDO;

/**
 * Class Link
 * @package App\Models
 */
class Link
{
    /**
     * Connecting to db.
     *
     * @var PDO
     */
    private $db;

    /**
     * Link constructor.
     */
    public function __construct()
    {
        $this->db = Db::connect();
    }

    /**
     * Get long link from db.
     *
     * @param string $short
     * @return string $res long link|bool false if link has not found
     */
    public function getLongLink($short)
    {
        $query = 'SELECT `long` FROM links WHERE `short`=:short';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['short' => $short]);
        $res = $stmt->fetchColumn();
        return ($res)? $res: false ;
    }

    /**
     * Create new link.
     *
     * @param string $long - long link
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
        if($res->execute(['short' => $short, 'long' => $long])) {
            return $short;
        }
        return 0;
    }
		
    /**
	 * Check if short link has already been added.
     *
     * @param string $short
     * @return bool true if
     */
    public function checkShort($short = '')
	{
        $query = 'SELECT COUNT(*) FROM links WHERE `short`=:short';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['short' => $short]);
        return ($stmt->fetchColumn() > 0) ? false : true;
    }

    /**
     * Create table.
     *
     * @return bool
     */
    public function createTable()
    {
        $query = 'CREATE TABLE IF NOT EXISTS `links`(`short` VARCHAR(10) NOT NULL PRIMARY KEY, `long` TEXT)';
        $res = $this->db->prepare($query);
        return $res->execute();
    }

    /**
     * Drop table.
     *
     * @return bool
     */
    public function dropTable()
    {
        $query = 'DROP TABLE IF EXISTS `links`';
        $res = $this->db->prepare($query);
        return $res->execute();
    }

    /**
     * Validate long URl.
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
     * Validate short link.
     *
     * @param string
     * @return bool
     */
    public function validateShort($short)
    {
        if (empty($short)) {
            return true;
        }
        $pat = '/^[a-z0-9]{6,10}$/i';
        return preg_match($pat, $short);
    }

    /**
     * Generate random string for short link.
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
            for($i = 0; $i < $count; $i++) {
                $result .= $array[mt_rand(0, 35)];
            }
        } while($this->checkShort($result) == false);
        return $result;
    }
}
