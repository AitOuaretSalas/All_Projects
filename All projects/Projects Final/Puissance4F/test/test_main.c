#include <stdio.h>
#include "test_utils.h"
#include "test_console_helpers.h"

int main() {
    printf("Running unit tests...\n");
    min_test();
    max_test();
    test_format_string();
    printf("All tests passed!\n");
    return 0;
}