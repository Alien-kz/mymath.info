#include <iostream>
#include <algorithm>
using namespace std;
int main() {
    int n, c = 0, answer = 0, i, j;
    long long l[100000], r[100000], scanline = 0;
    cin >> n;
    for (int i = 0; i < n; i++)
        cin >> l[i] >> r[i];
    sort(l, l + n);
    sort(r, r + n);
    while (i < n && j < n) {
        scanline = min(l[i], r[j]);
        while (j < n && r[j] == scanline)
            j++, c--;
        while (i < n && l[i] == scanline)
            i++, c++;
        if (answer < c)
            answer = c;
    }
    cout << answer << '\n';
    return 0;
}
