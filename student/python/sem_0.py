# coding: utf-8

# Начальные условия $u_0(x)$
def u0(x):
	return 1.0 - (x - 0.5)**2

# Граничные условия $\varphi_1(x)$, $\varphi_2(x)$
def phi1(t):
	return 0.0
def phi2(t):
	return 0.0

# Параметры задачи: $\mu$ - коэффициент теплопроводности, $T$ - время искомого распределения температуры
mu = 0.1
T = 1.0

# Сетка по пространству
n = 10
h = 1.0 / n
x = [i * h for i in range(0, n + 1)]

# Сетка по времени
m = 50
tau = T / m
t = [k * tau for k in range(0, m + 1)]

# Условие устойчивости
r = 2 * mu * tau / h / h
print(tau, h, r)

# Инициализация начального слоя
y = [u0(x[i]) for i in range(0, n + 1)]
for i in range(0, n + 1):
	y[i] = u0(x[i])

# Счет
ynew = [0] * (n + 1)
for k in range(0, m):
	y[0] = phi1(t[k])
	y[n] = phi2(t[k])
	for i in range(1, n):
		ynew[i] = y[i] + tau * mu / h / h * (y[i+1] - 2 * y[i] + y[i-1])
	y = list(ynew)

# Вывод
print(x)
print(y)

# График
from matplotlib import pylab as plt
plt.plot(x, y)
plt.show()
