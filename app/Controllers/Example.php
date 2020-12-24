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
 * Class Example
 *
 * @package CodeIgniter
 */
class Example extends BaseController
{
	/**
	 * Welcomepage
	 *
	 * @return object View
	 */
	public function index()
	{
		return view('example.html');
	}
}
