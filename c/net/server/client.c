#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <arpa/inet.h>   // sockaddr_in
#include <sys/socket.h>

int main()
{
    const char *server_ip = "127.0.0.1";
    int server_port = 0x1234;
    int client_socket;

    client_socket = socket(PF_INET, SOCK_STREAM, 0);
    if (client_socket == -1) {
        perror("socket create error");
        exit(1);
    }
    printf("client_socket is %d\n", client_socket);

    struct sockaddr_in server_addr;  // server address
    memset(&server_addr, 0, sizeof(server_addr));
    server_addr.sin_family = AF_INET;
    server_addr.sin_port = htons(server_port);
    server_addr.sin_addr.s_addr = inet_addr(server_ip);

    if (connect(client_socket, (struct sockaddr*)&server_addr, sizeof(server_addr)) == -1) {
        perror("connect error");
        exit(1);
    }
    printf("connect ok\n");

    char recv_message[100];
    int length = recv(client_socket, recv_message, 100, 0);
    recv_message[length] = '\0';
    printf("Receive form server: %s\n", recv_message);

    close(client_socket);

    return 0;
}
