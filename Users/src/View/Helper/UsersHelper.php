<?php
namespace Users\View\Helper;

use Cake\View\Helper;

class UsersHelper extends Helper
{
    
    public function getFullName()
    {
        $currentUser = $this->request->session()->read('Auth.User');
        if(!empty($currentUser['firstname'])){
            return $currentUser['firstname'] . ' ' . $currentUser['lastname'];
        }
        return 'بدون نام';
    }
}
