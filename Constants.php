<?php

/*
  This is the constants file. It's not in a class because I don't want to type
  out Constants:: each time I want to use one of these. This should be included
  explicitly in the loader before everything else
*/

// directions
const DIR_NORTH = 'north';
const DIR_EAST = 'east';
const DIR_SOUTH = 'south';
const DIR_WEST = 'west';

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
const ANN_ERROR_WRONG_DIR = "That direction doesn't make sense to me...";
const ANN_ERROR_DIR_BLOCKED = "You can't move that way!";
const ANN_ERROR_NO_ESCAPE = "It looks like therea re no exits... You cannot escape!";
const ANN_ERROR_TAKE_WRONG_ITEM = "That item isn't in the room";
const ANN_ERROR_DROP_WRONG_ITEM = "You don't have that item";
const ANN_ERROR_OVERWEIGHT = "You can't hold that many items";
const ANN_ERROR_UNKNOWN_ACTION = "I don't know that command!";
const ANN_START_GAME = "Welcome to THE GAME\n(c) 2013 cperrone";
const ANN_ROOM_INVENTORY_PREFACE = "The following items are here: ";
const ANN_ROOM_EXIT_PREFACE = "There are exits to the ";
const ANN_INVENTORY_PREFACE = "You have: ";
const ANN_INVENTORY_EMPTY = "You're not carrying anything";
const ANN_DROP_SUCCESS = "Dropped!";
const ANN_TAKE_SUCCESS = "Taken!";

// other constants
const INVENTORY_LIMIT = 15;

class Constants {
    public static $directions = array(DIR_NORTH, DIR_SOUTH, DIR_EAST, DIR_WEST);
}
