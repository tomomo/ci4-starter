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
 * Class Users
 *
 * @package CodeIgniter
 */
class Users extends BaseController
{
	/**
	 * 一覧表示
	 *
	 * @return object View
	 */
	public function index()
	{
		helper(['form', 'cookie']);

		$params = $this->request->getGet();
		setCookie('users', http_build_query($params));

		$user = service('userService')->searchPage($params, $this->session->loggedin);

		$data = compact('user', 'params');
		return view('pages/users/index.html', $data);
	}

	/**
	 * 詳細表示
	 *
	 * @param string $id ID
	 *
	 * @return object View
	 */
	public function show(string $id = null)
	{
		helper(['form', 'cookie']);

		if (! $user = service('userService')->find($id, $this->session->loggedin))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('user');
		return view('pages/users/show.html', $data);
	}

	/**
	 * 作成画面表示
	 *
	 * @return object View
	 */
	public function new()
	{
		helper(['form', 'cookie']);

		return view('pages/users/new.html');
	}

	/**
	 * 編集画面表示
	 *
	 * @param string $id ID
	 *
	 * @return object View
	 */
	public function edit(string $id = null)
	{
		helper(['form', 'cookie']);

		if (! $user = service('userService')->find($id, $this->session->loggedin))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('user');
		return view('pages/users/edit.html', $data);
	}

	/**
	 * 削除確認画面表示
	 *
	 * @param string $id ID
	 *
	 * @return object View
	 */
	public function remove(string $id = null)
	{
		helper(['form', 'cookie']);

		if (! $user = service('userService')->find($id, $this->session->loggedin))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('user');
		return view('pages/users/remove.html', $data);
	}

	/**
	 * 作成処理
	 *
	 * @return obejct Redirect
	 */
	public function create()
	{
		$params  = $this->request->getPost();
		$created = service('userService')->create($params);
		if ($created->status)
		{
			return redirect()
			->to('/users/edit/' . $created->data->id)
			->with('success', $created);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $created);
	}

	/**
	 * 更新処理
	 *
	 * @param string $id ID
	 *
	 * @return obejct Redirect
	 */
	public function update(string $id = null)
	{
		$params  = $this->request->getPost();
		$updated = service('userService')->update($id, $params);
		if ($updated->status)
		{
			return redirect()
			->to('/users/edit/' . $id)
			->with('success', $updated);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $updated);
	}

	/**
	 * 削除処理
	 *
	 * @param string $id ID
	 *
	 * @return obejct Redirect
	 */
	public function delete(string $id = null)
	{
		$params = $this->request->getPost();
		// @REVIEW 生成されたrouteのルールに従ってidを使ってはいるが、sessionに持たせるべきかと思う。
		$deleted = service('userService')->delete($id);
		if ($deleted->status)
		{
			return redirect()
			->to('/users')
			->with('success', $deleted);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $deleted);
	}
}
