#include <stdio.h>
#include <stdlib.h>

int * find_max_crossing_subarray(int data[], int low, int mid, int high);
int * find_maximum_subarray(int data[], int low, int high);
int * get_int_pointer(int value, int start, int end);

const int MINIMUM = -100;

int main() {
    int data[] = {13, -3, -25, 20, -3, -16, -23, 18, 20, -7, 12, -5, -22, 15, -4, 7};
    int count = sizeof(data)/sizeof(int);
    int low = 0, high = count - 1;
    int *result = find_maximum_subarray(data, low, high);
    printf("The maximum subarray start index is %d, end index is %d, sum is %d", result[1], result[2], result[0]);
    printf("\n");
    return 0;
}

int * find_max_crossing_subarray(int data[], int low, int mid, int high) {
    int left_sum = MINIMUM, right_sum = MINIMUM;
    int max_left = mid, max_right = mid + 1, sum = 0, i = mid;
    for (; i >= low; i--) {
        sum = sum + data[i];
        if (sum > left_sum) {
            left_sum = sum;
            max_left = i;
        }
    }
    sum = 0;
    i = mid + 1;
    for (; i < high; i++) {
        sum = sum + data[i];
        if (sum > right_sum) {
            right_sum = sum;
            max_right = i;
        }
    }

    return get_int_pointer(left_sum + right_sum, max_left, max_right);;
}

int * find_maximum_subarray(int data[], int low, int high) {
    int * result;
    if (low == high) {
        result = get_int_pointer(data[low], low, high);
    } else {
        int mid = (low + high) / 2;
        int *left_result, *right_result, *mid_result;
        left_result = find_maximum_subarray(data, low, mid);
        right_result = find_maximum_subarray(data, mid + 1, high);
        mid_result = find_max_crossing_subarray(data, low, mid, high);

        if(left_result[0] >= right_result[0] && left_result[0] >= mid_result[0]) {
            result = left_result;
            free(right_result);
            free(mid_result);
        } else if (right_result[0] >= left_result[0] && right_result[0] >= mid_result[0]) {
            result = right_result;
            free(left_result);
            free(mid_result);
        } else {
            result = mid_result;
            free(left_result);
            free(right_result);
        }
    }

    return result;
}

int * get_int_pointer(int value, int start, int end) {
    int * result = (int *)malloc(sizeof(int) * 3);
    result[0] = value;
    result[1] = start;
    result[2] = end;
    return result;
}
