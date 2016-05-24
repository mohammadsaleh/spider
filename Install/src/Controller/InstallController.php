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

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {        
    }

    /**
     * View method
     *
     * @param string|null $id Install id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $install = $this->Install->get($id, [
            'contain' => []
        ]);

        $this->set('install', $install);
        $this->set('_serialize', ['install']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $install = $this->Install->newEntity();
        if ($this->request->is('post')) {
            $install = $this->Install->patchEntity($install, $this->request->data);
            if ($this->Install->save($install)) {
                $this->Flash->success(__('The install has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The install could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('install'));
        $this->set('_serialize', ['install']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Install id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $install = $this->Install->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $install = $this->Install->patchEntity($install, $this->request->data);
            if ($this->Install->save($install)) {
                $this->Flash->success(__('The install has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The install could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('install'));
        $this->set('_serialize', ['install']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Install id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $install = $this->Install->get($id);
        if ($this->Install->delete($install)) {
            $this->Flash->success(__('The install has been deleted.'));
        } else {
            $this->Flash->error(__('The install could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
