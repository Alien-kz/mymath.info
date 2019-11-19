#include <stdio.h>

#include <unistd.h>
#include <netdb.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>

int main() {
    //open socket, result is socket descriptor
    int server_socket = socket(PF_INET, SOCK_STREAM, 0);
 
    //set socket option
    int socket_option = 1;
    setsockopt(server_socket, 
               SOL_SOCKET, 
               SO_REUSEADDR, 
               &socket_option, 
               sizeof(socket_option));

    //set socket address
    struct sockaddr_in server_address;
    server_address.sin_family = AF_INET;
    server_address.sin_port = htons(8080);
    server_address.sin_addr.s_addr = INADDR_ANY;
    bind(server_socket, 
         (struct sockaddr *) &server_address, 
         sizeof(server_address));

    //listen mode start
    listen(server_socket, 5);

    while(1) {
        puts("Wait for connection");
        struct sockaddr_in client_address;
        socklen_t size;
        int client_socket = accept(server_socket, 
                                   (struct sockaddr *) &client_address,
                                   &size);
        printf("connected: %s %d\n", inet_ntoa(client_address.sin_addr),
                                     ntohs(client_address.sin_port));
        char data[4] = {42, 43, 44, 45};
        write(client_socket, data, 42);
        close(client_socket);
    }


    return 0;
}
