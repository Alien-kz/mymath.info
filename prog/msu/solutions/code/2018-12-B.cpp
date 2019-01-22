#include <iostream>
#include <algorithm>

using namespace std;

int find(int n, int a[], int floor) {
    int dist = 2e9;
    if (floor <= a[0])
        return a[0] - floor;
    if (floor >= a[n - 1])
        return floor - a[n - 1];
    for (int i = 0; i + 1 < n; i++)
        if (a[i] <= floor && floor < a[i + 1]) {
            int current = min(floor - a[i],
                              a[i + 1] - floor);
            dist = min(dist, current);
        }
    return dist;
}

int main() {
    int n, p, q;
    int a[100000];
    cin >> p >> q >> n;
    for (int i = 0; i < n; i++)
        cin >> a[i];
    int nolift = abs(p - q);
    int plift = find(n, a, p);
    int qlift = find(n, a, q);
    cout << min(nolift, plift + qlift) << endl;
    return 0;
}
