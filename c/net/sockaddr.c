#include <stdio.h>
#include <string.h>      // memset
#include <arpa/inet.h>   // sockaddr_in

int main(int argc, char *argv[])
{
    const char *server_ip = "127.0.0.1"; // 本机IP地址字符串
    int server_port = 0x1234; // 端口号

    struct sockaddr_in address;
    memset(&address, 0, sizeof(address));

    address.sin_family = AF_INET;  // 地址族，IPv4
    address.sin_port = htons(server_port); // 端口赋值
    address.sin_addr.s_addr = inet_addr(server_ip); // IP地址赋值

    printf("端口网络字节序：%#x\n", address.sin_port);  // 端口网络字节序：0x3412
    printf("IP地址网络字节序：%#x\n", address.sin_addr.s_addr);  // IP地址网络字节序：0x100007f
    return 0;
}
