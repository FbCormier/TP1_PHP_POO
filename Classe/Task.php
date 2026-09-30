<?php
require_once __DIR__ . '/Entity.php';

class Task extends Entity {

    /**
     * @param CRUD $db Connexion/CRUD partagée.
     */
    public function __construct(CRUD $db){
        parent::__construct($db, 'task');
    }

    /**
     * Retourne les tâches appartenant à un projet.
     *
     * @param int $projectId Id du projet.
     * @return array Liste des tâches.
     */
    public function getByProject(int $projectId):array{
        return $this->db->selectWhere('task', 'project_id', $projectId, 'planned_start_date');
    }
}
