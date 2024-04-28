/**
 * \file strategies.c
 * \brief Fonctions de gestion des stratégies.
 * \author Zouhir AIT SAADA Salas AIT OUARET
 * \version 0.1
 * \date 08 Janvier 2023
 *
 * Ce fichier contient les fonctions de gestion des stratégies.
 *
 */

#include <limits.h>
#include <unistd.h>

#include "types.h"
#include "game.h"
#include "utils.h"
#include "console.h"
#include "console_helpers.h"

Token self;

/**
 * \fn int human_console_strategy(Game *game)
 * \brief Fonction qui récupère l'input d'un joueur humain en mode console.
 * \param game Pointeur vers la structure Game.
 * \return L'index de la colonne à jouer.
*/
int human_console_strategy(Game *game) {
  int input_col = -1;
  printf("Entrez le numéro de la colonne: ");
  get_int(&input_col);
  while (!is_valid_column(game, input_col)) {
      printf("Veuillez entrer un numéro de colonne valide: ");
      get_int(&input_col);
  }
  input_col--;
  return input_col;
}

/**
 * \fn int human_gui_strategy(Game *game)
 * \brief La fonction qui récupère l'input d'un joueur humain en mode graphique est gérée dans l'event loop de l'interface graphique.
 * \param game Pointeur vers la structure Game.
 * \return L'index du joueur actuel.
*/
int human_gui_strategy(Game *game){
  return game->current_player->index;
}

/**
 * \fn bool unmove(Token ***tiles, int col_index)
 * \brief Annule le dernier mouvement joué dans la colonne donnée.
 * \param tiles Pointeur vers la matrice de jetons.
 * \param col_index Index de la colonne à annuler.
*/
bool unmove(Token ***tiles, int col_index) {
  for (int i = 0; i < ROW_NUM; i++) {
      if ((*tiles)[i][col_index] != EMPTY) {
          (*tiles)[i][col_index] = EMPTY;
          return true;
      }
  }
  return false;
}

/**
 * \fn bool check_draw(Token ***tiles)
 * \brief Vérifie si la partie est une égalité.
 * \param tiles Pointeur vers la matrice de jetons.
 * \return Vrai si la partie est une égalité, faux sinon.
 * \note La partie est une égalité si toutes les cases sont remplies et qu'aucun joueur n'a gagné.
 */
bool check_draw(Token ***tiles) {
  bool is_draw = true;
  for (int i = 0; i < ROW_NUM; i++) {
      for (int j = 0; j < COL_NUM; j++) {
          is_draw &= (*tiles)[i][j] != EMPTY;
      }
  }
  return is_draw;
}

/**
 * \fn bool move_is_valid(Token ***tiles, int col_index)
 * \brief Vérifie si le mouvement est valide.
 * \param tiles Pointeur vers la matrice de jetons.
 * \param col_index Index de la colonne à vérifier.
 * \return Vrai si le mouvement est valide, faux sinon.
 * \note Le mouvement est valide si la colonne n'est pas pleine.
 */
bool move_is_valid(Token ***tiles, int col_index) {
  return (*tiles)[ROW_NUM - 1][col_index] == EMPTY;
}

/**
 * \fn GameState check_game_state_tiles(Token ***tiles_p)
 * \brief Vérifie l'état de la partie.
 * \param tiles_p Pointeur vers la matrice de jetons.
 * \return L'état de la partie.
 * \note L'état de la partie est soit en cours, soit un joueur a gagné, soit la partie est une égalité.
 */
