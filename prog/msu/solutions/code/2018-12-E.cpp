#include <iostream>
#include <cstdlib>

using namespace std;

int main() {
    int n;
    long long a[100000], sum = 0, left = 0, right = 0;
    cin >> n;
    for (int i = 0; i < n; i++) {
        cin >> a[i];
        sum += a[i];
    }
    right = sum;
    left = 0;
    for (int i = 0; i < n; i++) {
        right -= a[i];
        long long value = llabs(right - left);
        if (ans == -1 || ans > value)
            ans = value;
        left += a[i];
    }
    long long ans = -1;
    right = sum;
    left = 0;
    for (int i = 0; i < n; i++) {
        right -= a[i];
        long long value = llabs(right - left);
        if (ans == value)
            cout << i + 1 << ' ';
        left += a[i];
    }
    cout << '\n';
    return 0;
}
