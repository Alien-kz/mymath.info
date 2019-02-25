import numpy as np

def f(x):
    return np.exp(-x*x/4)

mu = 1.0
T = 2.0

L, R = -10.0, 10.0
n = 40
m = 40
h = (R - L) / n
tau = T / m

x = np.linspace(L, R, n + 1)
t = np.linspace(0.0, T, m + 1)

y = np.zeros((m + 1, n + 1))
s = np.vectorize(f)(x)

y[0] = s
for k in range(m):
    for i in range(1, n):
        y[k+1][i] = y[k][i] + mu * tau / (h * h) * (y[k][i-1] - 2 * y[k][i] + y[k][i+1])



def solution(x, t):
    return 1 / np.sqrt(t + 1) * np.exp(- x * x / 4 / (t + 1))

vsolution = np.vectorize(solution, excluded=['t'])
u = np.zeros((m + 1, n + 1))
for k in range(m):
	u[k] = vsolution(x, tau * k)

import matplotlib.pyplot as plt
import matplotlib.animation as animation

def animate(k):
    plt.clf()
    plt.ylim(0, 1)
    plt.xlabel("x")
    plt.title("layer = " + str(k) + ", time = " + str("{:4.2}".format(tau * k)))
    plt.plot(x, y[k], marker='o')
    plt.legend("Numerical")
    plt.plot(x, u[k], marker='*')
    plt.legend("Analytical")
    if k == m or k == 0:
        print(k)
        for z in zip(x, y[k]):
            print("({0:5.2f}, {1:5.2f})".format(z[0], z[1]))

fig = plt.figure(0)
ani = animation.FuncAnimation(fig, animate, frames=y.shape[0], interval=10)
ani.save('diffusion.mp4')
plt.show()

