#include <stdio.h>
#include <stdlib.h>      // exit
#include <string.h>
#include <arpa/inet.h>   // sockaddr_in
#include <sys/socket.h>

int main(int argc, char *argv[])
{
    const char *server_ip = "127.0.0.1"; // IP地址字符串
    int server_port = 0x1234;
    int server_socket;

    server_socket = socket(PF_INET, SOCK_STREAM, 0);
    if (server_socket == -1) {
        perror("socket create error");
        exit(1);
    }
    printf("socket is %d\n", server_socket);

    struct sockaddr_in address;
    memset(&address, 0, sizeof(address));
    address.sin_family = AF_INET;
    address.sin_port = htons(server_port);
    address.sin_addr.s_addr = inet_addr(server_ip);

    if (bind(server_socket, (struct sockaddr*)&address, sizeof(address)) == -1) {
        perror("bind error");
        exit(1);
    }
    printf("bind ok\n");

    if (listen(server_socket, 5) == -1) {
        perror("listen error");
        exit(1);
    }
    printf("accept ok\n");

    close(connfd);
    close(server_socket);

    return 0;
}
