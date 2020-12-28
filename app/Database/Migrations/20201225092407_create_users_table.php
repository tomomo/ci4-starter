<?php
/**
 * Migrations
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Database\Migrations;

/**
 * Create Users Table Class
 *
 * @package CodeIgniter
 */
class Migration_create_users_table extends \CodeIgniter\Database\Migration
{
	/**
	 * テーブル名
	 *
	 * @var $table
	 */
	private $table = 'users';

	/**
	 * テーブル作成
	 *
	 * @REVIEW 旧MySQLなどtimestampが複数置けないケースがあるのでdatetimeにしている部分がある。
	 *
	 * @return void
	 */
	public function up()
	{
		$this->forge->addField([
			'id'                => [
				'type'           => 'BIGINT',
				'unsigned'       => true,
				'null'           => false,
				'auto_increment' => true,
			],
			'email'             => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => false,
				'uniqe'      => true,
			],
			'name'              => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => false,
			],
			'name_kana'         => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => false,
			],
			'password'          => [
				'type'       => 'VARCHAR',
				'constraint' => 500,
				'null'       => false,
			],
			'remember_token'    => [
				'type'       => 'VARCHAR',
				'constraint' => 120,
				'null'       => true,
			],
			'remember_token_at' => [
				'type'    => 'DATETIME',
				'null'    => true,
				'default' => null,
			],
			'created_at'        => [
				'type' => 'DATETIME',
				'null' => false,
			],
			'updated_at'        => [
				'type' => 'DATETIME',
				'null' => false,
			],
			'deleted_at'        => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addPrimaryKey('id');
		$this->forge->addUniqueKey('email');
		$this->forge->addUniqueKey('remember_token');
		$this->forge->createTable($this->table, true);
	}

	/**
	 * テーブル削除
	 *
	 * @return void
	 */
	public function down()
	{
		$this->forge->dropTable($this->table, true);
	}
}
