<?php

class Item {
    public $id;
    public $name;
    public $weight;

    public function __construct($id, $name, $weight) {
        $this->id = $id;
        $this->name = $name;
        $this->weight = $weight;
    }
}
