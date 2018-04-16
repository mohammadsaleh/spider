<?php
namespace Users\View\Helper;

use Cake\View\Helper;

class UsersHelper extends Helper
{

    public $helpers = ['Html'];

    public function isLogin()
    {
        return $this->request->getSession()->check('Auth.User') ? $this->request->getSession()->read('Auth.User') : false;
    }

    public function getFullName()
    {
        $currentUser = $this->request->getSession()->read('Auth.User');
        if(!empty($currentUser['firstname'])){
            return $currentUser['firstname'] . ' ' . $currentUser['lastname'];
        }
        return 'بدون نام';
    }

    public function showAvatar($sessionAvatarAddress = 'Auth.User.avatar', $defaultAvatar = '/assets/images/default-avatar.jpg', $options = [])
    {
        $session = $this->request->getSession();
        $avatar = ($session->check($sessionAvatarAddress) && !empty($session->read($sessionAvatarAddress))) ? $session->read($sessionAvatarAddress) : $defaultAvatar;
        return $this->Html->image($avatar, $options);
    }
}
