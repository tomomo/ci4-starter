<?php
/**
 * Libraries
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Libraries;

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
	 * @param array  $params    検索条件、ソート条件
	 * @param object $loginUser ログインユーザー情報
	 *
	 * @return object
	 */
	public function searchPage(array $params, $loginUser)
	{
		$excludeUserId = $loginUser->id;
		$sortFields    = [
			'email'      => 'email',
			'name'       => 'name_kana',
			'created_at' => 'created_at',
			'updated_at' => 'updated_at',
		];

		$user = model('UserModel')
			->exclude($excludeUserId)
			->search($params)
			->sort($sortFields, $params)
			->page();
		return $user;
	}

	/**
	 * 単体データ取得（自身を除く）
	 *
	 * @param string $id        ID
	 * @param object $loginUser ログインユーザー
	 *
	 * @return object
	 */
	public function find(string $id, object $loginUser)
	{
		return model('UserModel')->exclude($loginUser->id)->find($id);
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
