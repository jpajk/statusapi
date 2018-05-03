<?php

namespace App\Controller;

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function isAuthenticated()
    {
        $this->set('isAuthenticated', false);
    }

    public function loginOrRegister()
    {

    }
}
