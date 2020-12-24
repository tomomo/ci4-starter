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
 * Create InformationSeeder Class
 *
 * @package CodeIgniter
 */
class InformationSeeder extends \CodeIgniter\Database\Seeder
{
	/**
	 * テストデータ作成
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = \Faker\Factory::create('ja_JP');
		$model = model('InformationModel');

		$qty = 64;
		for ($i = 0; $i < $qty; $i += 1)
		{
			$model->insert([
				'subject' => $faker->realText($faker->numberBetween(10, 20)),
				'message' => $faker->realText($faker->numberBetween(300, 400)),
			]);
		}
	}
}
