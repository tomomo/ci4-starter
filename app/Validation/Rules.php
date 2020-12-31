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

	/**
	 * パスワードルール
	 *
	 * @param string $password パスワード
	 *
	 * @return boolean
	 */
	public function password(string $password): bool
	{
		// 半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上30文字以下
		$pattern = '/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,30}+\z/';
		// 半角英数字記号をそれぞれ1種類以上含む8文字以上30文字以下
		// $pattern = '/\A(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,30}+\z/i';
		return (preg_match($pattern, $password));
	}

}
