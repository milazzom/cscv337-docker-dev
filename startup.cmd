if exist sql/init.sql (
    rem SQL file already exists, not downloading.
) else (
    rem Downloading SQL file for CSCV337 database.s
    curl -L http://u.arizona.edu/~milazzom/init.sql --output sql/init.sql
)
docker-compose up -d --build