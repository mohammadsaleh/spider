<?php

namespace Users\Controller;

use App\Controller\AppController as BaseController;
use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

class AppController extends BaseController
{

    public function implementedEvents(){
        return parent::implementedEvents();
    }

    /**
     * Log user out
     * @return \Cake\Network\Response|void
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Send an activation link to user email
     * @param $user
     */
    public function _sendActivationEmail(Entity $user, $url = '/register/active/'){
        $ActivationKeys = TableRegistry::get('Users.ActivationKeys');
        $activationKeyEntity = $ActivationKeys->newEntity();
        $activationKeyEntity->user_id = $user->id;
        do{
            $activationKeyEntity->activation_key = Text::uuid();
        }while(!$ActivationKeys->save($activationKeyEntity));

        //send email with activation key
        $activationUrl = Router::url($url . $activationKeyEntity->activation_key, true);
        $email = new Email('default');
//        $email->transport();
        $email->emailFormat('html');
        $email->viewVars(compact('activationUrl'));
        $email->helpers(['Html']);
        $email->to($user->username);
        return $email;
    }
}
