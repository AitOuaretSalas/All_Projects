#ifndef UTILS_H
#define UTILS_H

#include "SDL2/SDL.h"
#include <stdbool.h>

// comparer deux SDL_Color
bool colorsEqual(const SDL_Color a, const SDL_Color b);

int min(int a, int b);
int max(int a, int b);

#endif // UTILS_H