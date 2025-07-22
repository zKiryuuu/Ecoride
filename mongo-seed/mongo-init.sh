#!/bin/bash 

set -e  # S'il y a des erreurs, on arrete l'execution

echo ">>> Utilisateur $MONGO_INITDB_ROOT_USERNAME crée et base des données $MONGO_DB_NAME..."
# Code mongo pour créer la bdd et l'utilisateur
mongosh <<EOF
use $MONGO_DB_NAME
db.createUser({
  user: "$MONGO_INITDB_ROOT_USERNAME",
  pwd: "$MONGO_INITDB_ROOT_PASSWORD",
  roles: [{ role: "readWrite", db: "$MONGO_DB_NAME" }]
})
EOF

echo ">>> Importation des données dans la collection Avis..."
mongoimport \
  --username $MONGO_INITDB_ROOT_USERNAME \
  --password $MONGO_INITDB_ROOT_PASSWORD \
  --authenticationDatabase $MONGO_DB_NAME \
  --db $MONGO_DB_NAME \
  --collection Avis \
  --file /docker-entrypoint-initdb.d/seed.json \
  --jsonArray