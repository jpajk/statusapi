<?php

namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

class AddUserTask extends Shell
{
    public function main()
    {
        $username = $this->in('Specify username:');
        $password = $this->in('Specify password:');

        $registry = TableRegistry::get('Users');
        $user = $registry->newEntity();

        $user->email = $username;
        $user->password = $password;
        $registry->save($user);
        $this->hr();
        $this->out("User saved successfully");
    }
}