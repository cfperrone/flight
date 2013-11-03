<?php

class Game {
    private $rooms;
    private $cur_room;

    public function __construct() {
        $this->setupDemo();
    }

    // this just sets up a demo game
    public function setupDemo() {
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

    // Game Announcements
    private function doAnnounceStartGame() {
        echo "Welcome to THE GAME\n" .
             "(c) 2013 cfperrone\n\n";
    }
    private function doAnnounceRoom($room) {
        echo $room->name . "\n";
        echo $room->description . "\n";
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
}
