<?php
namespace PluginManager\Controller\Admin;

use Cake\Core\Exception\Exception;
use PluginManager\Controller\AppController;
use PluginManager\Lib\PluginInstaller;

/**
 * Plugins Controller
 *
 * @property \PluginManager\Model\Table\PluginsTable $Plugins
 */
class PluginsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index($isTheme = null)
    {
        $query = $this->Plugins->find()->order('weight ASC');
        if($isTheme){
            $query->where(['theme IS NOT NULL']);
        }else{
            $query->where(['theme IS NULL']);
        }
        $this->set('plugins', $this->paginate($query));
        $this->set('_serialize', ['plugins']);
    }

    /**
     * View method
     *
     * @param string|null $id Plugin id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $plugin = $this->Plugins->get($id, [
            'contain' => []
        ]);
        $this->set('plugin', $plugin);
        $this->set('_serialize', ['plugin']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $plugin = $this->Plugins->newEntity();
        if ($this->getRequest()->is('post')) {
            $file = $this->getRequest()->getData('file');
            $this->setRequest($this->getRequest()->withoutData('file'));
            $pluginInstaller = new PluginInstaller;
            try{
                $pluginInfo = $pluginInstaller->install($file['tmp_name']);
                $query = $this->Plugins->find();
                $query->select(['max_weight' => $query->func()->max('weight')]);
                $pluginInfo['weight'] = $query->first()->max_weight + 1;
                $plugin = $this->Plugins->patchEntity($plugin, $pluginInfo);
                if ($this->Plugins->save($plugin)) {
                    $this->Flash->success(__d('plugin_manager', 'The plugin has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__d('plugin_manager', 'The plugin could not be saved. Please, try again.'));
                }
            }catch (Exception $e){
                $this->Flash->error($e->getMessage());
                return $this->redirect(array('action' => 'add'));
            }
        }
        $this->set(compact('plugin'));
        $this->set('_serialize', ['plugin']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Plugin id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $plugin = $this->Plugins->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $plugin = $this->Plugins->patchEntity($plugin, $this->getRequest()->getData());
            if ($this->Plugins->save($plugin)) {
                $this->Flash->success(__('The plugin has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The plugin could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('plugin'));
        $this->set('_serialize', ['plugin']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Plugin id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $plugin = $this->Plugins->get($id);
        if ($this->Plugins->delete($plugin)) {
            $this->Flash->success(__('The plugin has been deleted.'));
        } else {
            $this->Flash->error(__('The plugin could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
