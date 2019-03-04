<?php
class CharacterManager
{
	public function add(Character $char)
	{
		
	}
	
	public function delete(Character $char)
	{
		
	}
	
	public function get($id)
	{
		
	}
	
	public function getList()
	{
		
	}
	
	public function update(Character $char)
	{
		
	}
}

<?php
class Database
{
	private static $_instance;
	private $_db;
	
	private __construct()
	{
		$this->_db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
	}
	
	public static getInstance()
	{
		if (self::$_instance == null)
			self::$$_instance = new self;
		return self::$$_instance;
	}
	
	function getDb()
	{
		return $this->_db;
	}
}
