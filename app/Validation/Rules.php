<?php
/**
 * Validation
 *
 * @package CodeIgniter
 * @author  tomomo <eclairpark@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace App\Validation;

/**
 * Validation Rules.
 *
 * @package CodeIgniter\Validation
 */
class Rules
{
	/**
	 * ひらがな&スペースチェック
	 *
	 * @param string $str Value
	 *
	 * @return boolean
	 */
	public function hiragana(string $str = null): bool
	{
		if (is_object($str))
		{
			return true;
		}
		return preg_match('/^[ぁ-んー　 ]+$/u', $str);
	}

	/**
	 * カタカナ&スペースチェック
	 *
	 * @param string $str Value
	 *
	 * @return boolean
	 */
	public function katakana(string $str = null): bool
	{
		if (is_object($str))
		{
			return true;
		}
		return preg_match('/^[ァ-ヶー　 ]+$/u', $str);
	}
}
