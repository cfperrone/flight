<?php

class Room {
    public $id;
    public $name;
    public $description;

    public $directions;
    public $items;

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

    // checks to see if the room has the item given its name
    public function hasItemFromName($item_name) {
        foreach ($this->items as $item) {
            if (strtolower($item->name) == $item_name) {
                return $item;
            }
        }
        return null;
    }
    public function takeItemFromRoom($item_id) {
        if (array_key_exists($item_id, $this->items)) {
            $item = $this->items[$item_id];
            unset($this->items[$item_id]);
            return $item;
        }
        return null;
    }
    public function dropItemInRoom($item) {
        $this->items[$item->id] = $item;
    }
}
