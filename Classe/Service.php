<?php
require_once __DIR__ . '/Entity.php';

class Service extends Entity
{

    /**
     * @param CRUD $db Connexion/CRUD partagée.
     */
    public function __construct(CRUD $db)
    {
        parent::__construct($db, 'service');
    }
}
