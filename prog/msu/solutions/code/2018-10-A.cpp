#include <iostream>

int main() {
    int x, y, ans;
    std::cin >> x >> y;
    if (y == 0)
        if (x >= 0)
            ans = 0;
        else
            ans = 3;
    else
        if (x > 0)
            ans = 1;
        else
            ans = 2;
    std::cout << ans;
    return 0;
}
