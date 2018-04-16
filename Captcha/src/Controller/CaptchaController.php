<?php
namespace Captcha\Controller;

use Captcha\Controller\AppController;

/**
 * Captcha Controller
 *
 */
class CaptchaController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
    }

    public function create()  {
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('ajax');
        $this->Captcha->create();
    }
}
