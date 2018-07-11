import requests
import json

class Sender:
    
    r = None
    lastException = None
    lastStatusCode = None
    par = {}#json obj
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
           
    def getStatusCode(self):
        return self.lastStatusCode

    def getLastException(self):
        return self.lastException

    def getToken(self):
        return self.token
    
    def getUrl(self):
        return self.r.url