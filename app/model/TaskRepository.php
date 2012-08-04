<?php

namespace Todo;

use Nette;



class TaskRepository extends Repository
{

	/**
	 * Vrací seznam nehotových úkolů.
	 * @return Nette\Database\Table\Selection
	 */
	public function findIncomplete()
	{
		return $this->findBy(array('done' => FALSE))->order('created ASC');
	}

}
