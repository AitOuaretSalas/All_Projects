#include <assert.h>
#include "utils.h"

void min_test(void) {
    printf("(utils.c) min_test\n");
    assert(min(1, 2) == 1);
    assert(min(2, 1) == 1);
    assert(min(1, 1) == 1);
}

void max_test(void) {
    printf("(utils.c) max_test\n");
    assert(max(1, 2) == 2);
    assert(max(2, 1) == 2);
    assert(max(1, 1) == 1);
}