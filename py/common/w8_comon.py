#!/usr/bin/env python
# -*- coding: utf-8 -*-
import urlparse,socket

class w8_Common(object):
    @staticmethod
    def get(url):
        hh = hackhttp()
        try:
            code, head, body, redirect, log = hh.http(url)
        except Exception,e:
            print Exception,":",e;
            code,head,body,redirect,log = "","","","",""
        return code,head,body,redirect,log

    @staticmethod
    def urlget(url):
        return urllib.urlopen(url).read()

    @staticmethod
    #user-agent防止为空出现403
    def request_url(url='', data=None, header={'User-Agent':'Mozilla/5.0 (X11; U; Linux i686)Gecko/20071127 Firefox/2.0.0.11'}):
        page_content = ''
        request = urllib2.Request(url, data, header)

        try:
            response = urllib2.urlopen(request)
            page_content = response.read()
            #print page_content
        except Exception, e:
            pass

        return page_content

    @staticmethod
    def post(url,data):
        hh = hackhttp()
        try:
            code, head, body, redirect, log = hh.http(url,post=data)
        except Exception,e:
            print Exception,":",e;
            code,head,body,redirect,log = "","","","",""
        return code, head, body, redirect, log

    @staticmethod
    def getheaders(url):
        code, head, body, redirect, log = w8_Common.get(url)
        if code != 200:
            return 1
        heads = head.split('\n')
        strhead = ''
        for i in heads:
            if "Server" in i:
                strhead = i.strip()
            if "X-Powered-By" in i:
                strhead = strhead + " " +i.strip()
        return strhead

    @staticmethod
    def gettitle(url):
        code, head, body, redirect, log = w8_Common.get(url)
        if code != 200:
            return 1
        p = re.compile(r'<title>(.*)?</title>',re.I)
        title = p.findall(body)
        if(len(title)==1):
            return title[0]
        elif(len(title)>1):
            return title[0]
        return None


    @staticmethod
    def get_md5(html):
        m = hashlib.md5()
        m.update(html)
        md5 = m.hexdigest()
        return md5

    # A easy threading pool
    @staticmethod
    def thread(func, args, thr):
        '''[1] the func to run,[2] the func's args,[3] the thread nums'''
        q = Queue.Queue()
        t = []

        def start(q):
            while not q.empty():
                func(q.get())

        for a in args:
            q.put(a)
        for i in range(int(thr)):
            tt = threading.Thread(target=start, args=(q,))
            t.append(tt)
        for i in range(int(thr)):
            t[i].start()
        for i in range(int(thr)):
            # t[i].join(timeout=10)
            t[i].join()

    @staticmethod
    def gethostbyname(url):
        domain = urlparse.urlparse(url)
        # domain.netloc
        if domain.netloc is None:
            return None
        ip = socket.gethostbyname(domain.netloc)
        return ip