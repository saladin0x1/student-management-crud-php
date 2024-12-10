# Use the official PHP Apache image
FROM php:8.2-apache

# Install dependencies and the mysqli extension
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli pdo pdo_mysql gd

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Copy the application files into the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80

# Command to run Apache in the foreground
CMD ["apache2-foreground"]

