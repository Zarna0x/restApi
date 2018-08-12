Rest api... still under development

You can build image using Docker file

```
docker build -t your-image-name:1.0 .
```

and start your container

```
docker run -d --name restapi-zarna0x-container -v $(pwd):/var/www/html -v /var/www/html/vendor -p 80:80 your-image-name:1.0

```
