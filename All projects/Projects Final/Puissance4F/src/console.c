/**
 * \file console.c
 * \brief Fonctions de gestion de la console.
 * \author Zouhir AIT SAADA Salas AIT OUARET
 * \version 0.1
 * \date 08 Janvier 2023
 *
 * Ce fichier contient les fonctions de gestion de la console.
 *
 */

#include <stdio.h>
#include <string.h>
#include <unistd.h>

#include "types.h"
#include "gui.h"
#include "console_helpers.h"
#include "game.h"
#include "strategies.h"


/**
 * \fn void reset_console_header(char *name, int mode, int difficulty)
 * \brief Réinitialise l'en-tête de la console.
 * \param name Nom du joueur.
 * \param mode Mode de jeu.
 * \param difficulty Difficulté.
 * \return void
*/
void reset_console_header(char *name, int mode, int difficulty) {
    clear_console();
    printf(BANNER);
    
    if (name == NULL) {
        return;
    }

    char *mode_str = "";
    if (mode == 1) {
        mode_str = "Human vs AI";
    } else if (mode == 2) {
        mode_str = "Human vs Human";
    } else if (mode == 3) {
        mode_str = "AI vs AI";
    }

    char *difficulty_str = "";
    if (difficulty == 1) {
        difficulty_str = "Facile";
    } else if (difficulty == 2) {
        difficulty_str = "Moyen";
    } else if (difficulty == 3) {
        difficulty_str = "Difficile";
    }
    printf("Bonjour %s \tMode: %s\tDifficulé: %s\n\n", 
        format_string(name, ANSI_COLOR_CYAN),
        format_string(mode_str, ANSI_COLOR_BOLD),
        format_string(difficulty_str, ANSI_COLOR_BOLD)
    );
}

/**
 * \fn void print_grid(Game *game)
 * \brief Affiche la grille de jeu dans la console.
 * \param game Pointeur vers la structure de jeu.
 * \return void
*/
void print_grid(Game *game) {

    char* red_circle = format_string("●", ANSI_COLOR_RED);
    char* yellow_circle = format_string("●", ANSI_COLOR_YELLOW);

    printf("\n");
    
    for (int i = 0; i < COL_NUM; i++) {
        printf("  %d ", i + 1);
    }
    printf("\n");

    for (int i = 0; i < COL_NUM; i++) {
        printf("----");
    }
    printf("\n");


    for (int i = 0; i < ROW_NUM; i++) {
        printf("|");
        for (int j = 0; j < COL_NUM; j++) {
            char *tile_char = game->tiles[i][j] == RED ? red_circle : game->tiles[i][j] == YELLOW ? yellow_circle : " ";
            printf(" %s |", tile_char);
        }
        printf("\n");
        for (int i = 0; i < COL_NUM; i++) {
            printf("----");
        }
        printf("\n");
    }
}

/**
 * \fn void redraw_console_game(Game *game)
 * \brief Redessine la grille de jeu dans la console.
 * \param game Pointeur vers la structure de jeu.
 * \return void
*/
void redraw_console_game(Game *game) {
    clear_console();
    printf(BANNER);

    char* player_color = game->current_player->token == RED ? ANSI_COLOR_RED : ANSI_COLOR_YELLOW;
    printf("Tour du joueur: %s\n\n", 
        format_string(game->current_player->name, player_color)
    );

    print_grid(game);
}

/**
 * \fn bool is_valid_column(Game *game, int col_num)
 * \brief Vérifie si la colonne est valide.
 * \param game Pointeur vers la structure de jeu.
 * \param col_num Numéro de la colonne.
 * \return bool
*/
bool is_valid_column(Game *game, int col_num) {
    // check if column is full
    bool is_valid = true;
    is_valid &= col_num > 0 && col_num <= COL_NUM;
    int col_index = col_num - 1;
    is_valid &= game->tiles[ROW_NUM - 1][col_index] == EMPTY;
    return is_valid;
}

/**
 * \fn void start_console_mode(Game *game)
 * \brief Démarre le mode console.
 * \param game Pointeur vers la structure de jeu.
 * \return void
*/
void start_console_mode(Game *game) {

    game->game_state = GAME_IN_PROGRESS;

    while (game->game_state == GAME_IN_PROGRESS) {
        redraw_console_game(game);

        int chosen_col_index = game->current_player->strategy(game);

        if (!play_turn(game, chosen_col_index)) {
            printf("Erreur: Impossible de jouer dans la colonne %d\n", chosen_col_index + 1);
            exit(1);
        }

        game->game_state = check_game_state(game);
        int next_player_index = ( game->current_player->index + 1 ) % PLAYERS_NUM;
        game->current_player = &game->players[next_player_index];
    }

    redraw_console_game(game);

    if (game->game_state == DRAW) {
        printf("Match nul!\n");
    } else if (game->game_state == RED_WINS) {
        printf("Le joueur %s a gagné!\n", format_string(game->players[0].name, ANSI_COLOR_RED));
    } else if (game->game_state == YELLOW_WINS) {
        printf("Le joueur %s a gagné!\n", format_string(game->players[1].name, ANSI_COLOR_YELLOW));
    }
}

