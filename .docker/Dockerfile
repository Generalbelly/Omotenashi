FROM amazonlinux:2

LABEL maintainer "nshimmen"

RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

RUN yum update -y

RUN yum install -y \
    initscripts \
    sudo \
    git \
    zip \
    unzip \
    tar \
    httpd \
    wget \
    less \
    libxslt \
    automake \
    autoconf \
    mysql \
    libmcrypt \
    libtool-ltdl \
    which \
    gcc gcc-c++ \
    net-tools

# install php7.2 nginx
RUN amazon-linux-extras install php7.2 nginx1.12

RUN yum install -y --disablerepo=amzn-main,amzn-updates --enablerepo=remi,remi-php72 \
    php-devel \
    php-mbstring \
    php-xml

RUN rm -f /etc/nginx/default.d/php.conf
ADD ./nginx/default.conf /etc/nginx/conf.d/default.conf

RUN mkdir /var/lib/php/session_nginx && \
    chown root.nginx /var/lib/php/session_nginx && \
    chmod 0775 /var/lib/php/session_nginx

RUN mkdir /var/lib/php/wsdlcache_nginx && \
    chown root.nginx /var/lib/php/wsdlcache_nginx && \
    chmod 0775 /var/lib/php/wsdlcache_nginx

RUN mkdir /var/lib/php/opcache_nginx && \
    chown root.nginx /var/lib/php/opcache_nginx && \
    chmod 0775 /var/lib/php/opcache_nginx

ADD ./php-fpm/www.conf /etc/php-fpm.d/www.conf
ADD ./php/php.ini /etc/php.ini

ADD ./certs/localhost+1-key.pem  /etc/ssl/certs/localhost+1-key.pem
ADD ./certs/localhost+1.pem  /etc/ssl/certs/localhost+1.pem

RUN chown -R root:nginx /var/log/nginx
RUN chmod -R 770 /var/log/nginx/

# node and npm
RUN curl -sL https://rpm.nodesource.com/setup_10.x | bash -
RUN yum -y install nodejs
RUN yum -y install gcc-c++ make

# yarn
RUN wget https://dl.yarnpkg.com/rpm/yarn.repo -O /etc/yum.repos.d/yarn.repo
RUN yum -y install yarn

RUN systemctl enable nginx.service
RUN systemctl enable php-fpm.service

EXPOSE 80

WORKDIR /root

# start
ADD ./start.sh /root/start.sh
CMD ["sh", "/root/start.sh"]
