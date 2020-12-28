<?php
/**
 * Models
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

/**
 * Class Base Model
 *
 * @package CodeIgniter
 */
class BaseModel extends \CodeIgniter\Model
{
	/**
	 * Model constructor.
	 *
	 * @param ConnectionInterface $db         DB
	 * @param ValidationInterface $validation Validation
	 */
	public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
	{
		parent::__construct($db, $validation);
	}

	/**
	 * ページ単位出力
	 *
	 * @return object
	 */
	public function page()
	{
		$total = $this->countAllResults(false);
		$data  = (object) [
							  'total' => $total,
							  'items' => $this->paginate(),
							  'pager' => $this->pager,
						  ];
		return $data;
	}
}