GameState check_game_state_tiles(Token ***tiles_p) {

  // check for wins
  Token **tiles = *tiles_p;
  for (int i = 0; i < ROW_NUM; i++) {
    for (int j = 0; j < COL_NUM; j++) {
        Token current_token = tiles[i][j];
        if (current_token != EMPTY) {
          // check horizontal
          if (j + WINNING_CONNECTED_NUM < COL_NUM && current_token == tiles[i][j + 1] && current_token == tiles[i][j + 2] && current_token == tiles[i][j + 3]) {
              return current_token == RED ? RED_WINS : YELLOW_WINS;
          }
          // check vertical
          if (i + WINNING_CONNECTED_NUM < ROW_NUM && current_token == tiles[i + 1][j] && current_token == tiles[i + 2][j] && current_token == tiles[i + 3][j]) {
              return current_token == RED ? RED_WINS : YELLOW_WINS;
          }
          // check diagonal
          if (i + WINNING_CONNECTED_NUM < ROW_NUM && j + WINNING_CONNECTED_NUM < COL_NUM && current_token == tiles[i + 1][j + 1] && current_token == tiles[i + 2][j + 2] && current_token == tiles[i + 3][j + 3]) {
              return current_token == RED ? RED_WINS : YELLOW_WINS;
          }   
          // check anti-diagonal
          if (i + WINNING_CONNECTED_NUM < ROW_NUM && j - WINNING_CONNECTED_NUM >= 0 && current_token == tiles[i + 1][j - 1] && current_token == tiles[i + 2][j - 2] && current_token == tiles[i + 3][j - 3]) {
              return current_token == RED ? RED_WINS : YELLOW_WINS;
          }
        }
      }
    }

    bool is_draw = true;
    for (int i = 0; i < ROW_NUM; i++) {
        for (int j = 0; j < COL_NUM; j++) {
            is_draw &= tiles[i][j] != EMPTY;
        }
    }
    if (is_draw) {
        return DRAW;
    }

    return GAME_IN_PROGRESS;
}

/**
 * \fn bool put_token(Token ***tiles, Token token, int col)
 * \brief Place un jeton dans la colonne donnée.
 * \param tiles Pointeur vers la matrice de jetons.
 * \param token Jeton à placer.
 * \param col Index de la colonne où placer le jeton.
 * \return Vrai si le jeton a été placé, faux sinon.
*/
bool put_token(Token ***tiles, Token token, int col) {

  if (col < 0 || col >= COL_NUM) {
    return false;
  }
  for (int y = 0; y < ROW_NUM; y++) {
    if ((*tiles)[y][col] == EMPTY) {
      (*tiles)[y][col] = token;
      return true;
    }
  }
  return false;
}

/**
 * \fn bool move_is_win(Token ***tiles, Token token, int col_index)
 * \brief Vérifie si le mouvement est gagnant.
 * \param tiles Pointeur vers la matrice de jetons.
 * \param token Jeton à placer.
 * \param col_index Index de la colonne où placer le jeton.
 * \return Vrai si le mouvement est gagnant, faux sinon.
*/
bool move_is_win(Token ***tiles, Token token, int col_index) {

  put_token(tiles, token, col_index);
  GameState game_state = check_game_state_tiles(tiles);
  unmove(tiles, col_index);
  bool is_win = game_state == RED_WINS || game_state == YELLOW_WINS;
  return is_win;
}

