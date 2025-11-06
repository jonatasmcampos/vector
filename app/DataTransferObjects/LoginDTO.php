<?php

namespace App\DataTransferObjects;

class LoginDTO {

    private string $login;
    private string $password;

    public function __construct(
        array $request
    ){
        $this->login = $request['login'];
        $this->password = $request['password'];
    }

    public function getLogin(): string{
        return $this->login;
    }

    public function getPassword(): string{
        return $this->password;
    }

}