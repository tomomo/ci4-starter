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
 * Auth Entity Class
 *
 * @package Entity
 */
class Auth extends \CodeIgniter\Entity
{
	/**
	 * ID
	 *
	 * @var string $id
	 */
	protected $id;
	/**
	 * メールアドレス
	 *
	 * @var string $email
	 */
	protected $email;
	/**
	 * 氏名
	 *
	 * @var string $name
	 */
	protected $name;
}
