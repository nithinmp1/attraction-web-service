# Use an Ubuntu-based image
FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    rm -rf /var/lib/apt/lists/*

# Add the PHP PPA
RUN add-apt-repository ppa:ondrej/php

# Update package information
RUN apt-get update

# Install PHP 5.6 and the MySQL extension
RUN apt-get install -y php5.6 php5.6-mysql php5.6-curl

# Print the PHP version
RUN php -v

# ... Continue with other configurations and commands
COPY attraction1.1 /var/www/html/
EXPOSE 80
# CMD ["php", "index.php"]