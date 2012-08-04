<?php

namespace Todo;

use Nette;



class TaskListControl extends Nette\Application\UI\Control
{

	/** @var boolean */
	public $displayUser = TRUE;

	/** @var boolean */
	public $displayList = FALSE;

	/** @var Nette\Database\Table\Selection */
	private $selected;

	/** @var TaskRepository */
	private $taskRepository;



	public function __construct(Nette\Database\Table\Selection $selected, TaskRepository $taskRepository)
	{
		parent::__construct(); // vždy je potřeba volat rodičovský konstruktor
		$this->selected = $selected;
		$this->taskRepository = $taskRepository;
	}



	public function handleMarkDone($taskId)
	{
		$this->taskRepository->markDone($taskId);
		$this->presenter->redirect('this');
	}



	public function render()
	{
		$this->template->setFile(__DIR__ . '/TaskList.latte');
		$this->template->tasks = $this->selected;
		$this->template->displayUser = $this->displayUser;
		$this->template->displayList = $this->displayList;
		$this->template->render();
	}

}
