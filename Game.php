<?php

class Game {
    private $rooms;
    private $cur_room;
    private $inventory = array();

    public function __construct() {
        $this->setupDemo();
    }

    // this just sets up a demo game
    public function setupDemo() {
        // create the rooms
        $this->addRoom(0, 'Middle Room', 'You are in the center of the maze. Good luck getting out!',
                       1, 3, 5, 7);
        $this->addRoom(1, 'North Room', 'Brr it\'s cold up here!',
                       null, 2, 0, 8);
        $this->addRoom(2, 'Northeast Room', 'Eyy gimme some cawfee',
                       null, null, 3, 1);
        $this->addRoom(3, 'East Room', 'Maryland is boring',
                       2, null, 4, 0);
        $this->addRoom(4, 'Southeast Room', 'I\'m on a boat motherfucker, don\'t you ever forget.',
                       3, null, null, 5);
        $this->addRoom(5, 'South Room', 'Hey y\'all, how \'bout some cobbler!',
                       0, 4, null, 6);
        $this->addRoom(6, 'Southwest Room', 'Looks like we\'re in Phoenix',
                       7, 5, null, null);
        $this->addRoom(7, 'West Room', 'Yup',
                       8, 0, 6, null);
        $this->addRoom(8, 'Northwest Room', 'Ahh the good ol\' pacific northwest!',
                       null, 1, 7, null);

        // add items to rooms
        $this->addItemToRoom(0, 0, 'Spatula', 3);
        $this->addItemToRoom(4, 1, 'Granola Bar', 8);
        $this->addItemToRoom(5, 2, 'Dutch Oven', 13);

        // ok we're ready
        $this->doAnnounceStartGame();

        // set up starting position
        $this->cur_room = $this->rooms[0];
        $this->doAnnounceRoom($this->cur_room);
        $this->doAnnounceDirection($this->cur_room);
    }

    private function addRoom($id, $name, $desc, $n, $e, $s, $w) {
        $this->rooms[$id] = new Room($id, $name, $desc,
            array(Constants::DIR_NORTH => $n,
                  Constants::DIR_EAST => $e,
                  Constants::DIR_SOUTH => $s,
                  Constants::DIR_WEST => $w));
    }
    // the rooms must be created to call this function
    private function addItemToRoom($room_id, $item_id, $name, $weight) {
        if (!array_key_exists($room_id, $this->rooms)) {
            throw new Exception("Room $room_id does not exist");
        }

        $this->rooms[$room_id]->dropItemInRoom(new Item($item_id, $name, $weight));
    }

    // Game Actions
    public function start() {
        while ($cmd = readline(Constants::PROMPT)) {
            $this->command($cmd);
        }
    }
    private function command($cmd) {
        // throw in an extra line break for good measure
        echo "\n";

        $args = explode(" ", $cmd);
        $action = array_shift($args);

        switch ($action) {
            case Constants::ACTION_QUIT:
                $this->quit(); break;
            case Constants::ACTION_MOVE:
            case Constants::ACTION_GO:
                $this->move($args[0]); break;
            case Constants::ACTION_LOOK:
                $this->look(); break;
            case Constants::ACTION_TAKE:
                $this->take(implode(" ", $args)); break;
            case Constants::ACTION_DROP:
                $this->drop(implode(" ", $args)); break;
            case Constants::ACTION_INVENTORY:
                $this->inventory(); break;
            default:
                echo "I don't know that command!\n";
        }
    }
    private function move($direction) {
        // check that it's a valid direction of travel
        if (!in_array($direction, Constants::$directions)) {
            echo "That direction doesn't make sense to me...\n";
            return;
        }

        // make sure we can move in that direction given the current room
        $next_room_id = $this->cur_room->getRoomIDForDirection($direction);
        if ($next_room_id === null) {
            echo "You can't move that way!\n";
            return;
        }

        // set the new room accordingly
        $next_room = $this->rooms[$next_room_id];
        $this->cur_room = $next_room;

        // announce the new room
        $this->doAnnounceRoom($this->cur_room);
        $this->doAnnounceDirection($this->cur_room);
    }
    private function look() {
        $this->doAnnounceRoom($this->cur_room);
    }
    private function quit() {
        exit();
    }
    private function take($item_name) {
        if ($item_name == 'all') {
            // make sure we wont be overweight
            if ($this->wouldBeOverweight($this->getWeightOfItems($this->cur_room->items))) {
                echo "You can't hold that many items\n";
                return;
            }

            // grab all the items
            foreach ($this->cur_room->items as $item) {
                $this->inventory[$item->id] = $this->cur_room->takeItemFromRoom($item->id);
            }
            echo "Taken!\n";
            return;
        }

        // grab the one item if it exists
        if (($item = $this->cur_room->hasItemFromName($item_name)) !== null) {
            // check to make sure we wont be overweight
            if ($this->wouldBeOverweight($item->weight)) {
                echo "You can't hold that many items\n";
                return;
            }

            $this->cur_room->takeItemFromRoom($item->id);
            $this->inventory[$item->id] = $item;
            echo "Taken!\n";
            return;
        }

        echo "That item isn't in the room.\n";
    }
    private function drop($item_name) {
        foreach ($this->inventory as $item) {
            if (strtolower($item->name) == $item_name) {
                $this->cur_room->dropItemInRoom($item);
                unset($this->inventory[$item->id]);
                echo "Dropped!\n";
                return;
            }
        }
        echo "You don't have that item\n";
    }
    private function inventory() {
        echo "You have: ";
        if (!empty($this->inventory)) {
            echo $this->getInventoryString($this->inventory) . "\n";
        } else {
            echo "nothing\n";
        }
    }

    // Game Announcements
    private function doAnnounceStartGame() {
        echo "Welcome to THE GAME\n" .
             "(c) 2013 cfperrone\n\n";
    }
    private function doAnnounceRoom($room) {
        echo $room->name . "\n";
        echo $room->description . "\n";
        if (!empty($room->items)) {
            echo "The following items are here: ";
            echo $this->getInventoryString($room->items) . "\n";
        }
    }
    private function doAnnounceDirection($room) {
        $dirs = array();
        foreach (Constants::$directions as $dir) {
            if ($room->getRoomIDForDirection($dir) !== null) {
                $dirs[] = ucfirst($dir);
            }
        }
        
        if (empty($dirs)) {
            echo "It looks like there are no exits... You cannot excape!\n";
            return;
        }

        echo "There are exits to the ";
        echo implode(", ", $dirs) . "\n";
    }

    // helpers
    private function getInventoryString($items) {
        $arr = array();
        foreach ($items as $item) {
            if (strtolower(substr($item->name, 0, 1)) == 'a') {
                $arr[] = "an " . strtolower($item->name);
            } else {
                $arr[] = "a " . strtolower($item->name);
            }
        }
        return implode(", ", $arr);
    }
    private function getWeightOfItems($items) {
        $sum = 0;
        foreach ($items as $item) {
            $sum += $item->weight;
        }
        return $sum;
    }
    private function wouldBeOverweight($weight) {
        $inventory_weight = $this->getWeightOfItems($this->inventory);
        if (($inventory_weight + $weight) > Constants::INVENTORY_LIMIT) {
            return true;
        }
        return false;
    }

}
