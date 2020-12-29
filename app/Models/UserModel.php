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
	protected $returnType = 'App\Entities\User';
	// @REVIWE Entityを指定した場合、created_atなどのjsonの内容が変わる。

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
		'email'     => [
			'label' => 'App.user.email',
			'rules' => 'required|valid_email|is_unique[users.email,id,{id}]',
		],
		'name'      => [
			'label' => 'App.user.name',
			'rules' => 'required|max_length[50]',
		],
		'name_kana' => [
			'label' => 'App.user.nameKana',
			'rules' => 'required|max_length[100]|hiragana',
		],
		'password'  => [
			'label' => 'App.user.password',
			'rules' => 'required',
		],
	];
	/**
	 * INSERT事前処理
	 *
	 * @var $beforeInsert
	 */
	protected $beforeInsert = ['hashPassword'];
	/**
	 * UPDATE事前処理
	 *
	 * @var $beforeUpdate
	 */
	protected $beforeUpdate = ['hashPassword'];
	/**
	 * パスワードハッシュ処理
	 *
	 * @param array $data データ
	 *
	 * @return array
	 */
	protected function hashPassword(array $data)
	{
		if (! isset($data['data']['password']))
		{
			return $data;
		}

		$data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
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
