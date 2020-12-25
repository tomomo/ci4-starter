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
 * Class Informations
 *
 * @package CodeIgniter
 */
class Informations extends BaseController
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
		setCookie('informations', http_build_query($params));

		$information = service('informationService')->searchPage($params);

		$data = compact('information', 'params');
		return view('pages/informations/index.html', $data);
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

		if (! $information = service('informationService')->find($id))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('information');
		return view('pages/informations/show.html', $data);
	}

	/**
	 * 作成画面表示
	 *
	 * @return object View
	 */
	public function new()
	{
		helper(['form', 'cookie']);

		return view('pages/informations/new.html');
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

		if (! $information = service('informationService')->find($id))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('information');
		return view('pages/informations/edit.html', $data);
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

		if (! $information = service('informationService')->find($id))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('information');
		return view('pages/informations/remove.html', $data);
	}

	/**
	 * 作成処理
	 *
	 * @return obejct Redirect
	 */
	public function create()
	{
		$params  = $this->request->getPost();
		$created = service('informationService')->create($params);
		if ($created->status)
		{
			return redirect()
			->to('/informations/edit/' . $created->data->id)
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
		$updated = service('informationService')->update($id, $params);
		if ($updated->status)
		{
			return redirect()
			->to('/informations/edit/' . $id)
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
		$deleted = service('informationService')->delete($id);
		if ($deleted->status)
		{
			return redirect()
			->to('/informations')
			->with('success', $deleted);
		}
		return redirect()
			->back()
			->withInput()
			->with('error', $deleted);
	}
}
