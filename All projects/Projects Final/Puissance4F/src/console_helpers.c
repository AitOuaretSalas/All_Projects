/**
 * \file console_helpers.c
 * \brief Fonctions de gestion de la console.
 * \author Zouhir AIT SAADA Salas AIT OUARET
 * \version 0.1
 * \date 08 Janvier 2023
 *
 * Ce fichier contient les fonctions de gestion de la console.
 *
 */

#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <unistd.h>
#include "types.h"


/**
 * /fn char* get_string(char* string, int length)
 * /brief Récupère une chaîne de caractères de la console.
 * /param string Chaîne de caractères à remplir.
 * /param length Longueur de la chaîne de caractères.
 * /return La chaîne de caractères récupérée.
*/
char* get_string(char* string, int length)
{
    char* result = fgets(string, length, stdin);
    if (result != NULL) {
        int last_char_index = strlen(string) - 1;
        if (string[last_char_index] == '\n') {
            string[last_char_index] = '\0';
        }
    }
    return result;
}

/**
 * /fn void get_int(int *number)
 * /brief Récupère un entier de la console.
 * /param number Pointeur vers l'entier à remplir.
*/
void get_int(int *number)
{
    scanf("%d", number);
}

/**
 * /fn void clear_console()
 * /brief Efface la console.
*/
void clear_console()
{
  const char *CLEAR_SCREEN_ANSI = "\e[1;1H\e[2J";
  write(STDOUT_FILENO, CLEAR_SCREEN_ANSI, 12);
}

/**
 * /fn char* format_string(char *string, char *color)
 * /brief Formate une chaîne de caractères.
 * /param string Chaîne de caractères à formater.
 * /param color Couleur de la chaîne de caractères.
 * /return La chaîne de caractères formatée.
*/
char* format_string(char *string, char *color) {
    char *formatted_string = malloc(strlen(string) + strlen(color) + 1);
    strcpy(formatted_string, color);
    strcat(formatted_string, string);
    strcat(formatted_string, ANSI_COLOR_RESET);
    return formatted_string;
}