<?php

class Room {
    public $id;
    public $name;
    public $description;

    public $directions;

    public function __construct($id, $name, $description, $directions=array()) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        
        foreach (array_keys($directions) as $dir) {
            if (!in_array($dir, Constants::$directions)) {
                throw new Exception("Incorrect direction '$dir' found in configuration");
            }
        }
        $this->directions = $directions;
    }

    public function getRoomIDForDirection($direction) {
        if (!array_key_exists($direction, $this->directions)) {
            return null;
        }
        return $this->directions[$direction];
    }
}
