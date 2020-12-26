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
	 * 一覧データ取得
	 *
	 * @param array $params 検索条件、ソート条件
	 *
	 * @return object
	 */
	public function searchPage(array $params)
	{
		$excludeUserId = service('authentication')->me('id');

		$user = model('UserModel')
			->exclude($excludeUserId)
			->search($params)
			->sort($params)
			->page();
		return $user;
	}

	/**
	 * 単体データ取得
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

		$excludeUserId = service('authentication')->me('id');
		return model('UserModel')->exclude($excludeUserId)->find($id);
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
