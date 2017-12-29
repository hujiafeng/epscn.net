<?php
/**
 * MYSQL Connection Manager Class.
 * 打开一种mysql连接，以多实例管理不同连接或对象
 * @author wangshaohui, wushihong
 * @version 1.1
 */
class DB
{
    private $linkType = 0;
    public $mysqlLinkOrObject = null;

    function __destruct()
    {
        if ($this->mysqlLinkOrObject) {
            $this->close();
        }
    }

    /**
     * 关闭打开的连接
     */
    function close()
    {
        if ($this->linkType == 1) {
            mysql_close($this->mysqlLinkOrObject);
        } else if ($this->linkType == 2) {
            mysqli_close($this->mysqlLinkOrObject);
        } else if ($this->linkType == 3) {
            $this->mysqlLinkOrObject->close();
        }
        $this->mysqlLinkOrObject = null;
        $this->linkType = 0;
    }

    /**
     * link state.
     * @var bool
     */
    public $isOK = false;

    /**
     * get mysql link.
     * @param string $db_name
     * @return mysqlLink
     */
    public function get_MySQL_Link($db_name = null)
    {
        global $cfgDb;
        $link = mysql_connect($cfgDb['host'], $cfgDb['user'], $cfgDb['pass']);
        if ($link) {
            if (is_null($db_name)) $db_name = $cfgDb['name'];
            $this->isOK = mysql_select_db($db_name);
            mysql_query("SET NAMES 'UTF8'", $link);
        }
        $this->linkType = 1;
        $this->mysqlLinkOrObject = $link;
        return $link;
    }

    /**
     * get mysqli link.
     * @param string $db_name
     * @return mysqliLink
     */
    public function get_MySQLi_Link($db_name = null)
    {
        global $cfgDb;
        if (is_null($db_name)) $db_name = $cfgDb['name'];
        $link = mysqli_connect($cfgDb['host'], $cfgDb['user'], $cfgDb['pass'], $db_name);
        if ($link) {
            $this->isOK = true;
            mysqli_query($link, "SET NAMES 'UTF8'");
        }
        $this->linkType = 2;
        $this->mysqlLinkOrObject = $link;
        return $link;
    }

    /**
     * get mysqli link.
     * @param string $db_name
     * @return mysqliObject
     */
    public function get_MySQLi_Object($db_name = null)
    {
        global $cfgDb;
        if (is_null($db_name)) $db_name = $cfgDb['name'];
        $mysqli = new mysqli ($cfgDb['host'], $cfgDb['user'], $cfgDb['pass'], $db_name);
        if (!mysqli_connect_error()){
            $this->isOK = true;
            $mysqli->query("SET NAMES 'UTF8'");
        }
        $this->linkType = 3;
        $this->mysqlLinkOrObject = $mysqli;
        return $mysqli;
    }
	
	//
	public function get_MySQLi_Object1($db_name = null)
    {
        global $cfgDb;
        if (is_null($db_name)) $db_name = $cfgDb['name'];
        $mysqli = new mysqli ($cfgDb['host'], $cfgDb['user'], $cfgDb['pass'], $db_name);
        if (!mysqli_connect_error()){
            $this->isOK = true;
            $mysqli->query("SET NAMES 'UTF8MB4'");
        }
        $this->linkType = 3;
        $this->mysqlLinkOrObject = $mysqli;
        return $mysqli;
    }
}
