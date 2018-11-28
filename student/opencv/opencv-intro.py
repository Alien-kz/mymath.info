import cv2
import numpy as np

import sys
cap = cv2.VideoCapture("file.mp4")
xslice = slice(800, 1200)
yslice = slice(200, 500)

for _ in range(70):
    ret, img1 = cap.read()
ret, img1 = cap.read()
src1 = img1[yslice, xslice]
frame1 = cv2.cvtColor(src1, cv2.COLOR_BGR2GRAY).astype(np.int8)

for i in range(10):
    ret, img2 = cap.read()
    src2 = img2[yslice, xslice]
    frame2 = cv2.cvtColor(src2, cv2.COLOR_BGR2GRAY).astype(np.int8)

    frame = frame1 - frame2
    frame = np.abs(frame)

    frame = frame.astype(np.uint8)

    mask = np.zeros_like(frame)
    np.putmask(mask, frame > 20, 255)

    out = src2
    out[:,:,1] = np.maximum(out[:,:,1], mask)

    frame1 = frame2

    cv2.imshow('Title', out)
    cv2.waitKey(100)
    cv2.imwrite("diff-" + str(i) + ".jpg", out)

