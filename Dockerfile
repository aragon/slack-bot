FROM php

RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip

RUN apt-get update && \
    apt-get install curl && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

RUN composer require mpociot/botman
RUN composer require mpociot/slack-client

COPY . .

CMD php bot.php
