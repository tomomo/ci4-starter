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
	 * @return obejct Redirect
	 */
	public function create()
	{
		$model = model('InformationModel');

		$params = $this->request->getPost();

		if (! $model->insert($params))
		{
			$error = (object) [
								  'message' => lang('App.inputErrors'),
								  'data'    => (object) $model->errors(),
							  ];
			return redirect()
				->back()
				->withInput()
				->with('error', $error);
		}
		$id = $model->insertID();
		return redirect()
			->to('/informations/edit/' . $id)
			->with('success', (object) ['message' => lang('App.informations.successfullyCreated')]);
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
		// @REVIEW 生成されたrouteの其れに従ってidを使っているが、sessionに持たせるべきかと思う。
		if (empty($id))
		{
			return $this->response->setStatusCode(500)->setBody('Internal Server Error');
		}

		$model  = model('InformationModel');
		$params = compact('id') + $this->request->getPost();

		if (! $model->update($id, $params))
		{
			$error = (object) [
								  'message' => lang('App.inputErrors'),
								  'data'    => (object) $model->errors(),
							  ];
			return redirect()
				->back()
				->withInput()
				->with('error', $error);
		}
		return redirect()
			->to('/informations/edit/' . $id)
			->with('success', (object) ['message' => lang('App.informations.successfullyUpdated')]);
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
		// @REVIEW 生成されたrouteのルールに従ってidを使ってはいるが、sessionに持たせるべきかと思う。
		if (empty($id))
		{
			return $this->response->setStatusCode(500)->setBody('Internal Server Error');
		}

		$model = model('InformationModel');
		if (! $model->delete($id))
		{
			$error = (object)[
								 'message' => lang('App.inputErrors'),
								 'data'    => (object) $model->errors(),
							 ];
			return redirect()
				->back()
				->withInput()
				->with('error', $error);
		}
		return redirect()
			->to('/informations')
			->with('success', (object) ['message' => lang('App.informations.successfullyDeleted')]);
	}
}
