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
 * Class Profiles
 *
 * @package CodeIgniter
 */
class Profiles extends BaseController
{
	/**
	 * プロフィール画面編集
	 *
	 * @return object View
	 */
	public function edit()
	{
		helper('form');

		if (! session()->has('loggedin'))
		{
			throw PageNotFoundException::forPageNotFound();
		}
		$user = service('profileService')->find($this->session->loggedin->id);
		if (! $user)
		{
			throw PageNotFoundException::forPageNotFound();
		}
		$loginUser = new \App\Entities\LoginUser([
			'id'    => $user->id,
			'name'  => $user->name,
			'email' => $user->email,
		]);
		session()->set(['loggedin' => $loginUser]);

		$data = compact('user');
		return view('pages/profiles/edit.html', $data);
	}

	/**
	 * プロフィール更新処理
	 *
	 * @return object Redirect
	 */
	public function update()
	{
		if (! session()->has('loggedin'))
		{
			throw PageNotFoundException::forPageNotFound();
		}
		$params = $this->request->getPost();

		$updated = service('profileService')->update($this->session->loggedin->id, $params);
		if ($updated->status)
		{
			return redirect()
				->to('/profiles/edit')
				->with('success', $updated);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $updated);
	}
}
