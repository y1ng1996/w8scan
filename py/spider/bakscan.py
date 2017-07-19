#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Name:基于爬虫扫描备份
# Descript:对爬虫获取的网站枚举后缀 .zip .bak 等等爆破出备份进行下载
import sys
import urlparse

DIR_PROBE_EXTS = ['.tar.gz', '.zip', '.rar', '.tar.bz2']
FILE_PROBE_EXTS = ['.bak', '.swp', '.1']

def get_parent_paths(path):
    paths = []
    if not path or path[0] != '/':
        return paths
    paths.append(path)
    tph = path
    if path[-1] == '/':
        tph = path[:-1]
    while tph:
        tph = tph[:tph.rfind('/')+1]
        paths.append(tph)
        tph = tph[:-1]
    return paths

def run(url='',body=''):
    pr = urlparse.urlparse(url)
    paths = get_parent_paths(pr.path)
    web_paths = []
    for p in paths:
        if p == "/":
            for ext in DIR_PROBE_EXTS:
                u = '%s://%s%s%s' % (pr.scheme, pr.netloc, p, pr.netloc+ext)
        else:
            if p[-1] == '/':
                for ext in DIR_PROBE_EXTS:
                    u = '%s://%s%s%s' % (pr.scheme, pr.netloc, p[:-1], ext)
            else:
                for ext in FILE_PROBE_EXTS:
                    u = '%s://%s%s%s' % (pr.scheme, pr.netloc, p, ext)
        web_paths.append(u)
    for path in web_paths:
        print "[bakscan]:%s"%path
        code,head,body,redirect,log = w8_Common.get(path)
        if code == 200:
            print "[+] bak file has found :%s"%path
            report.add_list("bakfile_scan",path)
    
    return False