<?php
require_once __DIR__ . '/Entity.php';

class Contact extends Entity {

    /**
     * @param CRUD $db Connexion/CRUD partagée.
     */
    public function __construct(CRUD $db){
        parent::__construct($db, 'contact');
    }

    /**
     * Concatène le prénom et le nom d'un contact.
     *
     * @param array $contact Ligne de contact (avec first_name/last_name).
     * @return string Nom complet.
     */
    public function fullName(array $contact):string{
        return $contact['first_name'] . ' ' . $contact['last_name'];
    }
}
