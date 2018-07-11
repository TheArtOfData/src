<?php
// TheArtOfData
//    Copyright (C) 2018  by Anceschi Giovanni, Belmonte Luca, Boschini Matteo, Mechetti Luca, Monari Pietro, Scarfone Salvatore, Tardini Giovanni
//
//    Mail : theartofdat@gmail.com
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as published
//    by the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.

// output headers so that the file is downloaded rather than displayed


//specifying column separator

if(!isset($_GET['channel_token']) || !isset($_GET['type_data'])) return ;

$token_channel = $_GET['channel_token'];
$type_data = explode(',', $_GET['type_data']);

$type_array = '';
$data_array = '';

foreach ($type_data as $key => $value){
  $type_array .= "'{$value}', ";
  $data_array .= "your_data" . ($key + 1) . ", ";
}


$type_array = substr($type_array, 0, strlen($type_array) - 2);
$data_array = substr($data_array, 0, strlen($data_array) - 2);



header('Content-Type: text/py; charset=utf-8');
header('Content-Disposition: attachment; filename=send_data.py');

$tit = <<<EOF
'''TheArtOfData
Copyright (C) 2018  by Anceschi Giovanni, Belmonte Luca, Boschini Matteo, Mechetti Luca, Monari Pietro, Scarfone Salvatore, Tardini Giovanni

Mail : theartofdat@gmail.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published
by the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.'''

import requests #already embedded in python 3
import time #you can use it to add a delay between each data sending request
import json
from random import randint

class Sender:

    r = None 
    lastException = None
    lastStatusCode = None
    par = {} #json object for the data
    sep = ','

    def __init__(self,link,token):
        self.link = link
        self.token = token

    def send(self,data,names):
        self.par['channel_token']=self.token
        self.par['values']=self.sep.join(map(str,data))
        self.par['types']=self.sep.join(map(str,names))
        try:
            self.r = requests.get(self.link, params = self.par)
            self.lastStatusCode = self.r.status_code
        except requests.exceptions.RequestException as e:
            self.lastException = e

    #you can use this method to check if the request was successfull (200 --> ok)
    def getStatusCode(self):
        return self.lastStatusCode

    #you can use this method to see if there's been any exception 
    def getLastException(self):
        return self.lastException

    def getToken(self):
        return self.token

    def getUrl(self):
        return self.r.url

#your channel token 
token = '{$token_channel}'

#sender object
sender = Sender('https://theartofdata.tech/api/data/data_in.php',token)

#your array of data
#replace your_dataN with the data you want to send to the channel.
data = [{$data_array}]

#your array of data types (names)
names = [{$type_array}]

#this sends the whole arrays to the channel
sender.send(data,names)


'''You could also insert/modify your code. For example, you can
append the data that your sensor are measuring inside the 'data' array. You can also add a delay
between each data sending request with the time.sleep('time in seconds') function.
Don't forget to specify what type of data you are sending inside the names array (for each value you add into the array). 

Example:
#in this example we send one data at a time

#our imaginary sensor
humiditysensor = Sensor() 

#this goes on until you manually stop the script from running
while 1: 

	#get the value detected from the sensor		
	value = humiditysensor.getValue() 

	#append the value to the array
	data.append(value)

	#append the data name to the array
	names.append("Umidita") 

	#here we send the arrays containing only one value
	sender.send(data,names) 

	#here we print the status code and last thrown exception to check that everything went fine
	print("status code: "+sender.getStatusCode())
	print("exception: "+sender.getLastException())

	#here we add a 20 seconds delay
    time.sleep(20) 
    
    #then we reset the data and names arrays
    data = []
    names = []

''' 

EOF;

    define('sep', ';');

    $output = fopen('php://output', 'r+');
    fwrite($output,$tit);
    fclose($output);

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');



?>
