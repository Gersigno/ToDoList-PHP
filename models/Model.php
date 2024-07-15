<?php

/**
 * Our default Model (Entity)
 * Every other entities will be extended from this one.
 */

class Model extends Database {
    protected ?string $table = null; // Target table's name
    
    private ?Database $db = null; // Database's instance

    /**
     * Run an SQL query
     */
    public function runQuery(string $sql, array $attributs = null)
    {
        $this->db = Database::getInstance(); //Obtain the instance of our Database

        if ($attributs != null) {
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            return $this->db->query($sql);
        }
    }

    /**
     * Read the whole table content.
     * @return Array Table's content
     */
    public function findAll()
    {
        $query = $this->runQuery('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    /**
     * Return an array of rows than match our properties
     * @param Array Properties to find. Exemple : ["username" => "HundredChip"]
     * @return Array Table's content
     */
    public function findBy(array $properties)
    {
        $fields = [];
        $values = [];
        foreach ($properties as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }
        $fieldsList = implode(' AND ', $fields);
        return $this->runQuery('SELECT * FROM ' . $this->table . ' WHERE ' . $fieldsList, $values)->fetchAll();
    }

    /**
     * Return the content of the row at the intended id.
     * @return Int ID
     */
    public function findById(int $id){
        return $this->runQuery("SELECT * FROM $this->table WHERE id = $id")->fetch(); 
    }
}