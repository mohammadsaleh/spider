<?php
namespace Install\Controller;

use Install\Controller\AppController;
use Cake\Controller\Controller;

/**
 * Install Controller
 *
 * @property \install\Model\Table\InstallTable $Install
 */
class InstallController extends AppController
{
    
    public function  initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->viewBuilder()->layout('install');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->set('title_for_layout', __d('spider', 'Installation: Welcome'));
        
    }


    public function database(){
        $currentConfiguration = array(
            'exists' => false,
            'valid' => false,
        );
        if (file_exists(APP . 'Config' . DS . 'database.php')) {
            $currentConfiguration['exists'] = true;
        }
        if ($currentConfiguration['exists']) {
            try {
                $this->loadModel('Install.Install');
                $ds = $this->Install->getDataSource();
                $ds->cacheSources = false;
                $sources = $ds->listSources();
                $currentConfiguration['valid'] = true;
            } catch (Exception $e) {
            }
        }
        
        if(!empty($this->request->data)){
            debug($this->request->data);
            die();
        
        }
        $this->set(compact('currentConfiguration'));
        
        
        $this->set('title_for_layout', __d('spider', 'Installation: Database'));
        
    }
    
    
    
}
