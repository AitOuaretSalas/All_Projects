/**
 * \file utils.c
 * \brief Fonctions utilitaires.
 * \author Zouhir AIT SAADA Salas AIT OUARET
 * \version 0.1
 * \date 08 Janvier 2023
 *
 * Ce fichier contient les fonctions utilitaires. (ex: min, max)
 *
 */

#include "utils.h"
#include "types.h"
#include <stdbool.h>

/**
 * \fn int min(int a, int b)
 * \brief Retourne le minimum entre a et b.
 * \param a Premier entier.
 * \param b Deuxième entier.
 * \return Le minimum entre a et b.
*/
int min(int a, int b)
{
    return a < b ? a : b;
}

/**
 * \fn int max(int a, int b)
 * \brief Retourne le maximum entre a et b.
 * \param a Premier entier.
 * \param b Deuxième entier.
 * \return Le maximum entre a et b.
*/
int max(int a, int b)
{
    return a > b ? a : b;
}