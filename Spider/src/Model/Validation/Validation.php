<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Saleh
 * Date: 8/1/2016
 * Time: 12:14 AM
 */

namespace Spider\Model\Validation;


use Cake\Validation\Validation as CakeValidation;

class Validation extends CakeValidation
{

	public static function persianAlpha($check)
	{
		if (empty($check) && $check !== '0') {
			return false;
		}
		$reg = '[ آ-ی]+';
		return self::_check($check, '/^' . $reg . '$/');
	}
}