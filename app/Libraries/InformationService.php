<?php
/**
 * Libraries
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Libraries;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * InformationService Library Class
 *
 * @package Library
 */
class InformationService
{
	/**
	 * データ取得
	 *
	 * @param array $params パラメーター
	 *
	 * @return object
	 */
	public function searchPage(array $params)
	{
		$information = model('InformationModel')
			->search($params)
			->sort($params)
			->page();
		return $information;
	}

	/**
	 * データ取得
	 *
	 * @param string $id ID
	 *
	 * @return object
	 */
	public function find(string $id = null)
	{
		if (empty($id))
		{
			return null;
		}
		return model('InformationModel')->find($id);
	}

	/**
	 * 作成処理
	 *
	 * @param array $data データ
	 *
	 * @return obejct
	 */
	public function create(array $data)
	{
		$model = model('InformationModel');

		if (! $model->insert($data))
		{
			return (object)
				[
					'status'  => false,
					'message' => lang('App.inputErrors'),
					'data'    => (object) $model->errors(),
				];
		}
		return (object)
			[
				'status'  => true,
				'message' => lang('App.informations.successfullyCreated'),
				'data'    => (object)
					[
						'id' => $model->insertID(),
					],
			];
	}

	/**
	 * 更新処理
	 *
	 * @param string $id   ID
	 * @param array  $data Data
	 *
	 * @return obejct Redirect
	 */
	public function update(string $id, array $data = [])
	{
		$model = model('InformationModel');
		$data  = compact('id') + $data;

		if (! $model->update($id, $data))
		{
			return (object)
				[
					'status'  => false,
					'message' => lang('App.inputErrors'),
					'data'    => (object) $model->errors(),
				];
		}
		return (object)
			[
				'status'  => true,
				'message' => lang('App.informations.successfullyUpdated'),
			];
	}

	/**
	 * 削除処理
	 *
	 * @param string $id ID
	 *
	 * @return obejct Redirect
	 */
	public function delete(string $id)
	{
		$model = model('InformationModel');
		if (! $model->delete($id))
		{
			return (object)
				[
					'status'  => false,
					'message' => lang('App.inputErrors'),
					'data'    => (object) $model->errors(),
				];
		}
		return (object)
			[
				'status'  => true,
				'message' => lang('App.informations.successfullyDeleted'),
			];
	}
}
