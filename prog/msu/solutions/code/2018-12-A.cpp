#include <iostream>

int main() {
    int n1, n2, p, m, sum;
    char answer;

    std::cin >> n1 >> n2 >> p >> m;
    sum = (p - 1) / 2 * (n1 + n2);
    if (p % 2 == 0)
         sum += n1;
    sum += m;
    answer = 'A' + (sum - 1) % 7;

    std::cout << answer << std::endl;
    return 0;
}
