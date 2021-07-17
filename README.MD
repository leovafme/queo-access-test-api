# Queo Access Test Api

## Configuration for Development


### Docker Compose
- run project
```batch
docker-compose up
```

### If use s3 for persistent data add env
- USE_S3
- AWS_S3_URL
```.env
USE_S3=true
AWS_S3_URL='https://queo-access-test.s3.amazonaws.com/'
```

### If not use s3 for persistent run command for add virtual link
```batch
php artisan storage:link
```

### Run seeder 10 companies and 50 employees
- if use docker run command into container
```batch
php artisan db:seed --class=DatabaseSeeder
```

