<?php
/**
 * Captcha Behavior
 *
 * Behavior to handles Captcha verification
 *
 * PHP version 5+ and CakePHP version 2.6+
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the copyright notice.
 *
 * @category    Behavior
 * @version     1.2
 * @author      Arvind Kumar <arvind.mailto@gmail.com>
 * @copyright   Copyright (C) Arvind Kumar
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Version history
 *
 * 2014-09-08  Initial version
 * 2014-12-27  Add configuration settings
 *
 */
namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Validation\Validator;

class CaptchaBehavior extends Behavior
{

		protected $_defaultConfig = [
            'field' => 'captcha',
            'message' => 'Incorrect captcha code value'
		];

		private $captcha = null;

    /**
     * Custom rule to validate captcha value
     *
     * @param $value
     * @param array $context
     * @return bool
     */
    public function validateCaptcha($value, array $context) {
        return $value == $this->captcha[$this->getConfig('field')];
    }

    /**
     * Store captcha value in controller
     *
     * @param $field
     * @param $captcha
     */
    public function setCaptcha($field, $captcha) {
        $this->captcha[$field] = $captcha;
    }

    /**
     * Default validation rules.
     *
     * @param Event $event
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @param $name
     * @return \Cake\Validation\Validator
     */
    public function buildValidator(Event $event, Validator $validator, $name)
    {
        $validator->add($this->getConfig('field'), 'captcha', [
            'rule' => 'validateCaptcha',
            'message' => $this->getConfig('message'),
            'provider' => 'table'
        ]);
        return $validator;
    }
}