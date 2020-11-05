
# for development

run PHP-CS-FIXER before commit

    sh tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

# Install PHP-CS-FIXER

visit https://github.com/FriendsOfPHP/PHP-CS-Fixer for more information

    mkdir --parents tools/php-cs-fixer
    composer require --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer
