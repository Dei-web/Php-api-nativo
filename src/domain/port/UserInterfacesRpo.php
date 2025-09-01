<?php

require_once __DIR__ . '/../../enrute.php';
require_once SRC_PATH.  'domain/Users.php';


interface InterfaceRepo
{
    public function RegisterUser(User $us): User;
}
