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

	/**
	 * ソート
	 *
	 * @param array $fields ソート情報
	 * @param array $params ソート条件 $params s:対象項目
	 *                                         o:昇順/降順
	 *
	 * @return object UserModel
	 */
	public function sort(array $fields, array $params = null)
	{
		if (isset($params['s']) && (isset($fields[mb_strtolower($params['s'])])))
		{
			$sort  = $fields[mb_strtolower($params['s'])];
			$order = mb_strtolower($params['o'] ?? null);
			$order = (in_array($order, ['asc', 'desc'])) ? $order : 'asc';
			$this->orderBy($sort, $order);
		}
		return $this;
	}
}
