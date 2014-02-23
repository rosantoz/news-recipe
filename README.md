[![Build Status](https://travis-ci.org/rosantoz/news-recipe.png)](https://travis-ci.org/rosantoz/news-recipe) [![Coverage Status](https://coveralls.io/repos/rosantoz/news-recipe/badge.png?branch=master)](https://coveralls.io/r/rosantoz/news-recipe?branch=master)

# Requirements
```PHP 5.4+```

# Dependencies
Install dependencies using composer

```composer install```

or

```php composer.phar install```

# Unit tests

Assuming you have installed all dependencies using composer, you can run the unit tests with the following command:

```./vendor/bin/phpunit -c ./phpunit.xml.dist```

# Code coverage

Code coverage report is available in ```./build/logs/report/index.html```

# Documentation

``` . /build/docs/index.html```

# Continuous Integration

Available via travis-ci and coverall.io. Just click in the badges above

# Script usage

To use it in the command line:

``` php public/recipeFinder.php <csv file> <recipes json file>```

### Example

```php public/recipeFinder.php ./data/fridge.csv ./data/recipes.json```

The example above will output:

```Recommendation for tonight is: grilled cheese on toast```

# Using as a webpage

Assuming that you have PHP 5.4+ installed, just use:

```php -S localhost:8000 -t public/```

and then open http://localhost:8000 in your browser