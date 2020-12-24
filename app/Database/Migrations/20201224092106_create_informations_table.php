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
 * Create Informations Table Class
 *
 * @package CodeIgniter
 */
class Migration_create_informations_table extends \CodeIgniter\Database\Migration
{
	/**
	 * テーブル名
	 *
	 * @var $table
	 */
	private $table = 'informations';

	/**
	 * テーブル作成
	 *
	 * @return void
	 */
	public function up()
	{
		$this->forge->addField([
			'id'         => [
				'type'           => 'BIGINT',
				'unsigned'       => true,
				'null'           => false,
				'auto_increment' => true,
			],
			'title'      => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => false,
			],
			'text'       => [
				'type'       => 'VARCHAR',
				'constraint' => 800,
				'null'       => false,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => false,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => false,
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addPrimaryKey('id');
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
