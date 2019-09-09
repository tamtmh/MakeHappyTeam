# IMAGE: 801007122070.dkr.ecr.ap-northeast-1.amazonaws.com/make-happy-team
#
#
FROM centos:7.6.1810

# yum updates
RUN yum -y update &&  yum -y clean all

# timezone and locale
RUN yum -y reinstall glibc-common &&  yum -y clean all
RUN localedef -v -c -i ja_JP -f UTF-8 ja_JP.UTF-8; echo "";
ENV LANG=ja_JP.UTF-8
RUN rm -f /etc/localtime
RUN ln -fs /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# basic utilities
RUN yum -y install git zip unzip telnet postfix mail python-setuptools sudo vim tmux wget tar telnet && \
    yum -y clean all

RUN yum install -y epel-release && \
    rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

# supervisord
RUN easy_install supervisor

# awscli
RUN curl -skL https://bootstrap.pypa.io/get-pip.py | python && \
    pip install awscli

# cron
RUN yum install -y cronie-anacron && yum -y clean all && \
    cp -a /etc/pam.d/crond /etc/pam.d/crond.org && \
    sed -i -e 's/^\(session\s\+required\s\+pam_loginuid\.so\)/#\1/' /etc/pam.d/crond

# wget
RUN yum -y install wget

## ミドルウェアインストール
# Apache httpd 最新（現時点のversion:　2.4）
RUN yum -y install httpd httpd-tools mod_ssl openssl && \
	yum -y clean all
	# systemctl enable httpd.service

# PHP 7.3
RUN yum -y install epel-release gcc-c++ && \
    yum install -y --enablerepo=remi,remi-php73,epel php php-cli php-common php-devel php-mbstring php-pdo php-gd php-mysql php-mcrypt php-xml php-pear php-soap php-pecl-apcu php-mysqlnd && \
    yum -y clean all

# mysql client
RUN yum -y localinstall http://dev.mysql.com/get/mysql80-community-release-el7-3.noarch.rpm && \
    yum -y install mysql-community-client && \
    yum -y clean all && \
	mkdir /root/bin

# 拡張
ADD files/jq /root/bin/jq
ADD files/.bashrc /root/.bashrc
ADD files/.vimrc /root/.vimrc
ADD files/.vim /root/.vim

ENV HOME /root
RUN chmod +x /root/bin/jq

# config files (設定変更時のbuildコストを抑えるため最後に)
COPY files/etc/httpd/conf/httpd.conf /etc/httpd/conf/
# COPY files/etc/supervisord.conf /etc
# COPY files/etc/supervisord.d /etc
# RUN mkdir /var/log/supervisord && chmod ugo+w /var/log/supervisord
# ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
# CMD ["/usr/sbin/init"]

COPY files/startup.sh /startup.sh
RUN chmod 744 /startup.sh
