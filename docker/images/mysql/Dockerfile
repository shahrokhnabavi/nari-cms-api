FROM alpine:3.7

ENV TIMEZONE Europe/Amsterdam
ENV MYSQL_USER_MONITORING monitoring
ENV MYSQL_PASSWORD_MONITORING monitoring

# Installing packages MariaDB
RUN apk add --no-cache mysql
RUN addgroup mysql mysql
RUN apk add openrc --no-cache

# Copy of the MySQL startup script
COPY startup.sh /startup.sh

EXPOSE 3306

CMD [ "/startup.sh" ]
