<?php

namespace controllers;

use models\usermodel;
use repositories\userrepositorie;
use utils\log;
class usercontroller
{
    function resetPassword(){
        if(isset($_POST['password']) && isset($_POST['verifications'])) {
            $user = $_SESSION['toReset'];
            if($_POST['password'] == $_POST['verifications']) {
                if(strlen($_POST['password']) >= 7 && strlen($_POST['password']) < 255) {
                    $user->password = $_POST['password'];
                    $userRepository = new userrepositorie();
                    $userRepository->updateUser($user);
                    unset($_SESSION['toReset']);
                    $_SESSION['success'] = "Mot de passe réinitialisé avec succès";
                    header('location: ' . HOME_PATH .  '/user/ViewConnect');
                    die();
                }
                else{
                    $_SESSION['error'] = "Le mot de passe doit contenir au moins 7 caractères";
                }
            }
            $_POST['error'] = "Les mots de passe ne correspondent pas";
        }
    }

    function Forgotten(string $email):void{
        $userRepo = new userrepositorie();
        $user = $userRepo->getByEmail($email);
        if($user){
            $user->resettoken= md5(uniqid(rand(), true));
            $user->echeance = time() + 3600;
            $userRepo->updateUser($user);
            $this->sendEmailReset($user);
            $_POST['success'] = "Un email de réinitialisation vous à été envoyé";
        }
    }

    function sendEmailReset(usermodel $user): void{
        $to = $user->email;
        $subject = 'Modification mot de passe';
        $message = '        
        ------------------------
        Bonjour  '.$user->username.'
        ------------------------
          
        Veuiller cliquer sur le lien pour modifier votre mot de passe:
        http://420n46.jolinfo.cegep-lanaudiere.qc.ca/1751707/user/verify?email='.$user->email.'&token='.$user->resettoken.'
         
        Si vous n\'avez pas demandé de modification de mot de passe, veuillez ignorer ce message.
        ';
        $headers = 'From:noreply@stockm.com' . "\r\n";
        mail($to, $subject, $message, $headers);
        //log::write('Email de confirmation envoyé à '.$email, 'email'); todo: create file
    }

    function verify(): void {
        $email = $_GET['email'];
        $token = $_GET['token'];
        $userRepo = new userrepositorie();
        $user = $userRepo->getByEmail($email);
        if ($user && strcmp($user->veriftoken, $token) == 0) {
            $user->veriftoken = "";
            if($user->echeance > time()){
                $user->echeance = '';
                $user->setStatus('actif');
                $userRepo->updateUser($user);
                $_SESSION['success'] = 'Votre compte à bien été activé, vous pouvez vous connecter.';
                header('location: ' . HOME_PATH .  '/user/ViewConnect');
                die();
            }
        }
        else if($user && strcmp($user->resettoken, $token) == 0){
            $user->resettoken = "";
            if($user->echeance > time()){
                $user->echeance = '';
                $_SESSION['toReset'] = $user;
                header('Location: ' . HOME_PATH . '/user/ViewReset');
                die();
            }
        }
        header('location: ' . HOME_PATH .  '/user/ViewConnect');
    }

    function sendEmailConfirm(usermodel $user): void{
        $to = $user->email;
        $subject = 'Creation | Verification';
        $message = '
  
        Merci de vous etres enregistré!
        Votre compte a bien ete créée, vous pouvez vous connecter en cliquant sur le lien au bas de se courriel.
          
        ------------------------
        Username: '.$user->username.'
        ------------------------
          
        Veuiller cliquer sur le lien pour confirmer votre compte:
        http://420n46.jolinfo.cegep-lanaudiere.qc.ca/1751707/user/verify?email='.$user->email.'&token='.$user->veriftoken.'
          
        ';
        $headers = 'From:noreply@stockm.com' . "\r\n";
        mail($to, $subject, $message, $headers);
        //log::write('Email de confirmation envoyé à '.$email, 'email'); todo: create file
    }

