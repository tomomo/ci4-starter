<?php
/**
 * Seeders
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Database\Seeds;

/**
 * Create UserSeeder Class
 *
 * @package CodeIgniter
 */
class UserSeeder extends \CodeIgniter\Database\Seeder
{
	/**
	 * テストデータ作成
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = \Faker\Factory::create('ja_JP');
		$model = model('UserModel');

		$model->insert([
			'email'     => 'eclairpark@gmail.com',
			'name'      => 'と桃',
			'name_kana' => 'ともも',
			'password'  => 'pass',
		]);
	}
}
