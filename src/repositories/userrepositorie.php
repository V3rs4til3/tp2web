<?php
namespace repositories;
class userrepositorie {

    function getOneUser(string $username): \models\usermodel|bool {
        $query = BD->prepare('SELECT * FROM users WHERE username = ?');
        $query->bindValue(1, $username, \PDO::PARAM_STR);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS, "\models\usermodel");
        return $query->fetch();
    }

    function newUserInsert(\models\UserModel $user) : void{
        $query = BD->prepare('INSERT INTO users (username, password, email, fk_role, fk_status,
                   veriftoken, resettoken, authtoken, echeance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $query->bindValue(1, $user->username, \PDO::PARAM_STR);
        $query->bindValue(2, $user->password, \PDO::PARAM_STR);
        $query->bindValue(3, $user->email, \PDO::PARAM_STR);
        $query->bindValue(4, $user->role, \PDO::PARAM_INT);
        $query->bindValue(5, $user->status, \PDO::PARAM_INT);
        $query->bindValue(6, "", \PDO::PARAM_STR);
        $query->bindValue(7, "", \PDO::PARAM_STR);
        $query->bindValue(8, "", \PDO::PARAM_STR);
        $query->bindValue(9, "", \PDO::PARAM_STR);
        $query->execute();
    }

    function getStatus(int $status): string {
        $query = BD->prepare('SELECT nomStatus FROM status WHERE id = ?');
        $query->bindValue(1, $status, \PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_COLUMN, 0);
        return $query->fetch();
    }

    function getRole(string $role): int {
        $query = BD->prepare('SELECT id FROM userRole WHERE nomRole = ?');
        $query->bindValue(1, $role, \PDO::PARAM_STR);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_COLUMN, 0);
        return $query->fetch();
    }

    function getUserAuthByToken(string $token): \models\usermodel|bool {
        $query = BD->prepare('SELECT * FROM users WHERE authtoken = ?');
        $query->bindValue(1, $token, \PDO::PARAM_STR);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS, "\models\usermodel");
        return $query->fetch();
    }

    function updateUser(\models\usermodel $user):void{
        $query = BD->prepare('UPDATE users SET username = ?, password = ?, email = ?, veriftoken = ? ,
                 resettoken = ?, authtoken = ?, echeance = ?, fk_status = ? WHERE id = ?');
        $query->bindValue(1, $user->username, \PDO::PARAM_STR);
        $query->bindValue(2, $user->password, \PDO::PARAM_STR);
        $query->bindValue(3, $user->email, \PDO::PARAM_STR);
        $query->bindValue(4, $user->veriftoken, \PDO::PARAM_STR);
        $query->bindValue(5, $user->resettoken, \PDO::PARAM_STR);
        $query->bindValue(6, $user->authtoken, \PDO::PARAM_STR);
        $query->bindValue(7, $user->echeance, \PDO::PARAM_STR);
        $query->bindValue(8, $user->fk_status, \PDO::PARAM_INT);
        $query->bindValue(9, $user->id, \PDO::PARAM_INT);
        $query->execute();
    }

    function populateRole():void{
        $query = BD->query('SELECT * FROM userRole');
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->fetch();
        if($query->rowCount() == 0) {
            BD->query('INSERT INTO userRole (nomRole) VALUES ("admin")');
            BD->query('INSERT INTO userRole (nomRole) VALUES ("user")');
        }
    }

    function populateStatus():void{
        $query = BD->query('SELECT * FROM status');
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->fetch();
        if($query->rowCount() == 0){
            BD->query('INSERT INTO status (nomStatus) VALUES ("actif")');
            BD->query('INSERT INTO status (nomStatus) VALUES ("inactif")');
        }
    }

    function getByEmail(string $email): \models\usermodel|bool {
        $query = BD->prepare('SELECT * FROM users WHERE email = ?');
        $query->bindValue(1, $email, \PDO::PARAM_STR);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS, "\models\usermodel");
        return $query->fetch();
    }

    function createTable(): void{
        BD->query('CREATE TABLE IF NOT EXISTS userRole (
            id int auto_increment ,
            nomRole varchar(255) not null,
            primary key(id)
        )') ;

        BD->query('CREATE TABLE IF NOT EXISTS status (
            id int auto_increment ,
            nomStatus varchar(255) not null,
            primary key(id)
        )') ;

        BD->query('CREATE TABLE IF NOT EXISTS users (
            id int auto_increment,
            username varchar(255) not null,
            password varchar(255) not null,
            email varchar(255) not null,
            veriftoken varchar(255) default "" not null,
            resettoken varchar(255) default "" not null,
            authtoken varchar (255) default "" not null,
            echeance varchar(255) default "" not null,
            fk_role int not null,
            fk_status int not null,
            primary key(id)
        )');
        BD->query('ALTER TABLE users ADD FOREIGN KEY (fk_role) REFERENCES userRole(id)');
        BD->query('ALTER TABLE users ADD FOREIGN KEY (fk_status) REFERENCES status(id)');
    }

    public function dropTable():void{
        BD->query('DROP TABLE users;');
        BD->query('DROP TABLE userRole;');
        BD->query('DROP TABLE status;');
    }

}