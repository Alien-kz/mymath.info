#include <iostream>
#include <cstdlib>

long long gcd(long long a, long long b) {
    if (b == 0) {
        return a;
    }
    return gcd(b, a % b);
}

int main() {
    long long i1, j1, i2, j2, a, b, d, ans;
    std::cin >> i1 >> j1 >> i2 >> j2;
    a = llabs(i1 - i2);
    b = llabs(j1 - j2);
    ans = a + b + 1;
    d = gcd(a, b);
    a /= d;
    b /= d;
    if (a % 2 == 1 && b % 2 == 1)
        ans -= d;
    std::cout << ans;
    return 0;
}
