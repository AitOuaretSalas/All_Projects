/**
 * \file gui.c
 * \brief Fonctions de gestion de l'interface graphique.
 * \author Zouhir AIT SAADA Salas AIT OUARET
 * \version 0.1
 * \date 08 Janvier 2023
 *
 * Ce fichier contient les fonctions de gestion de l'interface graphique.
 *
 */

#include <SDL2/SDL.h>
#include <SDL2/SDL_image.h>
#include <SDL2/SDL_ttf.h>
#include "types.h"
#include "game.h"
#include "strategies.h"
#include "console.h"

/**
 * \fn int init_sdl()
 * \brief Initialise SDL, SDL_image et SDL_ttf.
 * \return 0 si tout s'est bien passé, 1 sinon.
*/

int init_sdl() {

  // Initialiser SDL
  if (SDL_Init(SDL_INIT_EVERYTHING) < 0)
  {
    printf("SDL could not initialize! SDL_Error: %s", SDL_GetError());
    return 1;
  }

  // Initialiser SDL_image
  if (!(IMG_Init(IMG_INIT_PNG) & IMG_INIT_PNG))
  {
    printf("SDL_image could not initialize! SDL_image Error: %s", IMG_GetError());
    return 1;
  }

  // Initialiser SDL_ttf
  if (TTF_Init() == -1)
  {
    printf("SDL_ttf could not initialize! SDL_ttf Error: %s", TTF_GetError());
    return 1;
  }

  SDL_SetHint( SDL_HINT_RENDER_SCALE_QUALITY, "1" );
  SDL_GL_SetAttribute(SDL_GL_RED_SIZE, 8);
  SDL_GL_SetAttribute(SDL_GL_GREEN_SIZE, 8);
  SDL_GL_SetAttribute(SDL_GL_BLUE_SIZE, 8);
  SDL_GL_SetAttribute(SDL_GL_ALPHA_SIZE, 8);
  SDL_GL_SetAttribute(SDL_GL_DEPTH_SIZE, 32);
  SDL_GL_SetAttribute(SDL_GL_MULTISAMPLEBUFFERS, 1);
  SDL_GL_SetAttribute(SDL_GL_MULTISAMPLESAMPLES, 2);
  SDL_GL_SetAttribute(SDL_GL_ACCELERATED_VISUAL, 1);

  return 0;
}

/**
 * \fn void update_window(SDL_Renderer *renderer, Game *game, WindowAssets *assets)
 * \brief Met à jour la fenêtre.
 * \param renderer Le renderer de la fenêtre.
 * \param game Le jeu.
 * \param assets Les assets de la fenêtre.
 * \return void
*/
void update_window(SDL_Renderer *renderer, Game *game, WindowAssets *assets) {
  
  SDL_Texture *texture = SDL_CreateTextureFromSurface(renderer, assets->bg_surface);
  SDL_RenderCopy(renderer, texture, NULL, NULL);
  SDL_DestroyTexture(texture);

  // Add text in the top left of the window
  SDL_Color color = {255, 255, 255, 255};
  SDL_Surface *surface_text = TTF_RenderText_Blended(assets->main_font, "Puissance 4", color);
  SDL_Texture *texture_text = SDL_CreateTextureFromSurface(renderer, surface_text);
  SDL_Rect rect_text = {20, 20, surface_text->w, surface_text->h};
  SDL_RenderCopy(renderer, texture_text, NULL, &rect_text);

  SDL_Rect rect_top_right_text = {WINDOW_WIDTH - 20 - surface_text->w, 20, surface_text->w, surface_text->h};
  
  if (game->game_state == GAME_NOT_STARTED) {
    // add text to the top right of the window
    SDL_Color color = {255, 255, 255, 255};
    SDL_Surface *surface_text = TTF_RenderText_Blended(assets->main_font, "Game not started !", color);
    SDL_Texture *texture_text = SDL_CreateTextureFromSurface(renderer, surface_text);
    SDL_RenderCopy(renderer, texture_text, NULL, &rect_top_right_text);


    // show a form with:
    // - Player name input field
    // - Radio button to select game mode (Human vs Human, Human vs AI, AI vs AI)
    // - Radio button to select AI strenth (EASY, MEDIUM, HARD)
    // - A button to start the game
  }

  if (game->game_state == GAME_IN_PROGRESS)
  {
    // dessiner la grille
    for (int i = 0; i < ROW_NUM; i++)
    {
      for (int j = 0; j < COL_NUM; j++)
      {
        int x = TOP_MARGIN + j * (TILE_SIZE + MARGIN);
        int y = LEFT_MARGIN + i * (TILE_SIZE + MARGIN);
        
        SDL_Rect rect = {x, y, TILE_SIZE, TILE_SIZE};

        Token current_token = game->tiles[i][j];

        SDL_Surface *tile_surface = NULL;
        if (current_token == RED) {
          tile_surface = assets->red_tile_surface;
        }
        if (current_token == YELLOW) {
          tile_surface = assets->yellow_tile_surface;
        }

        SDL_Texture *texture_bg = SDL_CreateTextureFromSurface(renderer, assets->bg_tile_surface);
        SDL_RenderCopy(renderer, texture_bg, NULL, &rect);
        SDL_DestroyTexture(texture_bg);

        // draw image from file
        SDL_Texture *texture = SDL_CreateTextureFromSurface(renderer, tile_surface);
        SDL_RenderCopy(renderer, texture, NULL, &rect);
        SDL_DestroyTexture(texture);

      }
    }
  }

  if (game->game_state == RED_WINS)
  {
    // show a form with:
    // - A message to congratulate the winner
    // - A button to start a new game

    SDL_Color color = {255, 0, 0, 255};
    SDL_Surface *surface_text = TTF_RenderText_Blended(assets->main_font, "RED WINS !", color);
    SDL_Texture *texture_text = SDL_CreateTextureFromSurface(renderer, surface_text);
    SDL_RenderCopy(renderer, texture_text, NULL, &rect_top_right_text);
  }

  if (game->game_state == YELLOW_WINS)
  {
    // show a form with:
    // - A message to congratulate the winner
    // - A button to start a new game

    SDL_Color color = {255, 255, 0, 255};
    SDL_Surface *surface_text = TTF_RenderText_Blended(assets->main_font, "YELLOW WINS !", color);
    SDL_Texture *texture_text = SDL_CreateTextureFromSurface(renderer, surface_text);
    SDL_RenderCopy(renderer, texture_text, NULL, &rect_top_right_text);

  }

  if (game->game_state == DRAW)
  {
    // show a form with:
    // - A message to congratulate the winner
    // - A button to start a new game

    SDL_Color color = {255, 255, 255, 255};
    SDL_Surface *surface_text = TTF_RenderText_Blended(assets->main_font, "DRAW !", color);
    SDL_Texture *texture_text = SDL_CreateTextureFromSurface(renderer, surface_text);
    SDL_RenderCopy(renderer, texture_text, NULL, &rect_top_right_text);
  }

  // mettre à jour la fenêtre
}

