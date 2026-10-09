Developing & Pull Request
-------------------------

Run the PHP-CS-Fixer and the unit tests before you make a pull request to the bundle:

    vendor/bin/ecs check src tests
    vendor/bin/phpstan analyse
    vendor/bin/phpunit --colors=always

Run cypress tests against demo data

    npm run cypress:open or yarn run cypress open
