<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	/** @var Todo\TaskRepository */
	private $taskRepository;



	public function inject(Todo\TaskRepository $taskRepository)
	{
		$this->taskRepository = $taskRepository;
	}



	/** @return Todo\TaskListControl */
	public function createComponentIncompleteTasks()
	{
		return new Todo\TaskListControl($this->taskRepository->findIncomplete(), $this->taskRepository);
	}

}
