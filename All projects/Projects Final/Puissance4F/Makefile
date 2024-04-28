SRC_DIR = src
TEST_DIR = test
BUILD_DIR = build/debug
CC = gcc

ENTRY_POINT = $(SRC_DIR)/main.c
SRC_FILES = ${wildcard $(SRC_DIR)/*.c}
SRC_FILES := $(filter-out ${ENTRY_POINT}, $(SRC_FILES))
TEST_FILES = ${wildcard $(TEST_DIR)/*.c}
OBJ_NAME = play
TEST_OBJ_NAME = test
INCLUDE_PATHS = -Iinclude -I/usr/local/include -Itest_include
LIBRARY_PATHS = -Llib -L/usr/local/lib
COMPILER_FLAGS = -Wall -Wextra -Werror -O0 -std=c11 -g -fno-inline -fno-omit-frame-pointer
LINKER_FLAGS = -lSDL2 -lSDL2_image -lSDL2_ttf # -lSDL2_mixer -lSDL2_net


build:
	mkdir -p $(BUILD_DIR)
	$(CC) $(COMPILER_FLAGS) $(LINKER_FLAGS) $(INCLUDE_PATHS) $(LIBRARY_PATHS) $(SRC_FILES) ${ENTRY_POINT} -o $(BUILD_DIR)/$(OBJ_NAME)

test:
	$(CC) $(COMPILER_FLAGS) $(LINKER_FLAGS) $(INCLUDE_PATHS) $(LIBRARY_PATHS) $(SRC_FILES) $(TEST_FILES) -o $(BUILD_DIR)/$(TEST_OBJ_NAME)
	./$(BUILD_DIR)/$(TEST_OBJ_NAME)

clean:
	rm -rf $(BUILD_DIR)

all: clean build test

.PHONY: all build test clean
