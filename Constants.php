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
    const ACTION_TAKE = 'take';
    const ACTION_DROP = 'drop';
    const ACTION_INVENTORY = 'inventory';

    // strings
    const PROMPT = "> ";

    // other constants
    const INVENTORY_LIMIT = 15;
}
