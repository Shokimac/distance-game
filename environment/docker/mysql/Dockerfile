FROM mysql:8-debian
RUN apt-get update
RUN apt-get -y install locales-all
ENV LANG ja_JP.UTF-8
ENV LANGUAGE ja_JP:ja
ENV LC_ALL ja_JP.UTF-8
COPY my.cnf /etc/mysql/conf.d/
RUN chmod 644 /etc/mysql/conf.d/my.cnf