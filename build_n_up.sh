#!/bin/bash
# Пример файла для автоматического увеличения номра билда

# Читаем текущую версию из файла
version_file=".version"
current_version=$(cat $version_file 2>/dev/null || echo "v0.0.0")

# Разбиваем версию на MAJOR.MINOR.PATCH
IFS='.' read -ra parts <<< "$current_version"
major=${parts[0]}
minor=${parts[1]}
patch=${parts[2]}

# Увеличиваем PATCH
new_patch=$((patch + 1))

# Формируем новую версию
version="${major}.${minor}.${new_patch}"
echo $version > $version_file

# Сборка и публикация образа
docker build -t darkbater/x-apache-php-pg-docker:${version} .
#docker push darkbater/x-apache-php-pg-docker:${version}

# Дополнительно: тег latest
docker tag darkbater/x-apache-php-pg-docker:${version} darkbater/x-apache-php-pg-docker:latest
docker push darkbater/x-apache-php-pg-docker:latest

# Создание тега в Git (опционально)
git tag -a ${version} -m "Docker image version ${version}"
git push origin ${version}
