<?php

class User extends DB\SQL\Mapper
{
	function __construct(DB\SQL $db) {
		// pass table name for ORM
		parent::__construct($db, 'user');
	}

	public function all()
	{
		$this->load();
		return $this->query;
	}

	public function getById($id)
	{
		$this->load(array('id=?', $id));
		return $this->query;
	}

	public function getByName($username)
	{
		$this->load(array('username=?', $username));
		return $this->query;
	}

	public function getByEmail($email)
	{
		$this->load(array('email=?', $email));
		return $this->query;
	}

	public function add()
	{
		// table keys matching with POST keys
		$this->copyFrom('POST');
		$this->save();
	}
}