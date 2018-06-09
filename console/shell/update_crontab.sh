#!/bin/bash

#更新阿里云脚本机 定时任务
#更新: ./update-crontab.sh

#更新crontab
/usr/bin/crontab /data/www/jelly/console/shell/crontab_scrip
#kill 老服务
ps -aux | grep -v grep | grep 'crond start' | awk {'print "kill -9 " $2'} | /bin/bash
#重新启动
crond start