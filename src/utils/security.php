<?php

namespace utils;

class security {

    public static function sessionStart(){
        session_name('StockM');
        session_start();
    }

    public static function timeout(){
        $time = $_SESSION['timeout'] ?? 0;
        if($time < time()){
            session_regenerate_id();
            $_SESSION['timeout'] = time() + (5 * 60);
        }
    }

    /*
     * todo
     * Chaque action de chaque contrôleur valide l'accès à la ressource
     * Protection contre le CSRF pour toute action modifiant la BD ou la session
     * Protection contre le XSS (temporaire, permanent et auto), il doit y avoir les 2 protections pour les XSS temporaire et permanent
     * Validation des données en frontend ET backend
     * Brouiller le JavaScript sur le FTP
     * Aucun fichier PHP ou de configuration accessible par l'utilisateur à part le routeur
     * Sécuriser le téléversement d'image:
     *
     * Authentification:
     * Confirmation de l'ancien mot de passe lorsqu'un utilisateur connecté change son mot de passe
     * Ne pas permettre le recensement des utilisateurs
     * Protection contre le SSRF
     * Journaliser les informations concernant les achats
     * Protection contre le détournement de clic

     * todo if needed:
     * Utiliser la liste d'acceptation si nécessaire, pas la liste de rejet
     * Protection contre la traverse de fichier
     * Protection contre l'injection de commande
     * Protection contre le DOM XSS
     * Protection contre la redirection ouverte
     *
     *
     *
     * todo FAIT
     * Champ mot de passe de type "password" par défaut
     * Forcer le HTTPS
     * Protection contre l'injection SQL
     * Afficher des erreurs génériques, pas de message d'Apache ou PHP
     * Cacher la version de PHP dans les entêtes de requêtes
     * Utiliser des beaux URLs
     * Sécuriser le cookie de session
     * L'utilisateur doit valider son adresse courriel pour se connecter ou accéder aux ressources sécurisés
     * Permettre un oublie de mot de passe par courriel
     * Complexité minimal du mot de passe
     * Mot de passe hashé et salé
     * Modifier l'ID de session à la connexion et "une fois de temps en temps"
     * Permettre de "Se souvenir de moi"
     * Déconnexion sécuritaire
     */

}