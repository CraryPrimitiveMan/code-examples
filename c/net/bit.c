#include <stdio.h>
#include <netinet/in.h>

int main()
{
    unsigned short host_port = 0x1234;
    unsigned long host_address = 0x12345678;

    unsigned short netword_port = htons(host_port);
    unsigned long netword_address = htonl(host_address);

    printf("主机字节序(short) = %#x\n", host_port);          // 主机字节序(short) = 0x1234
    printf("网络字节序(short) = %#x\n", netword_port);       // 网络字节序(short) = 0x3412

    printf("主机字节序(long) = %#lx\n", host_address);       // 主机字节序(long) = 0x12345678
    printf("网络字节序(long) = %#lx\n", netword_address);    // 网络字节序(long) = 0x78563412
    return 0;
}
