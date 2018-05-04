<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $lastname
 * @property string $phone
 * @property string $address
 * @property bool $active
 * @property string $token
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'name' => true,
        'lastname' => true,
        'phone' => true,
        'address' => true,
        'active' => true,
        'token' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * @param string $password
     * @return string
     */
    public function _setPassword(string $password): string
    {
        if ($password) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return '';
    }

    /**
     * @return bool|\Cake\Datasource\EntityInterface|false|mixed
     */
    public function regenerateToken()
    {
        $users_table = TableRegistry::getTableLocator()->get('Users');

        $this->token = bin2hex(openssl_random_pseudo_bytes(50));

        return $users_table->save($this);
    }
}
