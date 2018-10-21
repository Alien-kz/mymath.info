#include <iostream>

int main() {
    const int n = 16;
    char a[n][n], b[n][n];
    int right = 0;
    for (int i = 0; i < n; i++)
        for (int j = 0; j < n; j++) {
            std::cin >> a[i][j];
            if (a[i][j] == 'R')
                right = 1;
        }
    for (int i = 0; i < n; i++)
        for (int j = 0; j < n; j++)
            if (right)
                b[i][j] = a[n - 1 - j][i];
            else
                b[i][j] = a[j][n - 1 - i];
    for (int i = 0; i < n; i++) {
        for (int j = 0; j < n; j++)
            std::cout << b[i][j];
        std::cout << std::endl;
    }
    return 0;
}
