<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ArticleDatas Controller
 *
 * @property \App\Model\Table\ArticleDatasTable $ArticleDatas
 *
 * @method \App\Model\Entity\ArticleData[] paginate($object = null, array $settings = [])
 */
class ArticleDatasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Accounts', 'Users']
        ];
        $articleDatas = $this->paginate($this->ArticleDatas);

        $this->set(compact('articleDatas'));
        $this->set('_serialize', ['articleDatas']);
    }

    /**
     * View method
     *
     * @param string|null $id Article Data id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $articleData = $this->ArticleDatas->get($id, [
            'contain' => ['Accounts', 'Users']
        ]);

        $this->set('articleData', $articleData);
        $this->set('_serialize', ['articleData']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $articleData = $this->ArticleDatas->newEntity();
        if ($this->request->is('post')) {
            $articleData = $this->ArticleDatas->patchEntity($articleData, $this->request->getData());
            if ($this->ArticleDatas->save($articleData)) {
                $this->Flash->success(__('The article data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article data could not be saved. Please, try again.'));
        }
        $accounts = $this->ArticleDatas->Accounts->find('list', ['limit' => 200]);
        $users = $this->ArticleDatas->Users->find('list', ['limit' => 200]);
        $this->set(compact('articleData', 'accounts', 'users'));
        $this->set('_serialize', ['articleData']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article Data id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $articleData = $this->ArticleDatas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articleData = $this->ArticleDatas->patchEntity($articleData, $this->request->getData());
            if ($this->ArticleDatas->save($articleData)) {
                $this->Flash->success(__('The article data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article data could not be saved. Please, try again.'));
        }
        $accounts = $this->ArticleDatas->Accounts->find('list', ['limit' => 200]);
        $users = $this->ArticleDatas->Users->find('list', ['limit' => 200]);
        $this->set(compact('articleData', 'accounts', 'users'));
        $this->set('_serialize', ['articleData']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article Data id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articleData = $this->ArticleDatas->get($id);
        if ($this->ArticleDatas->delete($articleData)) {
            $this->Flash->success(__('The article data has been deleted.'));
        } else {
            $this->Flash->error(__('The article data could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
