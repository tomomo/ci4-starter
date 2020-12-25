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
 * Create Session Table Class
 *
 * @package CodeIgniter
 */
class Migration_create_sessions_table extends \CodeIgniter\Database\Migration
{
	/**
	 * テーブル名
	 *
	 * @var $table
	 */
	private $table = 'sessions';

	/**
	 * テーブル作成
	 *
	 * @return void
	 */
	public function up()
	{
		$this->forge->addField([
			'id'         => [
				'type'       => 'VARCHAR',
				'constraint' => 128,
				'null'       => false,
			],
			'ip_address' => [
				'type'       => 'VARCHAR',
				'constraint' => 45,
				'null'       => false,
			],
			'timestamp'  => [
				'type'       => 'INT',
				'constraint' => 10,
				'unsigned'   => true,
				'null'       => false,
				'default'    => 0,
			],
			'data'       => [
				'type'    => 'TEXT',
				'null'    => false,
				'default' => '',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('timestamp');
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
