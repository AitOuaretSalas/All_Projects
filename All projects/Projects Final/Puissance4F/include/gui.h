#ifndef GUI_H
#define GUI_H

#include <SDL2/SDL.h>

void update_window(SDL_Renderer *renderer, Game *game);
int start_gui_mode(Game *game);

#endif // GUI_H
