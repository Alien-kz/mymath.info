#include <iostream>
#include <algorithm>

int a[100000];
int L[100000];
int R[100000];

int main() {
    int n;
    std::cin >> n;
    for (int i = 0; i < n; i++)
        std::cin >> a[i];
    for (int i = 1; i < n; i++)
        if (a[i - 1] < a[i])
            L[i] = L[i - 1] + 1;
    for (int i = n - 2; i >= 0; i--)
        if (a[i] > a[i + 1])
            R[i] = R[i + 1] + 1;
    int ans = 1, start = 0, end = 0;
    for (int i = 1; i < n - 1; i++) {
        int w = std::min(L[i], R[i]);
        int len = 2 * w + 1;
        if (ans < len) {
            ans = len;
            start = i - w;
            end = i + w;
        }
    }
    std::cout << start + 1 << ' ' << end + 1;
    return 0;
}
