#include <iostream>
#include <iomanip>
using namespace std;

int main() {
    double x, ans;
    cin >> x;
    ans = 2.0 * x + 12.0 / x;
    cout << fixed << setprecision(6) << ans;
    return 0;
}
