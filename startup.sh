if [[ -f "sql/init.sql" ]]; then
    echo "SQL file already exists... skipping the download."
else
    curl -L http://u.arizona.edu/~milazzom/init.sql --output sql/init.sql
fi
docker-compose up -d --build