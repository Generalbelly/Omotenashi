FROM centos:centos6

MAINTAINER KoutatsuTakai

RUN cp -f /usr/share/zoneinfo/Japan /etc/localtime

# install
RUN yum install -y \
	epel-release \
	centos-release-SCL \
	wget \
	curl-devel \
	expat-devel \
	gettext-devel \
	openssl-devel \
	zlib-devel \
	perl-ExtUtils-MakeMaker \
	gcc \
	unzip \
	libxml2 \
	libxml2-devel \
	libxslt \
	libxslt-devel \
	xz

RUN rpm -ivh http://nginx.org/packages/centos/6/noarch/RPMS/nginx-release-centos-6-0.el6.ngx.noarch.rpm && \
		rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm

# install nginx
RUN yum install -y nginx
ADD ./nginx/default.conf /etc/nginx/conf.d/default.conf

# install git
WORKDIR /tmp/
RUN wget https://github.com/git/git/archive/v2.16.1.tar.gz && \
	tar -zxf v2.16.1.tar.gz

WORKDIR /tmp/git-2.16.1
RUN make prefix=/usr/local all && \
	make prefix=/usr/local install

# install php7
RUN yum -y install --enablerepo=remi,remi-php71 \
	php-cli \
	php-common \
	php-devel \
	php-fpm \
	php-gd \
  php-intl \
  php-json \
  php-mbstring \
  php-mcrypt \
  php-mysqlnd \
  php-pdo \
  php-soap \
  php-xml

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

# install libxl
WORKDIR /usr/lib64/
RUN wget http://www.libxl.com/download/libxl-lin-3.8.2.tar.gz && \
	tar -zxf libxl-lin-3.8.2.tar.gz

WORKDIR /usr/lib64/php/
RUN git clone https://github.com/iliaal/php_excel.git ext/excel

WORKDIR /usr/lib64/php/ext/excel
RUN git checkout php7 && \
	phpize && \
	./configure --with-excel --with-libxl-incdir=/usr/lib64/libxl-3.8.2.0/include_c --with-libxl-libdir=/usr/lib64/libxl-3.8.2.0/lib64 --with-libxml-dir=/usr/include/libxml2 && \
	make && \
	make install
ADD ./php/40-excel.ini /etc/php.d/40-excel.ini

# yarnそのもをインストール
RUN wget https://dl.yarnpkg.com/rpm/yarn.repo -O /etc/yum.repos.d/yarn.repo
RUN yum -y install yarn

# install npm
RUN rm -rf /usr/bin/node
WORKDIR /usr/lib64/
RUN wget https://nodejs.org/dist/v8.9.4/node-v8.9.4-linux-x64.tar.xz && \
	tar Jxfv node-v8.9.4-linux-x64.tar.xz && \
	ln -s /usr/lib64/node-v8.9.4-linux-x64/bin/node /usr/bin/node && \
	ln -s /usr/lib64/node-v8.9.4-linux-x64/lib/node_modules/npm/bin/npm-cli.js /usr/bin/npm && \
	ln -s /usr/lib64/node-v8.9.4-linux-x64/lib/node_modules/npm/bin/npx-cli.js /usr/bin/npx

VOLUME /var/www

EXPOSE 80

WORKDIR /root

# start
ADD ./start.sh /root/start.sh
CMD ["sh", "/root/start.sh"]
