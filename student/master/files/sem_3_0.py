# coding: utf-8

# Коэффициент диффузии
C = 0.1
# Время счета
T = 1.0
# Число траекторий
n = 50
# Число шагов по времени
m = 10
tau = T / m

# Счет траекторий
import numpy
t = [k * tau for k in range(m)]
x = [None] * n
for i in range(n):
	x[i] = [0.5] * m
for k in range(m - 1):
	for i in range(n):
		x[i][k + 1] = x[i][k] + C * tau**0.5 * numpy.random.normal()

# Вывод траекторий
from matplotlib import pylab as plt
plt.figure(0)
for i in range(n):
	lines = plt.plot(t, x[i])
plt.show()

# Функция плотности
def make_hist(x_list):
	H = 8
	hist = [0] * H
	for x in x_list:
		if (x >= 0) and (x <= 1):
			index = int(x * H)
			hist[index] += 1
	return hist

x_last = [x[i][m - 1] for i in range(n)]
hist = make_hist(x_last)

# Вывод функции плотности
plt.figure(1)
lines = plt.plot(hist)
plt.show()
