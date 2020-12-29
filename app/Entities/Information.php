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
 * Information Entity Class
 *
 * @package Entity
 */
class Information extends \CodeIgniter\Entity
{
	/**
	 * データマップ
	 *
	 * データベースカラムはスネークケース, 変数はキャメル
	 *
	 * @var $datamap
	 */
	protected $datamap = [
		'createdAt' => 'created_at',
		'updatedAt' => 'updated_at',
		'deletedAt' => 'deleted_at',
	];
}
