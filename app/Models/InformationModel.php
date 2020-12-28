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
		'subject' => [
			'label' => 'App.information.subject',
			'rules' => 'required|max_length[100]',
		],
		'message' => [
			'label' => 'App.information.message',
			'rules' => 'required|max_length[100]',
		],
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
}
