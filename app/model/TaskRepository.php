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



	/**
	 * @param int $listId
	 * @param string $task
	 * @param int $assignedUser
	 * @return Nette\Database\Table\ActiveRow
	 */
	public function createTask($listId, $task, $assignedUser)
	{
		return $this->getTable()->insert(array(
			'text' => $task,
			'user_id' => $assignedUser,
			'created' => new \DateTime(),
			'list_id' => $listId,
		));
	}



	/**
	 * @param int $id
	 */
	public function markDone($id)
	{
		$this->findBy(array('id' => $id))->update(array('done' => 1));
	}

}
