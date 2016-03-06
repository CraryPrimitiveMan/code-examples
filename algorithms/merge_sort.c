#include <stdio.h>
#include <stdlib.h>

void merge_sort(int data[], int start, int end);
void merge(int data[], int start, int middle, int end);

int main() {
    int data[] = {10, 12, 29, 17, 19, 2, 7, 1};
    int count = sizeof(data)/sizeof(int);

    merge_sort(data, 0, count - 1);

    int i = 0;
    for(; i < count; i++)
        printf("%d\t", data[i]);
    printf("\n");
    return 0;
}

void merge_sort(int data[], int start, int end) {
    if (start < end) {
        int middle = (start + end) / 2;
        merge_sort(data, start, middle);
        merge_sort(data, middle + 1, end);
        merge(data, start, middle, end);
    }
}

void merge(int data[], int start, int middle, int end) {
    int leftLen = middle - start + 1;
    int rightLen = end - middle;
    int *left = (int *) malloc (leftLen * sizeof(int));
    int *right = (int *) malloc (rightLen * sizeof(int));

    int i = start, j = middle + 1;
    for (; i <= middle; i++) {
        left[i - start] = data[i];
    }
    for (; j <= end; j++) {
        right[j - middle - 1] = data[j];
    }

    int k = start, leftPostion = 0, rightPostion = 0;
    while (leftPostion < leftLen && rightPostion < rightLen) {
        if (left[leftPostion] <= right[rightPostion]) {
            data[k++] = left[leftPostion++];
        } else {
            data[k++] = right[rightPostion++];
        }
    }

    while (leftPostion < leftLen) {
        data[k++] = left[leftPostion++];
    }
    while (rightPostion < rightLen) {
        data[k++] = right[rightPostion++];
    }
}
