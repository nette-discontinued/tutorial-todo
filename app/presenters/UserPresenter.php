<?php

use Nette\Application\UI\Form;


/**
 * @property callable $passwordFormSubmitted
 */
class UserPresenter extends BasePresenter
{

	/** @var Todo\UserRepository */
	private $userRepository;

	/** @var Todo\Authenticator */
	private $authenticator;



	public function inject(Todo\UserRepository $userRepository, Todo\Authenticator $authenticator)
	{
		$this->userRepository = $userRepository;
		$this->authenticator = $authenticator;
	}



	protected function startup()
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
	}



	/**
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentPasswordForm()
	{
		$form = new Form();
		$form->addPassword('oldPassword', 'Staré heslo:', 30)
			->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
		$form->addPassword('newPassword', 'Nové heslo:', 30)
			->addRule(Form::MIN_LENGTH, 'Nové heslo musí mít alespoň %d znaků.', 6);
		$form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
			->addRule(Form::FILLED, 'Nové heslo je nutné zadat ještě jednou pro potvrzení.')
			->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);

		$form->addSubmit('set', 'Změnit heslo');
		$form->onSuccess[] = $this->passwordFormSubmitted;

		return $form;
	}



	public function passwordFormSubmitted(Form $form)
	{
		$values = $form->getValues();
		$user = $this->getUser();

		try {
			$this->authenticator->authenticate(array(
				$user->getIdentity()->username,
				$values->oldPassword
			));
			$this->authenticator->setPassword($user->getId(), $values->newPassword);

			$this->flashMessage('Heslo bylo změněno.', 'success');
			$this->redirect('Homepage:');

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError('Zadané heslo není správné.');
		}
	}

}
