#include <stdio.h>
#include <arpa/inet.h>   // inet_addr

int main()
{
    const char *string1 = "192.168.130.60";
    const char *string2 = "192.168.130.256"; // 非法IP，范围为0~255,

    in_addr_t network_address1 = inet_addr(string1);

    if (network_address1 == INADDR_NONE) {
        printf("错误");
    } else {
        // 结果是顺序是反的 网络字节序为：0x3c82a8c0
        printf("网络字节序为：%#x\n", network_address1);
    }

    in_addr_t network_address2 = inet_addr(string2);
    if (network_address2 == INADDR_NONE) {
        printf("错误");
    } else {
        printf("网络字节序为：%#x\n", network_address2);
    }

    return 0;
}
