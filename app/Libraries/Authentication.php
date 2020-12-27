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

	/**
	 * パスワードリセットメール送信
	 *
	 * @param string $account アカウント(メールアドレス)
	 *
	 * @return object
	 */
	public function sendMailPasswordReset(string $account = null)
	{
		$validation = service('validation');

		$params = compact('account');
		$validation->setRule('account', lang('App.user.email'), 'required|valid_email');
		if (! $validation->run($params))
		{
			return (object) [
								'status'  => false,
								'message' => $validation->getError(),
							];
		}

		$model = model('UserModel');
		$user  = $model->findByEmail($account);
		if ($user)
		{
			helper('text');
			$token = random_string('sha1');
			$model->update($user->id, [
				'remember_token'    => $token,
				'remember_token_at' => date('Y-m-d H:i:s'),
			]);

			$passwordResetURL = base_url('/resetpassword?account=' . $user->email . '&token=' . $token);

			$email = service('email');
			$email
				->setFrom('noreply@eclairpark', lang('App.email.noreply'))
				->setTo($user->email)
				->setSubject(lang('App.email.requestPasswordResetSubject'))
				// ->setMessage(lang('App.email.requestPasswordResetMessage', [$user->name, $url]));
				->setMessage($passwordResetURL);

			// @TODO ルート検証のため無効化
			// $email->send();
			// log_message('debug', $email->printDebugger());
		}

		return (object)
		[
			'status'  => true,
			'message' => lang('App.sendMailPasswordReset'),
		];
	}

	/**
	 * リセット対象ユーザー取得
	 *
	 * @param string $account メールアドレス
	 * @param string $token   トークン
	 *
	 * @return object
	 */
	public function findByToken(string $account, string $token)
	{
		// http://localhost/resetpassword?email=eclairpark%40gmail.com&token=e015d919e36ac3e43fad9ed02692362b7453c132
		// 	if (! $user = service('authentication')->findByToken($email, $token))
		$model = model('UserModel');
		$user  = $model->findByEmail($account);

		$expirationDate = (new \DateTime())->modify('-3 hour')->format('Y-m-d H:i:s');

		// phpcs:ignore
		if ($user && $user->remember_token === $token && strtotime($user->remember_token_at) > strtotime($expirationDate))
		{
			return $user;
		}
		return null;
	}

	/**
	 * パスワードリセット画面表示
	 *
	 * @param string $account  アカウント(メールアドレス)
	 * @param string $token    トークン
	 * @param string $password パスワード
	 *
	 * @return object
	 */
	public function resetPassword(string $account = null, string $token = null, string $password = null)
	{
		$validation = service('validation');

		$params = compact('password');
		$validation->setRule('password', lang('App.user.password'), 'required');
		if (! $validation->run($params))
		{
			return (object) [
								'status'  => false,
								'message' => $validation->getError(),
							];
		}
		$user = $this->findByToken($account, $token);
		if ($user)
		{
			model('UserModel')->update($user->id, [
					  'password'          => $password,
					  'remember_token'    => null,
					  'remember_token_at' => null,
				  ]);
			return (object) [
								'status'  => true,
								'message' => 'App.auth.successfullyPasswordUpdated',
							];
		}
		return (object) [
							'status'  => false,
							'message' => 'App.auth.unsuccessfullyPasswordUpdated',
						];
	}
}