/**
 * \brief Gère les événements de la fenêtre.
 * \param e L'événement à traiter.
 * \param game Le jeu en cours.
 * \return true si l'événement est un QUIT, false sinon.
*/
bool process_events(SDL_Event *e, Game *game) {

  if (e->type == SDL_QUIT) {
    return true;
  }
  else if (e->type == SDL_MOUSEBUTTONDOWN) {
    if (e->button.button == SDL_BUTTON_LEFT) {
      int x = e->button.x;

      int chosen_col_index = (x - LEFT_MARGIN) / (TILE_SIZE + MARGIN);
      int row = ROW_NUM - 1;

      if (game->game_state != GAME_IN_PROGRESS) {
        return false;
      }
      if (game->current_player->is_ai) {
        return false;
      }

      if (game->tiles[row][chosen_col_index] != EMPTY) {
        return false;
      }

      if (chosen_col_index < 0 || chosen_col_index >= COL_NUM) {
        return false;
      }
    
      if (!play_turn(game, chosen_col_index)) {
        printf("Erreur: Impossible de jouer dans la colonne %d\n", chosen_col_index + 1);
        exit(1);
      }
      printf("Joueur %s joue dans la colonne %d\n", game->current_player->name, chosen_col_index + 1);

      game->game_state = check_game_state(game);
      int next_player_index = ( game->current_player->index + 1 ) % PLAYERS_NUM;
      game->current_player = &game->players[next_player_index];
    }
  }
  return false;
}

/**
 * \brief Lance le mode graphique.
 * \param game pointeur vers le jeu.
 * \return 0 si tout s'est bien passé, 1 sinon.
*/
int start_gui_mode(Game *game) {

  init_sdl();

  // Créer la fenêtre et le renderer
  SDL_Window* window = SDL_CreateWindow(
      APP_NAME, SDL_WINDOWPOS_UNDEFINED, SDL_WINDOWPOS_UNDEFINED, WINDOW_WIDTH,
      WINDOW_HEIGHT, SDL_WINDOW_SHOWN);
  if (!window) printf("Error: SDL_CreateWindow (%s)", SDL_GetError());

  SDL_Renderer* renderer = SDL_CreateRenderer(window, -1, SDL_RENDERER_ACCELERATED | SDL_RENDERER_PRESENTVSYNC);
  if (!renderer) renderer = SDL_CreateRenderer(window, -1, SDL_RENDERER_SOFTWARE);
  if (!renderer) printf("Error: SDL_CreateRenderer (%s)", SDL_GetError());


  WindowAssets *assets = malloc(sizeof(WindowAssets));
  assets->bg_surface = IMG_Load(BG);
  assets->bg_tile_surface = IMG_Load(BG_TILE);
  assets->red_tile_surface = IMG_Load(RED_TILE);
  assets->yellow_tile_surface = IMG_Load(YELLOW_TILE);
  assets->main_font = TTF_OpenFont(FONT, FONT_SIZE);

  bool quit = false;
  SDL_Event e;

  while (!quit)
  {
    // Gérer les evenement de la fenêtre
    while (SDL_PollEvent(&e) != 0)
    {
      quit = process_events(&e, game);
      if (quit) break;
    }
    // update window after human player turn
    update_window(renderer, game, assets);

    SDL_SetRenderDrawColor(renderer, 160, 160, 160, 255); // gris clair
    SDL_RenderClear(renderer);

    if (game->current_player->is_ai) {
        // AI TURN
        int chosen_col_index = game->current_player->strategy(game);

        if (!play_turn(game, chosen_col_index)) {
            printf("Erreur: Impossible de jouer dans la colonne %d\n", chosen_col_index + 1);
            exit(1);
        }

        game->game_state = check_game_state(game);
        int next_player_index = ( game->current_player->index + 1 ) % PLAYERS_NUM;
        game->current_player = &game->players[next_player_index];
    }
    update_window(renderer, game, assets);

    SDL_RenderPresent(renderer);
    // SDL_Delay(RENDER_DELAY);
  }

  // nettoyer la mémoire
  SDL_DestroyRenderer(renderer);
  SDL_DestroyWindow(window);
  IMG_Quit();
  TTF_Quit();
  SDL_Quit();
  free(game);
  return EXIT_SUCCESS;
}
