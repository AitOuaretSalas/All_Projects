/**
 * \file game.c
 * \brief Fonctions de gestion du jeu.
 * \author Zouhir AIT SAADA Salas AIT OUARET
 * \version 0.1
 * \date 08 Janvier 2023
 *
 * Ce fichier contient les fonctions de gestion du jeu.
 *
 */


#include "game.h"
#include "types.h"

/**
 * \fn void init_tiles(Game *game)
 * \brief Initialise les cases du jeu.
 * \param game Pointeur vers la structure Game.
 */
void init_tiles(Game *game) {
  for (int i = 0; i < ROW_NUM; i++) {
    for (int j = 0; j < COL_NUM; j++) {
        game->tiles[i][j] = EMPTY;
    }
  }
}

/**
 * \fn bool play_turn(Game *game, int col_index)
 * \brief Joue un tour.
 * \param game Pointeur vers la structure Game.
 * \param col_index Index de la colonne à jouer.
*/
bool play_turn(Game *game, int col_index) {
    
    if (game->tiles[ROW_NUM - 1][col_index] != EMPTY) {
        return false;
    }

    for (int i = 0; i < ROW_NUM; i++) {
        if (game->tiles[i][col_index] == EMPTY) {
            game->tiles[i][col_index] = game->current_player->token;
            return true;
        }
    }
    return false;
}

/**
 * \fn GameState check_game_state(Game *game)
 * \brief Vérifie l'état du jeu.
 * \param game Pointeur vers la structure Game.
 * \return L'état du jeu.
*/
GameState check_game_state(Game *game) {
    // check for wins
    for (int i = 0; i < ROW_NUM; i++) {
        for (int j = 0; j < COL_NUM; j++) {
            Token current_token = game->tiles[i][j];
            if (current_token != EMPTY) {
                // check horizontal
                if (j + WINNING_CONNECTED_NUM < COL_NUM && current_token == game->tiles[i][j + 1] && current_token == game->tiles[i][j + 2] && current_token == game->tiles[i][j + 3]) {
                    return current_token == RED ? RED_WINS : YELLOW_WINS;
                }
                // check vertical
                if (i + WINNING_CONNECTED_NUM < ROW_NUM && current_token == game->tiles[i + 1][j] && current_token == game->tiles[i + 2][j] && current_token == game->tiles[i + 3][j]) {
                    return current_token == RED ? RED_WINS : YELLOW_WINS;
                }
                // check diagonal
                if (i + WINNING_CONNECTED_NUM < ROW_NUM && j + WINNING_CONNECTED_NUM < COL_NUM && current_token == game->tiles[i + 1][j + 1] && current_token == game->tiles[i + 2][j + 2] && current_token == game->tiles[i + 3][j + 3]) {
                    return current_token == RED ? RED_WINS : YELLOW_WINS;
                }   
                // check anti-diagonal
                if (i + WINNING_CONNECTED_NUM < ROW_NUM && j - WINNING_CONNECTED_NUM >= 0 && current_token == game->tiles[i + 1][j - 1] && current_token == game->tiles[i + 2][j - 2] && current_token == game->tiles[i + 3][j - 3]) {
                    return current_token == RED ? RED_WINS : YELLOW_WINS;
                }
            }
        }
    }

    bool is_draw = true;
    for (int i = 0; i < ROW_NUM; i++) {
        for (int j = 0; j < COL_NUM; j++) {
            is_draw &= game->tiles[i][j] != EMPTY;
        }
    }
    if (is_draw) {
        return DRAW;
    }

    return GAME_IN_PROGRESS;
}
