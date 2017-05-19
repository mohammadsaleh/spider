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
    public function integer($value)
    {
        return parent::isInteger($value);
    }

	public static function persianAlpha($check)
	{
		$reg = '/^[\s\x{600}-\x{6FF}]+$/u';
		return self::_check($check, $reg);
	}

	public static function nationalCode($check)
	{
		if((strlen($check) != 10)){
			return false;
		}else{
			$codeArray = str_split($check);
			$AllEq = null;
			foreach($codeArray as $item => $value){
				if($codeArray[0] != $value){
					$AllEq = false;
					break;
				}else{
					$AllEq = true;
				}
			}
			if($AllEq == true){
				return false;
			};
			$weight = 10;
			$sum = 0;
			for($i = 0; $i <= 8; $i++){
				$sum +=((int)($codeArray[$i])) * $weight;
				--$weight;
			}
			$divid = $sum % 11;
			if ($divid <= 2) {
				if($codeArray[9]  == $divid) {
					return true;
				}
				return false;
			}else{
				$divid1 = 11 - $divid;
				if ($codeArray[9]  == $divid1){
					return true;
				}
				return false;
			}
		}
	}

	public static function mobile($check)
	{
		$reg = '/^09(1[0-9]|3[1-9]|2[1-9])?[0-9]{7}$/' ;
		return self::_check($check, $reg);
	}
}