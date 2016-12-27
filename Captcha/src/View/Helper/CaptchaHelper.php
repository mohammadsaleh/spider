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
        $this->config(array_merge($this->config(), (array)$config));
        $qstring = ['type' => $this->config('type'), 'field' =>  $field];

        switch($this->config('type')):
            case 'image':
                $qstring = array_merge($qstring, [
                    'width' =>  $this->_config['width'],
                    'height'=>  $this->_config['height'],
                    'theme' =>  $this->_config['theme'],
                    'length' => $this->_config['length'],
                ]);

                $html .= $this->Html->image(array_merge($this->config('captchaGenerator'), [base64_encode(http_build_query($qstring))]), ['hspace' => 2, 'id' => $field]);
                if($this->config('reload')){
                    $html .= $this->Html->link($this->config('reload_txt'), '#', ['class' => 'creload', 'escape' => false, 'data-target' => '#' . $field]);
                }
                if($this->config('input')){
                    $html .= $this->Form->input($field, $this->config('input'));
                }
            break;
            case 'math':
                $qstring = array_merge($qstring, ['type' => 'math']);
                if($this->config('stringOperation')) {
                    $html .= $this->config('mlabel') .  $this->config('stringOperation') . ' = ?';
                }else{
                    ob_start();
                    $this->_View->requestAction(array_merge($this->config('captchaGenerator'), [base64_encode(http_build_query($qstring))]));
                    $mathstring = ob_get_contents();
                    ob_end_clean();
                }
                $errorclass='';
                if($this->Form->isFieldError($field)){
                    $errorclass = 'error';
                }
                $html .= '<div class = "input text required ' . $errorclass.'">' . $this->Form->label($field, $this->config('mlabel')) . '</div>';
                $html .= '<div><strong>' . $mathstring . '</strong>' . ' = ?</div>';
                $html .= $this->Form->input($field, ['autocomplete' => 'off', 'label' => false, 'class' => '']);
            break;
        endswitch;

        if(!$this->__isLoadedScript){
            $html .= $this->Html->script('Captcha.script');
            $this->__isLoadedScript = true;
        }
        return $html;
    }

}