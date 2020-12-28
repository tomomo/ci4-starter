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
class UserModel extends BaseModel
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
	protected $returnType = 'App\Entities\User'; //'object';
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
		'name_kana' => 'required|max_length[100]|hiragana',
		'password'  => 'required',
	];

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

	/**
	 * メールアドレスからデータ取得
	 *
	 * @param string $email メールアドレス
	 *
	 * @return object
	 */
	public function findByEmail(string $email)
	{
		return $this->where('email', $email)->first();
	}

	/**
	 * データ事前変換処理
	 *
	 * @param array|object $data カラムデータ
	 *
	 * @return void
	 */
	private function convertDataBefore(&$data)
	{
		$data = (array) $data;
		if (isset($data['password']))
		{
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		}
	}

	/**
	 * 登録処理
	 *
	 * @param array|object $data     Data
	 * @param boolean      $returnID Whether insert ID should be returned or not.
	 *
	 * @return integer|string|boolean
	 */
	public function insert($data = null, bool $returnID = true): bool
	{
		$this->convertDataBefore($data);
		return parent::insert($data, $returnID);
	}

	/**
	 * 更新処理
	 *
	 * @param integer|array|string $id   ID
	 * @param array|object         $data Data
	 *
	 * @return boolean
	 */
	public function update($id = null, $data = null): bool
	{
		$this->convertDataBefore($data);
		return parent::update($id, $data);
	}

	/**
	 * 指定したIDを除外
	 *
	 * @param string|array $id         ID
	 * @param string       $aliasTable エイリアス名
	 *
	 * @return object UserModel
	 */
	public function exclude($id = null, string $aliasTable = null)
	{
		$this->whereNotIn('id', (array) $id);
		return $this;
	}

}
