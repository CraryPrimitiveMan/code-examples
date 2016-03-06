#include <stdio.h>

void insertion_sort(int data[], int count);

int main() {
    int data[] = {10, 12, 9, 17, 19, 2, 7, 1};
    int count = sizeof(data)/sizeof(int);

    insertion_sort(data, count);

    int i = 0;
    for(; i < count; i++)
        printf("%d\t", data[i]);
    printf("\n");
    return 0;
}

void insertion_sort(int data[], int count) {
    int j = 1;
    for (; j < count; j++) {
        int key = data[j];
        int i = j - 1;
        while (i >= 0 && data[i] > key) {
            data[i + 1] = data[i];
            i = i - 1;
        }
        data[i + 1] = key;
    }
}
