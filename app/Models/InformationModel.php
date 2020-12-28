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
class InformationModel extends BaseModel
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
	 * 汎用的検索クエリ
	 *
	 * @param mixed  $params     検索
	 * @param string $aliasTable エイリアス名
	 *
	 * @return object InformationModel
	 */
	public function search($params = null, string $aliasTable = null)
	{
		if (isset($params['text']))
		{
			$str   = $params['text'];
			$table = $aliasTable ?? $this->table;
			$this
				->groupStart()
				->orLike($table . '.subject', $str)
				->orLike($table . '.message', $str)
				->groupEnd();
		}
		return $this;
	}

	/**
	 * ソート
	 *
	 * @param array $params ソート条件 $params s:対象項目
	 *                                         o:昇順/降順
	 *
	 * @return object InformationModel
	 */
	public function sort(array $params = null)
	{
		if (! isset($params['s']))
		{
			return $this;
		}
		$sort = $params['s'];
		if (in_array(mb_strtolower($sort), ['subject', 'created_at', 'updated_at']))
		{
			$order = mb_strtolower($params['o'] ?? null);
			$order = (in_array($order, ['asc', 'desc'])) ? $order : 'asc';
			$this->orderBy($sort, $order);
		}
		return $this;
	}
}
