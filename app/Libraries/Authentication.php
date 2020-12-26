<?php
/**
 * Libraries
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Libraries;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Authentication Library Class
 *
 * @package Library
 */
class Authentication
{
	/**
	 * セッション名;
	 *
	 * @var $loginSessionName
	 */
	protected $loginSessionName = 'loggedin';

	/**
	 * ログイン
	 *
	 * @param string $account  アカウント
	 * @param string $password パスワード
	 *
	 * @return object
	 */
	public function login(string $account = null, string $password = null)
	{
		$user = model('UserModel')->findByEmail($account);
		if (! ($user && password_verify($password, $user->password)))
		{
			return (object)
				[
					'status'  => false,
					'message' => lang('App.unauthorized'),
				];
		}
		session()->set([
					 $this->loginSessionName => (object)
							[
								'id'    => $user->id,
								'email' => $user->email,
								'name'  => $user->name,
							],
				 ]);
		return (object)
			[
				'status'  => true,
				'message' => lang('App.authorized'),
			];
	}

	/**
	 * ログイン情報取得
	 *
	 * @param string $key キー名
	 *
	 * @return object ログイン情報
	 */
	public function me(string $key = null)
	{
		$data = session($this->loginSessionName);
		if ($key)
		{
			return $data->{$key} ?? null;
		}
		return $data;
	}

	/**
	 * ログイン処理
	 *
	 * @return boolean
	 */
	public function isLoggedIn()
	{
		return session()->has($this->loginSessionName);
	}

	/**
	 * ログアウト処理
	 *
	 * @return void
	 */
	public function logout()
	{
		$_SESSION = [];
		if (ini_get('session.use_cookies'))
		{
			$argv = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$argv['path'],
				$argv['domain'],
				$argv['secure'],
				$argv['httponly']
			);
		}
		session_destroy();
	}
}
