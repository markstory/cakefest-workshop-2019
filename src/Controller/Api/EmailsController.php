<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
/**
 * Emails Controller
 *
 * @property \App\Model\Table\EmailsTable $Emails
 * @method \App\Model\Entity\Email[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Tickets');
    }

    /**
     * Index method
     *
     * @param string|null $ticketId Ticket id.
     * @return \Cake\Http\Response|null
     */
    public function index($ticketId)
    {
        $this->paginate = [
            'finder' => ['forTicket' => ['ticketId' => $ticketId]],
        ];
        $emails = $this->paginate($this->Emails);

        $this->set(compact('emails'));
        $this->viewBuilder()->setOption('serialize', ['emails']);
    }

    /**
     * View method
     *
     * @param string|null $ticketId Ticket id.
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($ticketId, $id)
    {
        $email = $this->Emails->find('forTicket', ['ticketId' => $ticketId])
            ->where(['Emails.id' => $id])
            ->firstOrFail();

        $this->set('email', $email);
        $this->viewBuilder()->setOption('serialize', ['email']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $email = $this->Emails->newEmptyEntity();
        if ($this->request->is('post')) {
            $email = $this->Emails->patchEntity($email, $this->request->getData());
            if ($this->Emails->save($email)) {
                $this->Flash->success(__('The email has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email could not be saved. Please, try again.'));
        }
        $tickets = $this->Emails->Tickets->find('list', ['limit' => 200]);
        $this->set(compact('email', 'tickets'));
    }

    /**
     * Edit method
     *
     * @param string|null $ticketId Ticket id.
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($ticketId, $id)
    {
        $email = $this->Emails->find('forTicket', ['ticketId' => $ticketId])
            ->where(['Emails.id' => $id])
            ->firstOrFail();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $email = $this->Emails->patchEntity($email, $this->request->getData());
            if ($this->Emails->save($email)) {
                $this->Flash->success(__('The email has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email could not be saved. Please, try again.'));
        }
        $this->set(compact('email'));
        $this->viewBuilder()->setOption('serialize', ['email']);
    }

    /**
     * Delete method
     *
     * @param string|null $ticketId Ticket id.
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($ticketId, $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $email = $this->Emails->find('forTicket', ['ticketId' => $ticketId])
            ->where(['Emails.id' => $id])
            ->firstOrFail();
        if ($this->Emails->delete($email)) {
            $this->Flash->success(__('The email has been deleted.'));
        } else {
            $this->Flash->error(__('The email could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
