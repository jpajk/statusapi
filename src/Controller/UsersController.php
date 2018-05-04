<?php

namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 * @property  \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow('loginOrRegister');
    }

    public function isAuthenticated()
    {
    }

    public function loginOrRegister()
    {
        $email = (string) $this->getRequest()->getData('email');
        $password = (string) $this->getRequest()->getData('password');

        /** @var \App\Model\Entity\User $user */
        $user = $this->Users->findByEmailOrCreate($email, $password);

        if (!$user || !(new DefaultPasswordHasher())->check($password, $user->password)) {
            $user = null;
        }

        $this->set('current_user', $user);
        $this->set('_serialize', ['user']);
    }
}
