<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Custom' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'userModel' => 'Users'
                ],
            ],
            'storage' => 'Memory',
            'unauthorizedRedirect' => false
        ]);

        $user = $this->Auth->identify();

        if ($user) {
            $this->Auth->setUser($user);
        }

        $this->set('current_user', $user);
    }

    public function beforeFilter(Event $event)
    {
        $this->set([
            'data' => [],
            'message'    => '',
            'statusCode' => $this->getResponse()->getStatusCode()
        ]);

        $input_data = (array) $this->getRequest()->input('json_decode');

        if ($input_data) {
            foreach ($input_data as $index => $input_datum) {
                $this->setRequest(
                    $this->getRequest()->withData($index, $input_datum)
                );
            }
        }
    }

    public function beforeRender(Event $event)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $this
            ->getResponse()
            ->withType('application/json');

        $this->set('_serialize', true);
    }
}
