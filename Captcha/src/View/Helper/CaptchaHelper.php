<?php
/**
 * Helper for Showing the use of Captcha*
 * @author     Arvind Kumar
 * @link       http://www.devarticles.in/
 * @copyright  Copyright © 2014 http://www.devarticles.in/
 * @version 3.0 - Tested OK in Cakephp 3.1.1
 */

namespace Captcha\View\Helper;

use Cake\View\Helper;

class CaptchaHelper extends Helper {

/**
 * helpers
 *
 * @var array
 */

    public $helpers = ['Html', 'Form'];
    protected $__isLoadedScript = false;
    protected $_defaultConfig = [];

    public function create($field = 'captcha', $config = []) {
        $html = '';
        $this->config(array_merge($this->getConfig(), (array)$config));
        $qstring = ['type' => $this->getConfig('type'), 'field' =>  $field];

        switch($this->getConfig('type')):
            case 'image':
                $qstring = array_merge($qstring, [
                    'width' =>  $this->_config['width'],
                    'height'=>  $this->_config['height'],
                    'theme' =>  $this->_config['theme'],
                    'length' => $this->_config['length'],
                ]);

                $html .= $this->Html->image(array_merge($this->getConfig('captchaGenerator'), [base64_encode(http_build_query($qstring))]), ['hspace' => 2, 'id' => $field]);
                if($this->getConfig('reload')){
                    $html .= $this->Html->link($this->getConfig('reload_txt'), '#', ['class' => 'creload', 'escape' => false, 'data-target' => '#' . $field]);
                }
                if($this->getConfig('input')){
                    $html .= $this->Form->input($field, $this->getConfig('input'));
                }
            break;
            case 'math':
                $qstring = array_merge($qstring, ['type' => 'math']);
                if($this->getConfig('stringOperation')) {
                    $html .= $this->getConfig('mlabel') .  $this->config('stringOperation') . ' = ?';
                }else{
                    ob_start();
                    $this->_View->requestAction(array_merge($this->getConfig('captchaGenerator'), [base64_encode(http_build_query($qstring))]));
                    $mathstring = ob_get_contents();
                    ob_end_clean();
                }
                $errorclass='';
                if($this->Form->isFieldError($field)){
                    $errorclass = 'error';
                }
                $html .= '<div class = "input text required ' . $errorclass.'">' . $this->Form->label($field, $this->getConfig('mlabel')) . '</div>';
                $html .= '<div><strong>' . $mathstring . '</strong>' . ' = ?</div>';
                $html .= $this->Form->input($field, ['autocomplete' => 'off', 'label' => false, 'class' => '']);
            break;
        endswitch;

        if(!$this->__isLoadedScript){
            if($this->getConfig('timeout')){
                $html .= $this->Html->scriptBlock('var captchaTimeout = ' . $this->getConfig('timeout') * 1000 .';');
            }
            $html .= $this->Html->script('Captcha.script');
            $this->__isLoadedScript = true;
        }
        return $html;
    }

}