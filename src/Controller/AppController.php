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

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event)
    {
        $this->set([
            'message'    => '',
            'statusCode' => $this->getResponse()->getStatusCode()
        ]);
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
