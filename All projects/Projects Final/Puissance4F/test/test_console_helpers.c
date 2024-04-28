#include <assert.h>
#include "console_helpers.h"
#include "types.h"

void test_format_string(void) {
    printf("(console_helpers.c) test_format_string\n");
    char *str = format_string("Hello", ANSI_COLOR_RED);
    assert(strcmp(str, "\x1b[31mHello\x1b[0m") == 0);
    free(str);
}