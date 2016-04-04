#include <stdio.h>

void quick_sort(int data[], int p, int r);
int partition(int data[], int p, int r);

int main() {
    int data[] = {0, 4, 1, 3, 2, 16, 9, 10, 14, 8, 7};
    int count = sizeof(data)/sizeof(int);

    quick_sort(data, 0, count - 1);

    int i = 0;
    for(; i < count; i++)
        printf("%d\t", data[i]);
    printf("\n");
    return 0;
}

void quick_sort(int data[], int p, int r)
{
    if (p < r) {
        int q = partition(data, p , r);
        quick_sort(data, p, q - 1);
        quick_sort(data, q + 1, r);
    }
}

int partition(int data[], int p, int r)
{
    int x = data[r], i = p - 1, j = p, temp;
    for (; j < r; j++) {
        if (data[j] > x) {
            i++;
            temp = data[j];
            data[j] = data[i];
            data[i] = temp;
        }
    }

    i++;
    data[r] = data[i];
    data[i] = x;
    return i;
}
