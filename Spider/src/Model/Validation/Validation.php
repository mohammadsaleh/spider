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

	public static function saleh($check)
	{
		if (empty($check) && $check !== '0') {
			return false;
		}
		return self::_check($check, '/^[saleh]$/');
	}
}