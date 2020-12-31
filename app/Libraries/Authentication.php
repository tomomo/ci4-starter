<?php
/**
 * Libraries
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Libraries;

/**
 * Authentication Library Class
 *
 * @package Library
 */
class Authentication
{
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
		$loginUser = new \App\Entities\LoginUser([
			'id'    => $user->id,
			'name'  => $user->name,
			'email' => $user->email,
		]);

		return (object)
			[
				'status'  => true,
				'message' => lang('App.authorized'),
				'data'    => $loginUser,
			];
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
		$validation->setRule('account', lang('App.account'), 'required|valid_email');
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

			// @TODO 何処でも使うため、メール送信機能は切り離すべき。スレッド化するべき。
			$email = service('email');
			$email
				->setFrom('noreply@example.com', lang('App.email.noreply'))
				->setTo($user->email)
				->setSubject(lang('App.email.requestPasswordResetSubject'))
				// ->setMessage(lang('App.email.requestPasswordResetMessage', [$user->name, $url]));
				->setMessage($passwordResetURL);

			$email->send();
			log_message('notice', __METHOD__ . ' to: ' . $user->email);
			log_message('notice', $email->printDebugger());
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
		$validation->setRule('password', lang('App.user.password'), 'required|password');
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
							'message' => 'App.auth.unSuccessfullyPasswordUpdated',
						];
	}
}
