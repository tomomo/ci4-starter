<?php
/**
 * Models
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Models;

/**
 * Class Information Model
 *
 * @package CodeIgniter
 */
class InformationModel extends \CodeIgniter\Model
{
	 /**
	  * テーブル名
	  *
	  * @var $table
	  */
	 protected $table = 'informations';
	 /**
	  * 主キー
	  *
	  * @var $primaryKey
	  */
	 protected $primaryKey = 'id';
	/**
	 * 結果データの型
	 *
	 * @var $returnType
	 */
	protected $returnType = 'object';
	/**
	 * 論理削除フラグ
	 *
	 * @var $useSoftDeletes
	 */
	protected $useSoftDeletes = true;
	/**
	 * タイムスタンプ
	 *
	 * @var $useTimestamps
	 */
	protected $useTimestamps = true;
	/**
	 * 操作可能フィールド
	 *
	 * @var $allowedFields
	 */
	protected $allowedFields = [
		'subject',
		'message',
	];
	/**
	 * ヴァリデーションルール
	 *
	 * @var $allowedFields
	 */
	protected $validationRules = [
		'subject' => 'required|max_length[100]',
		'message' => 'required|max_length[800]',
	];

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
	 * @param string $sortKey ソートキー
	 * @param string $order   昇順降順
	 *
	 * @return object
	 */
	public function sort(string $sortKey = null, string $order = null)
	{
		if (in_array(mb_strtolower($sortKey), ['subject', 'created_at', 'updated_at']))
		{
			$order = mb_strtolower($order);
			$order = (in_array($order, ['asc', 'desc'])) ? $order : 'asc';
			$this->orderBy($this->table . '.' . $sortKey, $order);
		}
		return $this;
	}

}
