<?php
require_once __DIR__ . '/CRUD.php';

// Classe de base : regroupe le comportement commun à toutes les entités
// (connexion BD, nom de table, opérations CRUD génériques).
abstract class Entity {

    protected CRUD $db;
    protected string $table;

    /**
     * @param CRUD $db Connexion/CRUD partagée.
     * @param string $table Nom de la table associée à l'entité.
     */
    public function __construct(CRUD $db, string $table){
        $this->db = $db;
        $this->table = $table;
    }

    /**
     * Retourne toutes les lignes de la table, triées par un champ.
     *
     * @param string $field Champ de tri.
     * @param string $order Sens du tri (ASC ou DESC).
     * @return array Liste des lignes.
     */
    public function all(string $field = 'id', string $order = 'ASC'):array{
        return $this->db->select($this->table, $field, $order);
    }

    /**
     * Retourne une ligne selon son id.
     *
     * @param int $id Identifiant recherché.
     * @return bool|array La ligne trouvée, ou false si introuvable.
     */
    public function find(int $id):bool|array{
        return $this->db->selectId($this->table, $id);
    }

    /**
     * Insère une nouvelle ligne.
     *
     * @param array $data Données à insérer.
     * @return bool|int L'id de la ligne insérée, ou false en cas d'échec.
     */
    public function create(array $data):bool|int{
        return $this->db->insert($this->table, $data);
    }

    /**
     * Met à jour une ligne existante.
     *
     * @param array $data Données à mettre à jour (doit inclure l'id).
     * @return bool Succès ou échec de la mise à jour.
     */
    public function update(array $data):bool{
        return $this->db->update($this->table, $data);
    }

    /**
     * Supprime une ligne selon son id.
     *
     * @param int $id Identifiant de la ligne à supprimer.
     * @return bool Succès ou échec de la suppression.
     */
    public function remove(int $id):bool{
        return $this->db->delete($this->table, $id);
    }
}
