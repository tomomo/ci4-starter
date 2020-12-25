<?php
/**
 * Filters
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Login Filter Class
 *
 * @package Filter
 */
class Login implements \CodeIgniter\Filters\FilterInterface {
	/**
	 * Before Process
	 *
	 * @param RequestInterface $request   リクエスト
	 * @param mixed            $arguments 引数
	 *
	 * @return mixed
	 */
	public function before(
		RequestInterface $request,
		$arguments = null
	)
	{
		$router = service('router');

		// @MEMO exampleは様々なものを試すために置くコントローラーなので除外
		$controller = $router->controllerName();
		$controller = explode('\\', $controller);
		$controller = strtolower(end($controller));
		$exclude    = ! in_array($controller, ['example']);

		$authentication = service('authentication');
		if (! $authentication->isLoggedIn() && $exclude)
		{
			return redirect()->to('/login');
		}
	}

	/**
	 * After Process
	 *
	 * @param CodeIgniter\HTTP\RequestInterface  $request   リクエスト
	 * @param CodeIgniter\HTTP\ResponseInterface $response  レスポンス
	 * @param mixed                              $arguments 引数
	 *
	 * @return void
	 */
	public function after(
		RequestInterface $request,
		ResponseInterface $response,
		$arguments = null
	)
	{
		// Do something here
	}
}