/**
    * \fn void start_pre_console()
    * \brief Affiche le premier écran de la console pour récupérer les informations du joueur.
    * \return void
*/
void start_pre_console() {

    reset_console_header(NULL, 0, 0);
    
    // ask for name
    printf("Entrez votre nom: ");
    char input_name[MAX_INPUT_LENGTH];
    get_string(input_name, MAX_INPUT_LENGTH);

    reset_console_header(input_name, 0, 0);

    // ask for game mode 
    printf("Choisissez un mode de jeu\n");
    printf("1. Human vs AI\n");
    printf("2. Human vs Human\n");
    printf("3. AI vs AI\n");
    // get 1, 2 or 3 from user
    int input_mode = 0;
    get_int(&input_mode);
    while (input_mode < 1 || input_mode > 3) {
        printf("Veuillez entrer 1, 2 ou 3\n");
        get_int(&input_mode);
    }

    reset_console_header(input_name, input_mode, 0);

    // ask for difficulty if AI vs Human
    int depth_limit = 0;
    int input_difficulty = 0;
    if (input_mode == 1 || input_mode == 3) {
        printf("Choisissez une difficulté\n");
        printf("1. Facile\n");
        printf("2. Moyen\n");
        printf("3. Difficile\n");
        // get 1, 2 or 3 from user
        int input_difficulty = 0;
        get_int(&input_difficulty);
        while (input_difficulty < 1 || input_difficulty > 3) {
            printf("Veuillez entrer 1, 2 ou 3\n");
            get_int(&input_difficulty);
        }

        if (input_difficulty == 1) {
            depth_limit = EASY_AI_DEPTH;
        } else if (input_difficulty == 2) {
            depth_limit = MEDIUM_AI_DEPTH;
        } else if (input_difficulty == 3) {
            depth_limit = HARD_AI_DEPTH;
        }
    }

    reset_console_header(input_name, input_mode, input_difficulty);

    // ask if user wants to play in console or gui
    printf("Voulez-vous jouer en mode console ou en mode graphique?\n");
    printf("1. Console\n");
    printf("2. Graphique\n");
    // get 1 or 2 from user
    int input_gui = 0;
    get_int(&input_gui);
    while (input_gui < 1 || input_gui > 2) {
        printf("Veuillez entrer 1 ou 2\n");
        get_int(&input_gui);
    }

    // start game
    printf("Commencer la partie\n");

    Player player_1, player_2;

    // HUMAN_VS_AI, Console
    if (input_mode == 1 && input_gui == 1) {
        player_1 = (Player) {0, input_name, RED, human_console_strategy, false, 0};
        player_2 = (Player) {1, "AI", YELLOW, minmax_strategy, true, depth_limit};
    }
    // HUMAN_VS_AI, GUI
    else if (input_mode == 1 && input_gui == 2) {
        player_1 = (Player) {0, input_name, RED, human_gui_strategy, false, 0};
        player_2 = (Player) {1, "AI", YELLOW, minmax_strategy, true, depth_limit};
    }

    // HUMAN_VS_HUMAN, Console
    else if (input_mode == 2 && input_gui == 1) {
        player_1 = (Player) {0, input_name, RED, human_console_strategy, false, 0};
        player_2 = (Player) {1, "Joueur 2", YELLOW, human_console_strategy, false, 0};
    }

    // HUMAN_VS_HUMAN, GUI
    else if (input_mode == 2 && input_gui == 2) {
        player_1 = (Player) {0, input_name, RED, human_gui_strategy, false, 0};
        player_2 = (Player) {1, "Joueur 2", YELLOW, human_gui_strategy, false, 0};
    }

    // AI_VS_AI, Console
    else if (input_mode == 3 && input_gui == 1) {
        player_1 = (Player) {0, "AI 1", RED, minmax_strategy, true, depth_limit};
        player_2 = (Player) {1, "AI 2", YELLOW, minmax_strategy, true, depth_limit};
    }

    // AI_VS_AI, GUI
    else { // if (input_mode == 3 && input_gui == 2) 
        player_1 = (Player) {0, "AI 1", RED, minmax_strategy, true, depth_limit};
        player_2 = (Player) {1, "AI 2", YELLOW, minmax_strategy, true, depth_limit};
    }

    // init game
    printf("Initialisation du jeu...\n");
    Game *game = malloc(sizeof(Game));
    init_tiles(game);
    game->game_mode = input_mode;
    game->players[0] = player_1;
    game->players[1] = player_2;
    game->current_player = &game->players[0];
    game->game_state = GAME_IN_PROGRESS;

    if (input_gui == 1) {
        start_console_mode(game);
    } else {
        start_gui_mode(game);
    }
}
