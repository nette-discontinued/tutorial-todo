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



	public function renderDefault()
	{
		$this->template->tasks = $this->taskRepository->findIncomplete();
	}

}
