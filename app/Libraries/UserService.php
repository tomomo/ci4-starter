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
 * UserService Library Class
 *
 * @package Library
 */
class UserService
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
		$user = model('UserModel')
			->search($params)
			->sort($params)
			->page();
		return $user;
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
		return model('UserModel')->find($id);
	}

	/**
	 * 作成処理
	 *
	 * @param array|object $data 作成データ
	 *
	 * @return obejct
	 */
	public function create($data)
	{
		$model = model('UserModel');

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
				'message' => lang('App.users.successfullyCreated'),
				'data'    => (object)
					[
						'id' => $model->insertID(),
					],
			];
	}

	/**
	 * 更新処理
	 *
	 * @param string       $id   更新対象ID
	 * @param array|object $data 更新データ
	 *
	 * @return obejct
	 */
	public function update(string $id, $data)
	{
		$model = model('UserModel');
		$data  = compact('id') + (array) $data;

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
				'message' => lang('App.users.successfullyUpdated'),
			];
	}

	/**
	 * 削除処理
	 *
	 * @param string $id ID
	 *
	 * @return obejct
	 */
	public function delete(string $id)
	{
		$model = model('UserModel');
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
				'message' => lang('App.users.successfullyDeleted'),
			];
	}
}
