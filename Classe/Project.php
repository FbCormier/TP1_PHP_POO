<?php
require_once __DIR__ . '/Entity.php';

class Project extends Entity {

    /**
     * @param CRUD $db Connexion/CRUD partagée.
     */
    public function __construct(CRUD $db){
        parent::__construct($db, 'project');
    }

    /**
     * Lie un projet à une liste de services (relation plusieurs-à-plusieurs).
     *
     * @param int $projectId Id du projet.
     * @param array $serviceIds Ids des services à associer.
     */
    public function attachServices(int $projectId, array $serviceIds):void{
        foreach($serviceIds as $serviceId){
            $this->db->insert('project_service', [
                'project_id' => $projectId,
                'service_id' => (int) $serviceId,
            ]);
        }
    }

    /**
     * Retire tous les services associés à un projet (avant une resynchronisation).
     *
     * @param int $projectId Id du projet.
     */
    public function detachServices(int $projectId):void{
        $this->db->delete('project_service', $projectId, 'project_id');
    }

    /**
     * Retourne les services associés à un projet.
     *
     * @param int $projectId Id du projet.
     * @return array Liste des services.
     */
    public function getServices(int $projectId):array{
        $sql = "SELECT service.* FROM service
                INNER JOIN project_service ON project_service.service_id = service.id
                WHERE project_service.project_id = :project_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':project_id', $projectId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
