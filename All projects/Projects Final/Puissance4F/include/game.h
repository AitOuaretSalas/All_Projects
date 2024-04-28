#ifndef GAME_H
#define GAME_H

#include <stdbool.h>
#include <unistd.h>
#include <stdio.h>
#include <string.h>

#include <SDL2/SDL.h>
#include "types.h"

void init_tiles(Game *game);
bool play_turn(Game *game, int col_index);
GameState check_game_state(Game *game);

#endif // GAME_H