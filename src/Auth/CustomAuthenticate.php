<?php

namespace App\Auth;

use Cake\Auth\BasicAuthenticate;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;

class CustomAuthenticate extends BasicAuthenticate
{

    /**
     * Authenticate a user based on the request information.
     *
     * @param \Cake\Http\ServerRequest $request Request to get authentication information from.
     * @param \Cake\Http\Response $response A response object that can have headers added.
     * @return mixed Either false on failure, or an array of user data on success.
     */
    public function authenticate(ServerRequest $request, Response $response)
    {
        $authorization_header = $request->getHeaderLine('Authorization');

        if (!$authorization_header) {
            return false;
        }

        /** @var \App\Model\Entity\User|null $user */
        $user = $this->findByToken($authorization_header);

        if (!$user) {
            return false;
        }

        return $user->toArray();
    }

    /**
     * @param string $header
     * @return mixed \App\Model\Entity\User|null
     */
    public function findByToken(string $header)
    {
        $token = trim(str_replace('Bearer', '', $header));

        return TableRegistry::getTableLocator()->get('Users')->findByToken($token)->first();
    }
}