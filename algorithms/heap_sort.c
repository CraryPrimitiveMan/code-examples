#include <stdio.h>
#include <math.h>

#define PARENT(i) floor(i/2)
#define LEFT(i) (2 * i)
#define RIGHT(i) (2 * i + 1)

void heap_sort(int data[], int count);
void build_max_heap(int data[], int count);
void max_heapify(int data[], int i, int heap_size);

int main() {
    int data[] = {0, 4, 1, 3, 2, 16, 9, 10, 14, 8, 7};
    int count = sizeof(data)/sizeof(int);

    heap_sort(data, count - 1);

    int i = 1;
    for(; i < count; i++)
        printf("%d\t", data[i]);
    printf("\n");
    return 0;
}

void heap_sort(int data[], int count) {
    build_max_heap(data, count);
    int heap_size = count;
    int i = count;
    for (; i > 1; i--) {
        int temp = data[i];
        data[i] = data[1];
        data[1] = temp;
        heap_size--;
        max_heapify(data, 1, heap_size);
    }
}

void build_max_heap(int data[], int count) {
    int i = floor(count / 2);
    for (; i >= 1; i--) {
        max_heapify(data, i, count);
    }
}

void max_heapify(int data[], int i, int heap_size) {
    int l = LEFT(i), r = RIGHT(i), largest;
    if (l <= heap_size && data[l] > data[i]) {
        largest = l;
    } else {
        largest = i;
    }
    if (r <= heap_size && data[r] > data[largest]) {
        largest = r;
    }

    if (i != largest) {
        int temp = data[i];
        data[i] = data[largest];
        data[largest] = temp;
        max_heapify(data, largest, heap_size);
    }
}
