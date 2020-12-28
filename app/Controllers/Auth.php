<?php
/**
 * Controllers
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Class Example
 *
 * @package CodeIgniter
 */
class Auth extends BaseController
{
	/**
	 * ログイン画面表示
	 *
	 * @return object View
	 */
	public function showLoginPage()
	{
		helper('form');

		$data = [];
		return view('pages/auth/login.html', $data);
	}

	/**
	 * ログイン処理
	 *
	 * @return object Redirect
	 */
	public function login()
	{
		$account  = $this->request->getPost('account');
		$password = $this->request->getPost('password');

		$authenticationed = service('authentication')->login($account, $password);
		if ($authenticationed->status)
		{
			session()->set(['loggedin' => $authenticationed->data]);
			return redirect()
				->to('/')
				->with('success', $authenticationed);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $authenticationed);
	}

	/**
	 * ログアウト処理
	 *
	 * @return object Redirect
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
		return redirect()->route('home');
	}

	/**
	 * パスワード再発行依頼画面表示
	 *
	 * @return object View
	 */
	public function showForgetPasswordPage()
	{
		helper('form');

		$data = [];
		return view('pages/auth/forget.html', $data);
	}

	/**
	 * パスワード再発行依頼メール送信
	 *
	 * @return object Redirect
	 */
	public function sendMailRequestResetPassword()
	{
		$account = $this->request->getPost('account');

		$send = service('authentication')->sendMailPasswordReset($account);
		if ($send->status)
		{
			return redirect()
			->to('/login')
			->with('success', $send);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $send);
	}

	/**
	 * パスワード再設定画面表示
	 *
	 * @return object View
	 */
	public function showResetPasswordPage()
	{
		helper('form');

		$account = $this->request->getGet('account');
		$token   = $this->request->getGet('token');
		if (! $user = service('authentication')->findByToken($account, $token))
		{
			throw PageNotFoundException::forPageNotFound();
		}
		$data = compact('user');
		return view('pages/auth/resetpassword.html', $data);
	}

	/**
	 * パスワード再設定処理
	 *
	 * @return object Redirect
	 */
	public function resetPassword()
	{
		helper('form');

		$reseted = service('authentication')->resetPassword(
			$this->request->getPost('account'),
			$this->request->getPost('token'),
			$this->request->getPost('password')
		);
		if ($reseted->status)
		{
			return redirect()
			->to('/login')
			->with('success', $reseted);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $reseted);
	}

	/**
	 * プロフィール画面表示
	 *
	 * @return object View
	 */
	public function showProfilePage()
	{
		helper('form');

		if (! $user = service('authentication')->me())
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('user');
		return view('pages/auth/profile.html', $data);
	}

	/**
	 * プロフィール更新処理
	 *
	 * @return object Redirect
	 */
	public function updateProfile()
	{
		// @TODO 一旦updateするものとするが、アカウント変更は新しいメール先から承認するようなロジックであるべき
		if (! $user = service('authentication')->me())
		{
			throw PageNotFoundException::forPageNotFound();
		}
		$id      = $user->id;
		$params  = $this->request->getPost();
		$updated = service('userService')->update($id, $params);
		if ($updated->status)
		{
			// @TODO DBは修正されているが、session情報を入れかえる作業が必要
			return redirect()
			->to('/profile')
			->with('success', $updated);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $updated);
	}

}
