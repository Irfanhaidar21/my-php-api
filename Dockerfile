FROM php:8.2-apache

# બધી ફાઇલોને સર્વરના ફોલ્ડરમાં કોપી કરો
COPY . /var/www/html/

# ફાઇલો વાંચવા માટે સર્વરને પૂરી પરમિશન આપો
RUN chmod -R 755 /var/www/html/

EXPOSE 80
