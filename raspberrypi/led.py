# -*- coding: utf-8 -*-
import serial


def main():

    ser = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
    ser.write('b1')
    ser.close()

# -----------------------
if __name__ == '__main__':
    main()

