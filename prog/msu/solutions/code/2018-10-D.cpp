#include <iostream>
#define mod 1000
typedef int Matrix[2][2];

void matr_mult(Matrix A, Matrix B, Matrix C) {
    for (int i = 0; i < 2; i++)
        for (int j = 0; j < 2; j++) {
            C[i][j] = 0;
            for (int k = 0; k < 2; k++)
                C[i][j] += A[i][k] * B[k][j];
                C[i][j] %= mod;
        }
}

void matr_power(Matrix A, long long n, Matrix B) {
    if (n == 0) {
        B[0][0] = 1; B[0][1] = 0;
        B[1][0] = 0; B[1][1] = 1;
        return;
    }
    int half[2][2], half2[2][2];
    matr_power(A, n / 2, half);
    if (n % 2 == 1) {
        matr_mult(half, half, half2);
        matr_mult(half2, A, B);
    } else 
        matr_mult(half, half, B);
}

int main() {
    long long a, b, n;
    std::cin >> a >> b >> n;
    a %= mod;
    b %= mod;
    int m11 = 2 * a % mod;
    int m12 = (b - a * a % mod + mod) % mod;
    Matrix A = {{m11, m12}, {1, 0}}, B;
    matr_power(A, n, B);
    int x0 = 2;
    int x1 = 2 * a % mod;
    int ans = (B[1][0] * x1 + B[1][1] * x0) % mod;
    std::cout << ans;
    return 0;
}
