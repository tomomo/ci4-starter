<?php
/**
 * Controllers
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Controllers\Api;

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
	 * @return object ページデータ
	 */
	public function index()
	{
		$params = $this->request->getGet();
		$data   = service('informationService')->searchPage($params);

		return $this->respond($data);
	}

	/**
	 * 詳細表示
	 *
	 * @param mixed $id ID
	 *
	 * @return object 単一データ
	 */
	public function show($id = null)
	{
		if ($data = service('informationService')->find($id))
		{
			return $this->respond($data);
		}
		return $this->respond(null, $this->codes['resource_not_found']);
	}

	/**
	 * 作成処理
	 *
	 * @return obejct 作成結果
	 */
	public function create()
	{
		$params = $this->request->getJSON();
		$data   = service('informationService')->create($params);
		if ($data->status)
		{
			return $this->respond($data, $this->codes['created']);
		}
		return $this->respond($data, $this->codes['invalid_request']);
	}

	/**
	 * 更新処理
	 *
	 * @param mixed $id ID
	 *
	 * @return obejct 更新結果
	 */
	public function update($id = null)
	{
		$params = $this->request->getJSON();
		$data   = service('informationService')->update($id, $params);
		if ($data->status)
		{
			return $this->respond($data, $this->codes['updated']);
		}
		return $this->respond($data, $this->codes['invalid_request']);
	}

	/**
	 * 削除処理
	 *
	 * @param mixed $id ID
	 *
	 * @return obejct 削除結果
	 */
	public function delete($id = null)
	{
		$data = service('informationService')->delete($id);
		if ($data->status)
		{
			return $this->respond($data, $this->codes['deleted']);
		}
		return $this->respond($data, $this->codes['invalid_request']);
	}
}
