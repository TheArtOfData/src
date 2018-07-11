import requests
import time
from random import randint

from data_up import Sender

#https://thingspeak.com/apps/matlab_visualizations/232659
#r = requests.get('https://api.thingspeak.com/update?api_key=BAIV4X4DYUCXI7D2&field1='+str(i)+'"', auth=('',''))
#payload = {'key1': 'value1', 'key2': 'value2'}

link = 'http://192.168.184.206/portalealloraspengo/api/data/data_in.php'
token = 'e3571a64d8e5dbe8a7a3c660e89d0e93'
x = Sender(link,token)

data = []
names = []
names.append('dato2')

for d in range(10000):
    i = randint(0,101)
    data.append(i)
    x.send(data,names)
    data = []
