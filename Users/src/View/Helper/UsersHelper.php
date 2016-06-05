<?php
namespace Users\View\Helper;

use Cake\View\Helper;

class UsersHelper extends Helper
{

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
}
