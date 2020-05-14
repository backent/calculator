# Jakmall Calculator

## Software Requirements
- Docker

## Vendor installation
```
./composer install
```

## Create Database
```
./php vendor/bin/doctrine orm:schema-tool:create
```

## Update Database
```
./php vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
```

## Run the Calculator
```
./calculator
```