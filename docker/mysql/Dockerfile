FROM dockerfile/mysql:latest
MAINTAINER (me)

ADD init.sql /data/init.sql

EXPOSE 3306

# Define working directory.
WORKDIR /data

CMD ["mysqld_safe"]