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
 * ProfileService Library Class
 *
 * @package Library
 */
class ProfileService
{
	/**
	 * 単体データ取得
	 *
	 * @param string $id ID
	 *
	 * @return object
	 */
	public function find(string $id)
	{
		return model('UserModel')->find($id);
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

}
