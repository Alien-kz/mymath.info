#include <iostream>
#include <algorithm>

int n, m, imax, imin, jmax, jmin, size;
bool used[101][101];
char matrix[101][101];
int di[] = {1, -1, 0, 0}, dj[] = {0, 0, 1, -1};

bool check(int i, int j) {
    return i >= 0 && i < n && j >= 0 && j < m &&
           matrix[i][j] == 'X' && not used[i][j];
}

void dfs(int i, int j) {
    used[i][j] = true;
    size++;
    imax = std::max(imax, i);
    imin = std::min(imin, i);
    jmax = std::max(jmax, j);
    jmin = std::min(jmin, j);
    for (int k = 0; k < 4; k++) {
        int nexti = i + di[k];
        int nextj = j + dj[k];
        if (check(nexti, nextj))
            dfs(nexti, nextj);
    }
}

int main() {
    int high = 0, wide = 0, square = 0;
    std::cin >> n >> m;
    for (int i = 0; i < n; i++)
        std::cin >> matrix[i];
    for (int i = 0; i < n; i++)
        for (int j = 0; j < m; j++) {
            imax = -1, imin = n;
            jmax = -1, jmin = m;
            size = 0;
            if (check(i, j)) {
                dfs(i, j);
                int height = imax - imin + 1;
                int width = jmax - jmin + 1;
                if (height * width == size) {
                    if (height > width)
                        high++;
                    if (height < width)
                        wide++;
                    if (height == width)
                        square++;
                }
            }
        }
    std::cout << high << ' ';
    std::cout << wide << ' ';
    std::cout << square;
    return 0;
}
