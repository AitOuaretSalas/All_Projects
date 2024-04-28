#ifndef CONFIG_H
#define CONFIG_H

#include <stdbool.h>
#include <SDL2/SDL_image.h>
#include <SDL2/SDL_ttf.h>

#define PLAYERS_NUM 2
#define ROW_NUM 7
#define COL_NUM 6
#define WINNING_CONNECTED_NUM 4

// GUI CONFIG
#define APP_NAME "Puissance 4"
#define TILE_SIZE 80
#define MARGIN 10
#define LEFT_MARGIN 100
#define RIGHT_MARGIN 100
#define TOP_MARGIN 100
#define BOTTOM_MARGIN 100

#define WINDOW_WIDTH LEFT_MARGIN + TILE_SIZE * COL_NUM + MARGIN * (COL_NUM - 1) + RIGHT_MARGIN
#define WINDOW_HEIGHT TOP_MARGIN + TILE_SIZE * ROW_NUM + MARGIN * (ROW_NUM - 1) + BOTTOM_MARGIN

#define RED_COLOR {192, 57, 43, 255}
#define YELLOW_COLOR {241, 196, 15, 255}
#define EMPTY_COLOR {189, 195, 199, 30}

#define RED_TILE "assets/img/red.png"
#define YELLOW_TILE "assets/img/yellow.png"
#define BG_TILE "assets/img/bg.png"
#define BG "assets/img/forest.png"
#define FONT "assets/fonts/Roboto/Roboto-Regular.ttf"

#define FONT_SIZE 20

#define RENDER_DELAY 100

typedef struct window_assets {
    SDL_Surface *bg_surface;
    SDL_Surface *bg_tile_surface;
    SDL_Surface *red_tile_surface;
    SDL_Surface *yellow_tile_surface;
    TTF_Font *main_font;
} WindowAssets;


// CONSOLE CONFIG
#define MAX_INPUT_LENGTH 100
#define ANSI_COLOR_RED     "\x1b[31m"
#define ANSI_COLOR_GREEN   "\x1b[32m"
#define ANSI_COLOR_YELLOW  "\x1b[33m"
#define ANSI_COLOR_BLUE    "\x1b[34m"
#define ANSI_COLOR_MAGENTA "\x1b[35m"
#define ANSI_COLOR_CYAN    "\x1b[36m"
#define ANSI_COLOR_RESET   "\x1b[0m"
#define ANSI_COLOR_BOLD    "\x1b[1m"
#define ANSI_COLOR_UNDERLINE "\x1b[4m"

#define EASY_AI_DEPTH 5
#define MEDIUM_AI_DEPTH 10
#define HARD_AI_DEPTH 20

// types
typedef enum token { EMPTY = 0, RED = 1, YELLOW = 2 } Token;

typedef enum game_mode {
    HUMAN_VS_AI = 1,
    HUMAN_VS_HUMAN = 2,
    AI_VS_AI = 3
} GameMode;

typedef enum game_state {
    GAME_NOT_STARTED = 0,
    GAME_IN_PROGRESS = 1,
    RED_WINS = 2,
    YELLOW_WINS = 3,
    DRAW = 4
} GameState;

typedef struct game Game;

typedef struct player {
    int index;
    char *name;
    Token token;
    int (*strategy)(Game * game);
    bool is_ai;
    int ai_depth;
} Player;

typedef struct game {
    Token tiles[ROW_NUM][COL_NUM];
    Player players[PLAYERS_NUM];
    Player *current_player;
    GameState game_state;
    GameMode game_mode;
} Game;

#endif // CONFIG_H
