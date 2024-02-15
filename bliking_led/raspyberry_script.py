import RPi.GPIO as GPIO
from time import sleep

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(10, GPIO.OUT, initial=GPIO.LOW)

try:
    while True:
        sleep(1)
        GPIO.output(10, GPIO.HIGH)
        sleep(1)
        GPIO.output(10, GPIO.LOW)
finally:
    GPIO.output(10, GPIO.LOW)
    GPIO.cleanup()