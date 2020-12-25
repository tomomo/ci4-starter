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
 * Class User Model
 *
 * @package CodeIgniter
 */
class UserModel extends \CodeIgniter\Model
{
	 /**
	  * テーブル名
	  *
	  * @var $table
	  */
	 protected $table = 'users';
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
		'email',
		'name',
		'name_kana',
		'password',
		'remember_token',
		'remember_token_at',
	];
	/**
	 * ヴァリデーションルール
	 *
	 * @var $allowedFields
	 */
	protected $validationRules = [
		'email'     => 'required|valid_email|is_unique[users.email,id,{id}]',
		'name'      => 'required|max_length[50]',
		'name_kana' => 'required|max_length[100]',
		'password'  => 'required',
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
	 * 汎用的検索クエリ
	 *
	 * @param mixed  $params     検索
	 * @param string $aliasTable エイリアス名
	 *
	 * @return object UserModel
	 */
	public function search($params = null, string $aliasTable = null)
	{
		if (isset($params['text']))
		{
			$str   = $params['text'];
			$table = $aliasTable ?? $this->table;
			$this
				->groupStart()
				->orLike($table . '.name', $str)
				->orLike($table . '.name_kana', $str)
				->orLike($table . '.email', $str)
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
	 * @return object UserModel
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
