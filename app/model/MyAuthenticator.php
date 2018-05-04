<?php

namespace App\Model;

use Nette\Security as NS;

class MyAuthenticator implements NS\IAuthenticator
{
    public $database;

    function __construct(\Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;
        $row = $this->database->table('users')
            ->where('email', $username)->fetch();

        if (!$row) {
            throw new NS\AuthenticationException('User not found. FIXME');
        }

        if (!NS\Passwords::verify($password, $row->password)) {
            throw new NS\AuthenticationException('Invalid password. FIXME');
        }

        return new NS\Identity($row->id, $row->role,
            [
                'email' => $row->email,
                'name' => $row->name,
                'surname' => $row->surname
            ]);
    }
}

