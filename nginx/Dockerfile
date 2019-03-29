FROM nginx as bbb

MAINTAINER Bolot Kalil uulu <bolotkalil@gmail.com>

RUN  nginx -t

# referesh nginx configuration file
COPY nginx.conf /etc/nginx


# define the site as a new host
# make sure file is copied
RUN mkdir /etc/nginx/sites-available/
RUN mkdir /etc/nginx/sites-enabled/

COPY  app.conf /etc/nginx/sites-available/
#COPY  app.conf /etc/nginx/conf.d/

# create smylink
RUN ln -fs /etc/nginx/sites-available/app.conf /etc/nginx/sites-enabled/app.conf

# remove default site
#RUN rm /etc/nginx/sites-enabled/default
RUN rm /etc/nginx/conf.d/default.conf


#RUN usermod -u 1000 www-data

#CMD ["nginx"]

EXPOSE 80 443 22 8080
