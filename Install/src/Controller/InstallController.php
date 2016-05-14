<?php
namespace Install\Controller;

use Cake\Event\Event;


/**
 * Install Controller
 *
 * @property \Install\Model\Table\InstallTable $Install
 */
class InstallController extends AppController
{

    public function beforeFilter(Event $event){
        $this->viewBuilder()->layout('install');
    }
    
    
    
    /**
     * Step 0: welcome
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function index()
    {
//        $this->_check();
        $this->set('title_for_layout', __d('spider', 'Installation: Welcome'));
    }
    
    public function database(){
        debug('d');
        die();
    }
    
    
    
}
