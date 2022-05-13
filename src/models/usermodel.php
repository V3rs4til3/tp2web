<?php

namespace models;
use repositories\userrepositorie;

class usermodel {

    public int $id;
    public string $username, $password, $email, $role, $veriftoken, $resettoken, $authtoken, $status, $echeance;

    public function setStatus(string $status):void {
        $repo = new userrepositorie();
        $this->status = $repo->getStatus($status);
    }

    public function setRole(string $role):void {
        $repo = new userrepositorie();
        $this->role = $repo->getRole($role);
    }
}