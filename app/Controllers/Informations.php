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

		$information = model('InformationModel')
			->search($params)
			->sort($params)
			->page();

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

		if (! $information = model('InformationModel')->find($id))
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

		if (! $information = model('InformationModel')->find($id))
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

		if (! $information = model('InformationModel')->find($id))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		$data = compact('information');
		return view('pages/informations/remove.html', $data);
	}

	/**
	 * 作成処理
	 *
	 * @return void
	 */
	public function create()
	{
		echo __METHOD__;
	}

	/**
	 * 更新処理
	 *
	 * @param string $id ID
	 *
	 * @return void
	 */
	public function update(string $id = null)
	{
		echo __METHOD__;
	}

	/**
	 * 更新処理
	 *
	 * @param string $id ID
	 *
	 * @return void
	 */
	public function delete(string $id = null)
	{
		echo __METHOD__;
	}
}
