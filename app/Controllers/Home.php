<?php
/**
 * Controllers
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Controllers;

/**
 * Class Home
 *
 * @package CodeIgniter
 */
class Home extends BaseController
{
	/**
	 * Welcomepage
	 *
	 * @return object View
	 */
	public function index()
	{
		return view('welcome_message');
	}
}
