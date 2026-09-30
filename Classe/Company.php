<?php
require_once __DIR__ . '/Entity.php';

class Company extends Entity {

    /**
     * @param CRUD $db Connexion/CRUD partagée.
     */
    public function __construct(CRUD $db){
        parent::__construct($db, 'company');
    }

    /**
     * Retourne les emplacements appartenant à une entreprise.
     *
     * @param int $companyId Id de l'entreprise.
     * @return array Liste des emplacements.
     */
    public function getLocations(int $companyId):array{
        return $this->db->selectWhere('company_locations', 'company_id', $companyId, 'name');
    }

    /**
     * Retourne les contacts appartenant à une entreprise.
     *
     * @param int $companyId Id de l'entreprise.
     * @return array Liste des contacts.
     */
    public function getContacts(int $companyId):array{
        return $this->db->selectWhere('contact', 'company_id', $companyId, 'first_name');
    }

    /**
     * Retourne les projets appartenant à une entreprise.
     *
     * @param int $companyId Id de l'entreprise.
     * @return array Liste des projets.
     */
    public function getProjects(int $companyId):array{
        return $this->db->selectWhere('project', 'company_id', $companyId, 'id');
    }
}
