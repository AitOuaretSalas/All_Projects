#ifndef CONSOLE_HELPERS_H
#define CONSOLE_HELPERS_H

#define BANNER ""\
" ██████╗ ██████╗ ███╗   ██╗███╗   ██╗███████╗ ██████╗████████╗    ██╗  ██╗\n"\
"██╔════╝██╔═══██╗████╗  ██║████╗  ██║██╔════╝██╔════╝╚══██╔══╝    ██║  ██║\n"\
"██║     ██║   ██║██╔██╗ ██║██╔██╗ ██║█████╗  ██║        ██║       ███████║\n"\
"██║     ██║   ██║██║╚██╗██║██║╚██╗██║██╔══╝  ██║        ██║       ╚════██║\n"\
"╚██████╗╚██████╔╝██║ ╚████║██║ ╚████║███████╗╚██████╗   ██║            ██║\n"\
" ╚═════╝ ╚═════╝ ╚═╝  ╚═══╝╚═╝  ╚═══╝╚══════╝ ╚═════╝   ╚═╝            ╚═╝\n"\
"Crée par: Zouhir AIT SAADA\n\n"

char* get_string(char* string, int length);

void get_int(int *number);

void clear_console();

char* format_string(char *string, char *color);

#endif // CONSOLE_HELPERS_H