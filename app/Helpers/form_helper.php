<?php
/**
 * Controllers
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

if (! function_exists('h1_title'))
{
	/**
	 * H1タイトル
	 *
	 * @param string $title    タイトル
	 * @param string $subTitle サブタイトル
	 *
	 * @return string
	 */
	function h1_title(string $title, string $subTitle = '')
	{
		return '<h1 class="h3">' . $title . '<span class="lead">' . "\n" .
			$subTitle . '</span></h1>' . "\n";
	}
}

if (! function_exists('anchor_sort'))
{
	/**
	 * ソート用リンク
	 *
	 * @param string $uri        URI string or array of URI segments
	 * @param array  $params     QueryString Array
	 * @param string $sortKey    ソートキー
	 * @param string $title      ラベル
	 * @param mixed  $attributes Any attributes
	 *
	 * @return string
	 */
	function anchor_sort(
		string $uri = '',
		array $params = [],
		string $sortKey = '',
		string $title = '',
		$attributes = ''
	): string
	{
		$p = $params;
		unset($p['page']);
		$p['s'] = $sortKey;
		if (isset($params['s']) && $sortKey === $params['s'])
		{
			if (empty($params['o']) || $params['o'] === 'asc')
			{
				$p['o'] = 'desc';
				$flag   = '<i class="fas fa-sort-amount-up-alt"></i>';
			}
			else
			{
				unset($p['o']);
				$flag = '<i class="fas fa-sort-amount-up"></i>';
			}
		}
		else
		{
			unset($p['o']);
			$flag = '';
		}
		$uri   .= '?' . http_build_query($p);
		$title .= $flag;
		return anchor($uri, $title, $attributes);
	}
}

if (! function_exists('anchor_back_to_index'))
{
	/**
	 * 一覧戻る用リンク
	 *
	 * @param string $uri        URI string or array of URI segments
	 * @param string $title      Title
	 * @param string $cookieName クッキー名
	 * @param mixed  $attributes Any Attribute
	 *
	 * @return string
	 */
	function anchor_back_to_index(
		string $uri = '',
		string $title = '',
		string $cookieName = '',
		$attributes = ''
	): string
	{
		$uri .= ((get_cookie($cookieName)) ? '?' : '') . get_cookie($cookieName);
		return anchor($uri, $title, $attributes);
	}
}
