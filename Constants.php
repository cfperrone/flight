<?php

class Constants {
    // directions
    const DIR_NORTH = 'north';
    const DIR_EAST = 'east';
    const DIR_SOUTH = 'south';
    const DIR_WEST = 'west';
    public static $directions = array(self::DIR_NORTH, self::DIR_SOUTH, self::DIR_EAST, self::DIR_WEST);
    
    // actions
    const ACTION_QUIT = 'quit';
    const ACTION_MOVE = 'move';
    const ACTION_GO = 'go';
    const ACTION_LOOK = 'look';

    // strings
    const PROMPT = "> ";
}
