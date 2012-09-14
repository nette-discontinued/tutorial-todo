<?php

namespace Todo;

use Nette;



class UserRepository extends Repository
{


	/**
	 * @return Nette\Database\Table\ActiveRow
	 */
	public function findByName($username)
	{
		return $this->findBy(array('username' => $username))->fetch();
	}

}
