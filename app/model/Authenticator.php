<?php

namespace Todo;

use Nette,
	Nette\Security,
	Nette\Utils\Strings;


/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Security\IAuthenticator
{
	/** @var UserRepository */
	private $users;



	public function __construct(UserRepository $users)
	{
		$this->users = $users;
	}



	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$row = $this->users->findByName($username);

		if (!$row) {
			throw new Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		}

		if ($row->password !== $this->calculateHash($password, $row->password)) {
			throw new Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		}

		unset($row->password);
		return new Security\Identity($row->id, NULL, $row->toArray());
	}



	/**
	 * @param  int $id
	 * @param  string $password
	 */
	public function setPassword($id, $password)
	{
		$this->users->findBy(array('id' => $id))->update(array(
			'password' => $this->calculateHash($password),
		));
	}



	/**
	 * Computes salted password hash.
	 * @param string
	 * @return string
	 */
	public static function calculateHash($password, $salt = NULL)
	{
		if ($password === Strings::upper($password)) { // perhaps caps lock is on
			$password = Strings::lower($password);
		}
		return crypt($password, $salt ?: '$2a$07$' . Strings::random(22));
	}

}
