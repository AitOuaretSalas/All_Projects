#ifndef CONSOLE_H
#define CONSOLE_H


void start_pre_console();
void start_console_mode(Game *game);
bool is_valid_column(Game *game, int col);
char* get_string(char* string, int length);

#endif // CONSOLE_H