/**
 * \fn int minmax_score(Token **tiles, Token self, int depth, int alpha, int beta, int depth_limit)
 * \brief Calcule le score du mouvement.
 * \param tiles Pointeur vers la matrice de jetons.
 * \param self Jeton du joueur.
 * \param depth Profondeur de l'arbre de recherche.
 * \param alpha Valeur alpha de l'algorithme alpha-beta.
 * \param beta Valeur beta de l'algorithme alpha-beta.
 * \param depth_limit Profondeur maximale de l'arbre de recherche.
 * \return Score du mouvement.
*/
int minmax_score(Token **tiles, Token self, int depth, int alpha, int beta, int depth_limit) {

  Token opponent = (self == RED) ? YELLOW : RED;
  if (check_draw(&tiles))
  {
    printf("draw detected");
    return 0;
  }

  // if self can win
  for (int col = 0; col < COL_NUM; col++) {
    if (move_is_valid(&tiles, col) && move_is_win(&tiles, self, col)) {
      if (self == RED) {
        if (depth != 0)
          return (ROW_NUM * COL_NUM + 1 - depth) / 2;
        else
          return col;
      } else {
        if (depth != 0)
          return -(ROW_NUM * COL_NUM + 1 - depth) / 2;
        else
          return col;
      }
    }
  }

  if (depth >= depth_limit) {
    return 0;
  }

  int best_score = ((self == RED) ? -1 : 1) * (ROW_NUM * COL_NUM + 1);
  int best_col = -1;
  int current_score;
  for (int column = 0; column < COL_NUM; column++) {
    if (move_is_valid(&tiles, column)) {
      if (!put_token(&tiles, self, column)) {
        printf("ERROR: in put_token\n");
        exit(1);
      }
      current_score = minmax_score(tiles, opponent, depth + 1, alpha, beta, depth_limit);
      
      if (!unmove(&tiles, column)) {
        printf("ERROR: in unmove\n");
        exit(1);
      }

      if ((self == RED && current_score > best_score) ||
          (self == YELLOW && current_score < best_score)) {
        best_score = current_score;
        best_col = column;
      }

      if (self == RED) {
        if (beta <= current_score)
          break;
        if (alpha < current_score)
          alpha = current_score;
      } else {
        if (alpha >= current_score)
          break;
        if (beta > current_score)
          beta = current_score;
      }
    }
  }

  if (depth == 0) {
    if (best_col == -1)
      printf("ERROR: There is a bug in minimax: no node has been visited\n");
    return best_col;
  } else
    return best_score;
}

int minmax_strategy(Game *game) {
  /**
   * \fn int minmax_strategy(Game *game)
   * \brief Stratégie de l'IA basée sur l'algorithme MinMax.
   * \param game Pointeur vers la structure de jeu.
   * \return Index de la colonne où placer le jeton.
  */
  // sleep for 0.5 seconds
  usleep(500000);

  int total_tokens = 0;
  for (int y = 0; y < ROW_NUM; y++) {
    for (int x = 0; x < COL_NUM; x++) {
      if (game->tiles[y][x] != EMPTY)
        total_tokens++;
    }
  }

  if (total_tokens % 2 == 0) {
    self = RED;
  } else if (total_tokens % 2 == 1) {
    self = YELLOW;
  }

  if (total_tokens == 0) {
    return COL_NUM / 2;
  } else if (total_tokens == 1) {
    if (game->tiles[0][1] != EMPTY) {
      return 2;
    } else if (game->tiles[0][COL_NUM - 2] != EMPTY) {
      return COL_NUM - 3;
    } else {
      return COL_NUM / 2;
    }
  } else if (total_tokens == 2) {
    if (game->tiles[0][COL_NUM - 2] != EMPTY || game->tiles[0][COL_NUM - 3] != EMPTY) {
      return 2;
    } else if (game->tiles[0][2] != EMPTY || game->tiles[0][1] != EMPTY) {
      return COL_NUM - 2;
    } else {
      return COL_NUM / 2;
    }
  }

  // create a deep copy
  Token **tiles_copy = calloc(sizeof(Token *), ROW_NUM * 100);
  for (int row = 0; row < ROW_NUM; row++) {
    tiles_copy[row] = calloc(sizeof(Token), COL_NUM * 100);
  }

  for (int y = 0; y < ROW_NUM; y++) {
    for (int x = 0; x < COL_NUM; x++) {
      tiles_copy[y][x] = game->tiles[y][x];
    }
  }

  int depth_limit = game->players[1].ai_depth;
  int best_col = minmax_score(tiles_copy, self, 0, INT_MIN, INT_MAX, depth_limit);

  // free the deep copy
  for (int row = 0; row < ROW_NUM; row++) {
    free(tiles_copy[row]);
  }
  free(tiles_copy);
  
  return best_col;
}
