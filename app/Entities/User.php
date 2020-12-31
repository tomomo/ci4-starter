<?php
/**
 * Entities
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Entities;

/**
 * User Entity Class
 *
 * @package Entity
 */
class User extends \CodeIgniter\Entity
{
	/**
	 * データマップ
	 *
	 * データベースカラムはスネークケース, 変数はキャメル
	 *
	 * @var $datamap
	 */
	protected $datamap = [
		'nameKana'        => 'name_kana',
		'rememberToken'   => 'remember_token',
		'rememberTokenAt' => 'remember_token_at',
		'createdAt'       => 'created_at',
		'updatedAt'       => 'updated_at',
		'deletedAt'       => 'deleted_at',
	];
}
