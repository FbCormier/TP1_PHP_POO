<?php

class CRUD extends PDO {

    /**
     * Ouvre la connexion PDO vers la base ci_project_management.
     */
    public function __construct(){
        parent::__construct('mysql:host=localhost; dbname=ci_project_management; port=3306; charset=utf8', 'admin', '');
    }

    /**
     * Récupère toutes les lignes d'une table, triées par un champ.
     *
     * @param string $table Nom de la table.
     * @param string $field Champ de tri.
     * @param string $order Sens du tri (ASC ou DESC).
     * @return array Liste des lignes.
     */
    public function select(string $table, $field = "id", $order = "ASC"):array{
        $sql = "SELECT * FROM $table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère une seule ligne selon un champ (par défaut id).
     *
     * @param string $table Nom de la table.
     * @param int|string $value Valeur recherchée.
     * @param string $field Champ utilisé pour la recherche.
     * @return bool|array La ligne trouvée, ou false si aucune/plusieurs correspondances.
     */
    public function selectId(string $table, int|string $value, $field = 'id'):bool|array{
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        }
    }

    /**
     * Récupère toutes les lignes correspondant à un champ donné (ex: clé étrangère).
     *
     * @param string $table Nom de la table.
     * @param string $field Champ filtré.
     * @param int|string $value Valeur recherchée.
     * @param string $order Champ de tri.
     * @return array Liste des lignes correspondantes.
     */
    public function selectWhere(string $table, string $field, int|string $value, $order = 'id'):array{
        $sql = "SELECT * FROM $table WHERE $field = :$field ORDER BY $order";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Insère une ligne dans une table à partir d'un tableau associatif [champ => valeur].
     *
     * @param string $table Nom de la table.
     * @param array $data Données à insérer.
     * @return bool|int L'id de la ligne insérée, ou false en cas d'échec.
     */
    public function insert(string $table, array $data):bool|int{
        //   INSERT INTO client (name, address, zip_code, phone, email) VALUES (:name, :address, :zip_code, :phone, :email);
        $fieldName = implode(', ', array_keys($data));
        $fieldBindValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fieldName) VALUES ($fieldBindValue);";
        $stmt = $this->prepare($sql);

        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            return false;
        }
    }

    /**
     * Met à jour une ligne existante à partir d'un tableau associatif [champ => valeur].
     *
     * @param string $table Nom de la table.
     * @param array $data Données à mettre à jour (doit inclure le champ identifiant).
     * @param string $field Champ utilisé dans la clause WHERE.
     * @return bool Succès ou échec de la mise à jour.
     */
    public function update(string $table, array $data, $field = 'id'):bool{
        // "UPDATE client SET name = :name, address = :address WHERE id = :id";
        $fieldName = null;
        foreach($data as $key=>$value){
            $fieldName .= "$key = :$key, ";
        }
        $fieldName = rtrim($fieldName, ', ');
        $sql = "UPDATE $table SET $fieldName WHERE $field = :$field;";
        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Supprime une ligne selon un champ donné (par défaut id).
     *
     * @param string $table Nom de la table.
     * @param int|string $value Valeur identifiant la ligne à supprimer.
     * @param string $field Champ utilisé dans la clause WHERE.
     * @return bool Succès ou échec de la suppression.
     */
    public function delete(string $table, int|string $value, $field = 'id'):bool{
        //DELETE FROM table where id = :id;
        $sql = "DELETE FROM $table WHERE $field = :$field";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}
