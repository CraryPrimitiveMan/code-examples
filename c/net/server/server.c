#include <stdio.h>
#include <sys/socket.h>
#include <string.h>
#include <stdlib.h>
#include <arpa/inet.h>   // sockaddr_in
#include <unistd.h>
#include <time.h>

int main()
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

    struct sockaddr_in client_addr;
    socklen_t client_addr_len = sizeof(client_addr);

    while (1)
    {
        printf("等待连接中...\n");
        int connfd = accept(server_socket, (struct sockaddr*)&client_addr, &client_addr_len);  // connect socket

        if (connfd == -1) {
            perror("accept error");
            exit(1);
        }
        printf("accept ok\n");

        printf("connect from %s:%d\n", inet_ntoa(client_addr.sin_addr), ntohs(client_addr.sin_port));

        char time_message[100];
        time_t now_time = (time_t)time(NULL);
        snprintf(time_message, sizeof(time_message), "%.24s\n", ctime((const time_t*)&now_time));

        send(connfd, time_message, sizeof(time_message), 0);

        close(connfd);
    }

    close(server_socket);

    return 0;
}
