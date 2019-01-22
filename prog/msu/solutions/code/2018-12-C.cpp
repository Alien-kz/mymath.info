#include <iostream>
#include <cstring>

using namespace std;

bool check(char mask[], int n, int k) {
    for (int i = 0; i < n; i++) {
        int bit = (k >> (n - 1 - i)) & 1;
        if (mask[i] != '?' && mask[i] != bit)
            return false;
    }
    return true;
}

int main() {
    char s[20];
    int n;
    cin >> s;
    n = strlen(s);
    for (int i = 0; i < n; i++)
        s[i] -= '0';
    for (int k = 0; k < (1 << n); k++)
        if (check(s, n, k))
            cout << k << '\n';
    return 0;
}
