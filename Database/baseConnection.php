<?php
namespace Database;
use Database\Database;
abstract class baseConnection
{
	protected $db;

	public function __construct()
	{
		$this->db = new Database();
	}
}
?>