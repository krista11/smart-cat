<?php
class config {
	const DB_SERVER    = 'localhost';
	const DB_NAME      = 'smart-cat';
	const DB_USERNAME  = 'root';
	const DB_PASSWORD  = '';

	public static function getServer(){
		return self::DB_SERVER;
	}
	public static function getName(){
		return self::DB_NAME;
	}
	public static function getUser(){
		return self::DB_USERNAME;
	}
	public static function getPassword(){
		return self::DB_PASSWORD;
	}
}
?>
