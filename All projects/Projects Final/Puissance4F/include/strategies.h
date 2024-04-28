#ifndef STRATEGIES_H
#define STRATEGIES_H
#include "game.h"

int human_console_strategy(Game *game);

int human_gui_strategy(Game *game);

int minmax_strategy(Game *game);

#endif // STRATEGIES_H