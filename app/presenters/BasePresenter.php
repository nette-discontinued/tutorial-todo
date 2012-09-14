<?php

use Nette\Application\UI\Form;



/**
 * Base presenter for all application presenters.
 *
 * @property callable $newListFormSubmitted
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var Todo\ListRepository */
	protected $listRepository;



	public function injectBase(Todo\ListRepository $listRepository)
	{
		$this->listRepository = $listRepository;
	}



	public function beforeRender()
	{
		$this->template->lists = $this->listRepository->findAll()->order('title ASC');
	}



	/**
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentNewListForm()
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}

		$form = new Form();
		$form->addText('title', 'Název:', 15, 50)
			->addRule(Form::FILLED, 'Musíte zadat název seznamu úkolů.');

		$form->addSubmit('create', 'Vytvořit');
		$form->onSuccess[] = $this->newListFormSubmitted;

		return $form;
	}



	public function newListFormSubmitted(Form $form)
	{
		$list = $this->listRepository->createList($form->values->title);
		$this->flashMessage('Seznam úkolů založen.', 'success');
		$this->redirect('Task:default', $list->id);
	}

}
