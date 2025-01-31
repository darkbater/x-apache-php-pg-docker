## Запуск контейнера из DockerHub

```bash
docker run -d \
  --name x-docker \
  -p 8089:80 \
  --add-host=host.docker.internal:host-gateway \
  -e POSTGRES_HOST=host.docker.internal \
  -e POSTGRES_PORT=5432 \
  -e POSTGRES_DB=x-docker \
  -e POSTGRES_USER=x-docker \
  -e POSTGRES_PASSWORD=x-docker \
  darkbater/x-apache-php-pg-docker:v1.0.3
```

### Устранение неполадок при подключении к db:

Узнать подсеть:
```bash
ip -4 addr show docker0 | grep -Po 'inet \K[\d.]+'
```

Проверить, что подсеть разрешена в postgres:

*/etc/postgresql/{version}/main/postgresql.conf* 
```ini
listen_addresses = '*'
```

*/etc/postgresql/15/main/pg_hba.conf:*
```ini
host      all             all             172.17.0.0/16          md5
hostssl   all             all             172.17.0.0/16          md5
```
