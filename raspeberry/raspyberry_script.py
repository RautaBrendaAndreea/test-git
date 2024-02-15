import RPi.GPIO as GPIO
from time import sleep
import requests

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(8, GPIO.OUT, initial=GPIO.LOW)

# Ask server
token = "SECRET_TOKEN"
url = "https://domaine.random.com/"


payload = {'action': 'isOpen', 'token': token}
r = requests.get(url, params=payload)
print(r.text)

GPIO.output(8, GPIO.LOW)

try:
    while True:
        r = requests.get(url, params=payload)
        sleep(1)
        # If true, open the door
        if r.text == "true":
            GPIO.output(8, GPIO.HIGH)
finally:
    GPIO.output(8, GPIO.LOW)
    GPIO.cleanup()