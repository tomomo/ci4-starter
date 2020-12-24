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
		$sort   = $this->request->getGet('s');
		$order  = $this->request->getGet('o');
		setCookie('informations', http_build_query($params));

		$information = model('InformationModel')
			->search($params)
			->sort($sort, $order)
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
		echo __METHOD__;
		return view('example.html');
	}

	/**
	 * 作成画面表示
	 *
	 * @return object View
	 */
	public function new()
	{
		echo __METHOD__;
		return view('example.html');
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
		echo __METHOD__;
		return view('example.html');
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
		echo __METHOD__;
		return view('example.html');
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
