<?php
namespace Users\View\Helper;

use Cake\View\Helper;

class UsersHelper extends Helper
{

    public $helpers = ['Html'];

    public function isLogin()
    {
        return $this->request->session()->check('Auth.User') ? $this->request->session()->read('Auth.User') : false;
    }

    public function getFullName()
    {
        $currentUser = $this->request->session()->read('Auth.User');
        if(!empty($currentUser['firstname'])){
            return $currentUser['firstname'] . ' ' . $currentUser['lastname'];
        }
        return 'بدون نام';
    }

    public function showAvatar($sessionAvatarAddress = 'Auth.User.avatar', $defaultAvatar = '/assets/images/default-avatar.jpg', $options = [])
    {
        $session = $this->request->session();
        $avatar = ($session->check($sessionAvatarAddress) && !empty($session->read($sessionAvatarAddress))) ? $session->read($sessionAvatarAddress) : $defaultAvatar;
        return $this->Html->image($avatar, $options);
    }
}
