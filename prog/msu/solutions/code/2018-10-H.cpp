#include <iostream>
#define mod 1000000007

long long f(long long n, int k) {
    int d[20];
    int len = 0;
    while (n > 0) {
        d[len++] = n % 10;
        n /= 10;
    }
    for (int i = len - 1; i >= 0; i--)
        if (d[i] > k)
            for ( ; i >= 0; i--)
                d[i] = k;
    long long answer = 0LL;
    for (int i = len - 1; i >= 0; i--)
        answer = answer * (k + 1) + d[i];
    return answer;
}

long long g(long long n, int k) {
    return (f(n, k) - f(n, k - 1) + mod) % mod;
}

long long sum(long long n) {
    long long ans = 0;
    for (int k = 1; k <= 9; k++) {
        ans += k * g(n, k);
        ans %= mod;
    }
    return ans;
}

int main() {
    long long L, R;
    std::cin >> L >> R;
    std::cout << (sum(R) - sum(L - 1) + mod) % mod;
    return 0;
}
