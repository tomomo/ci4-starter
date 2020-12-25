<?php
/**
 * Controllers
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Controllers;

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
		service('authentication')->logout();
		return redirect()->route('home');
	}
}