    function createToken(usermodel $user){
        $userRepo = new userrepositorie();
        $user->veriftoken= md5(uniqid(rand(), true));
        $user->echeance = time() + 3600;
        $userRepo->updateUser($user);
        $this->sendEmailConfirm($user);
    }

    function Connect(){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userRepo = new userrepositorie();
        $user = $userRepo->getOneUser( $username);

        if($username != '' && ctype_alnum($username)){
            if ($user) {

                if (password_verify($password, $user->password)) {
                    if ($user->status == 'actif') {
                        $_SESSION['user'] = $user;
                        header('location: ' . HOME_PATH .  '/user/userhome');
                        die();
                    }
                    else
                        $_POST['error'] = 'Votre compte n\'est pas activé';
                }
                else
                    $_POST['error'] = 'Mot de passe incorrect';
            }
            else
                $_POST['error'] = 'Indentifiant incorrect';
        }
        else
            $_POST['error'] = 'Username incorrect';
    }

    function Create(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $verifications = $_POST['verifications'];
        $mail = $_POST['email'];

        $newUser = new usermodel();
        $userRepo = new userrepositorie();

        if(!$userRepo->getOneUser($username) && $username != '' &&
            strlen($username) >= 1 && strlen($username) < 255 && ctype_alnum($username)){
            if(!$userRepo->getByEmail($mail) && $mail != '' && strlen($mail) >= 1 && strlen($mail) < 255 &&
                filter_var($mail, FILTER_VALIDATE_EMAIL)){
                if($password != '' && strlen($password) >= 7 && strlen($password) < 255){
                    if($password == $verifications){
                        $newUser->username = $username;
                        $newUser->password = password_hash($password, PASSWORD_DEFAULT);
                        $newUser->email = $mail;
                        $newUser->setRole('user');
                        $newUser->setStatus('inactif');
                        $userRepo->newUserInsert( $newUser);
                        $this->createToken($newUser);
                        $_POST['success'] = 'Votre compte à bien été créé, un email de confirmation à été envoyé';
                    }
                    else
                        $_POST['error'] = 'Les mots de passe ne correspondent pas';
                }
                else
                    $_POST['error'] = 'Mot de passe incorrect';
            }
            else
                $_POST['error'] = 'Email incorrect';
        }
        else
            $_POST['error'] = 'Ce username est invalide';
    }

    function Disconnect():void{
        session_unset();
        session_destroy();
        header('location: ' . HOME_PATH .'/home/index');
        die();
    }

    function ViewConnect():void{
        if(isset($_SESSION['user'])){
            header('location: ' . HOME_PATH .'/user/userhome');
            die();
        }
        else if(isset($_POST['username'])){
            $this->Connect();
        }

        require __DIR__ . '../../views/users/connect.php';
    }

    function ViewCreate():void{
        if(isset($_SESSION['user'])){
            header('location: ' . HOME_PATH .'/user/userhome');
            die();
        }
        else if(isset($_POST['username'])){
            $this->Create();
        }

        require __DIR__ . '../../views/users/create.php';
    }

    function ViewForgotten():void{
        if(isset($_SESSION['user'])){
            header('location: ' . HOME_PATH .'/user/userhome');
            die();
        }
        else if(isset($_POST['email'])){
            if($_POST['email'] != '' && strlen($_POST['email']) >= 1 && strlen($_POST['email']) < 255 &&
                filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $this->Forgotten($_POST['email']);
            else
                $_POST['error'] = 'Email invalide';
        }
        require __DIR__ . '../../views/users/forgotten.php';
    }

    function ViewReset():void{ //TODO fix the reset
        if(isset($_POST['password'])){
            $this->resetPassword();
            require __DIR__ . '../../views/users/reset.php';
            die();
        }
        else if(isset($_SESSION['toReset'] )) {
            require __DIR__ . '../../views/users/reset.php';
            die();
        }
        else if(isset($_SESSION['user'])){
            header('location: ' . HOME_PATH .'/user/userhome');
            die();
        }

        header('location: ' . HOME_PATH .'/home/index');
    }


}