#include <iostream>
#include <cstdlib>

int v[8][3], a, p, q, r;

int check(int i) {
    long long int s = v[i][0] * q * r +
                      p * v[i][1] * r +
                      p * q * v[i][2] -
                      p * q * r;
    if (s < 0)
        return -1;
    if (s > 0)
        return 1;
    return 0;
}

bool is_edge(int i, int j) {
    long long int s = 0;
    for (int k = 0; k < 3; k++)
        s += llabs(v[i][k] - v[j][k]);
    return s == a;
}

int main() {
    int ans = 0;
    std::cin >> a >> p >> q >> r;
    for (int i = 0; i < 8; i++)
        for (int k = 0; k < 3; k++)
            v[i][k] = a * ((i >> k) & 1);
    for (int i = 0; i < 7; i++)
        for (int j = i + 1; j < 8; j++)
            if (is_edge(i, j))
                if (check(i) * check(j) == -1)
                    ans++;
    for (int i = 0; i < 8; i++)
        if (check(i) == 0)
            ans++;
    std::cout << ans;
    return 0;
}
