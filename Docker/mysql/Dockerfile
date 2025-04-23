FROM mysql:8.4.4

ARG MYSQL_PASSWORD

COPY ./Docker/config/mysql/mysql.cnf /etc/mysql/conf.d/mysql.cnf
COPY ./Docker/config/mysql/create_database.sql /docker-entrypoint-initdb.d/create_database.sql
#COPY ./Docker/config/mysql/set_native_password.sql /docker-entrypoint-initdb.d/set_native_password.sql

RUN echo "ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_PASSWORD}';" >> /docker-entrypoint-initdb.d/set_native_password.sql
