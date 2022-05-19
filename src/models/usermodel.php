<?php

namespace models;
use repositories\userrepositorie;

class usermodel {

    public int $id, $fk_role, $fk_status;
    public string $username, $password, $email, $veriftoken, $resettoken, $authtoken, $echeance;

    public function setStatus(string $status):void {
        $repo = new userrepositorie();
        $this->fk_status = $repo->getStatus($status);
    }

    public function getStatus():string {
        $repo = new userrepositorie();
        return $repo->getStatus($this->fk_status);
    }

    public function setRole(string $role):void {
        $repo = new userrepositorie();
        $this->fk_role = $repo->getRole($role);
    }
}