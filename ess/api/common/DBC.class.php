<?php
/**
 * MYSQL Connection Class.
 * @version 3.0
 */
class DBC {
	
	/*
	 * 连接或对象
	 */
	private $mysqliObject = null;
	function __destruct() {
		if ($this->mysqliObject)
			$this->close ();
	}
	
	/**
	 * close DBC link
	 */
	function close() {
		$this->mysqliObject->close ();
		$this->mysqliObject = null;
	}
	
	/**
	 * get mysqli OBJECT.
	 *
	 * @param string $dbName        	
	 * @return mixed mysqliObject
	 */
	public function get_MySQLi_Object($dbName = null, $encode = 'utf8mb4') {
		global $cfgDB;
		if (is_null ( $dbName ))
			$dbName = $cfgDB ['name'];
		$mysqli = new mysqli ( $cfgDB ['host'], $cfgDB ['user'], $cfgDB ['pass'], $dbName );
		if (! $mysqli->connect_error) {
			$mysqli->query ( "SET NAMES '$encode'" );
		} else {
			return FALSE;
		}
		$this->mysqliObject = $mysqli;
		return $mysqli;
	}
}
/**
 * 获取redis
 *
 * @author icity
 *        
 */
class RedisFactory {
	public static function getRedisInstance() {
		$redis = new Redis ();
		$rc = $redis->connect ( '127.0.0.1', 6379 );
		return $rc ? $redis : FALSE;
	}
	public static function redisKey($prefix,$factpart){
		return  "$prefix:$factpart";
	}
}
