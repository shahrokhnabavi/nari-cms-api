FROM alpine:3.7

ENV TIMEZONE Europe/Amsterdam
ENV MYSQL_USER_MONITORING monitoring
ENV MYSQL_PASSWORD_MONITORING monitoring

# Installing packages MariaDB
RUN apk add --no-cache mysql mysql-client
RUN addgroup mysql mysql
RUN apk add openrc --no-cache

# Copy of the MySQL startup script
COPY startup.sh /startup.sh

EXPOSE 3306

CMD [ "/startup.sh" ]

RUN { \
        echo '#!/bin/sh'; \
        echo 'set -e'; \
        echo; \
        echo 'dirname "$(dirname "$(readlink -f "$(which javac || which java)")")"'; \
    } > /usr/local/bin/docker-java-home \
    && chmod +x /usr/local/bin/docker-java-home
ENV JAVA_HOME /usr/lib/jvm/java-1.8-openjdk
ENV PATH $PATH:/usr/lib/jvm/java-1.8-openjdk/jre/bin:/usr/lib/jvm/java-1.8-openjdk/bin

ENV JAVA_VERSION 8u212
ENV JAVA_ALPINE_VERSION 8.222.10-r0

RUN set -x \
	&& apk add --no-cache openjdk8-jre="$JAVA_ALPINE_VERSION"

RUN [ "$JAVA_HOME"="$(docker-java-home)" ]

WORKDIR /flyway

ENV FLYWAY_VERSION=5.2.4

RUN apk --no-cache add --update bash openssl \
	&& wget https://repo1.maven.org/maven2/org/flywaydb/flyway-commandline/${FLYWAY_VERSION}/flyway-commandline-${FLYWAY_VERSION}.tar.gz \
	&& tar -xzf flyway-commandline-${FLYWAY_VERSION}.tar.gz \
	&& mv flyway-${FLYWAY_VERSION}/* . \
	&& rm flyway-commandline-${FLYWAY_VERSION}.tar.gz && \
	ln -s /flyway/flyway /usr/local/bin/flyway

