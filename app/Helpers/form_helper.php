<?php
/**
 * Controllers
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

if (! function_exists('sort_anchor'))
{
	/**
	 * ソート用リンク
	 *
	 * @param string           $uri        URI string or array of URI segments
	 * @param array|null       $params     QueryString Array
	 * @param string           $id         ID
	 * @param string           $name       Name
	 * @param mixed            $attributes Any attributes
	 * @param \Config\App|null $altConfig  Alternate configuration to use
	 *
	 * @return string
	 */
	function sort_anchor(
		string $uri = '',
		array $params = [],
		string $id = '',
		string $name = '',
		$attributes = '',
		$altConfig = null
	): string
	{
		$p = $params;
		unset($p['page']);
		$p['s'] = $id;
		if (isset($params['s']) && $id === $params['s'])
		{
			if (empty($params['o']) || $params['o'] === 'asc')
			{
				$p['o'] = 'desc';
				$flag   = lang('App.sortAsc');
			}
			else
			{
				unset($p['o']);
				$flag = lang('App.sortDesc');
				;
			}
		}
		else
		{
			unset($p['o']);
			$flag = '';
		}
		$uri  .= '?' . http_build_query($p);
		$label = lang($name) . $flag;
		return anchor($uri, $label, $attributes);
	}
}
