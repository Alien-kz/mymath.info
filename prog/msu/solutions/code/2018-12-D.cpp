#include <iostream>
using namespace std;
int main() {
    double a, b;
    int aa, bb, answer[2][2] = {{"red", "white"},
                                {"blue", "green"}};
    cin >> a >> b;
    aa = a, bb = b;
    double fracsum = (a - aa) + (b - bb);
    int i = (aa % 2 == bb % 2);
    int j = ((aa % 2 == 0) ^ (fracsum < 1.0));
    cout << answer[i][j] << '\n';
    return 0;
}
