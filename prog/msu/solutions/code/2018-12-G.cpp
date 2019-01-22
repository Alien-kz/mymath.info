#include <iostream>
#include <algorithm>
#include <iomanip>

using namespace std;

int main() {
    int len = 42;
    long long k, decpow = 1;
    cin >> k;
    for (int i = 0; i < len - 1; i++)
        decpow = decpow * 10 % k;
    long long m = (k - decpow) % k;
    cout << 1 << setw(len - 1) << setfill('0') << m;
    return 0;
}
