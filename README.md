
# Project Manager API

API used to manage project data for personal projects worked on.

## Install software (using Mac and brew)

### Composer
- Install with brew
```
brew install composer
```
### PHP
- Install PHP 7.4 with brew
```
brew install php@7.4
```
## Setup 
- Install packages
```
composer install
```
- Copy the .env.example file to a new file named .env
```
cp .env.example .env
```
- Fill in .env variables in new file
```
vim .env
```
- Run migration files to update MySQL data
```
./bin/console doctrine:migrations:migrate 
```
## Commands
- Run app in development
```
symfony serve
```
