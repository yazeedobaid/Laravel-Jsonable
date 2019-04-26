# Laravel-Jsonable
Eloquent like style for quering a JSON field in a MYSQL database.

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require yazeedobaid/jsonable
```

## Usage


### Setup a Model
``` php
<?php

namespace App;


use YazeedObaid\Jsonable\Jsonable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Jsonable;
}
```

### JSON Contains
Add an ANDed where clause to the query to checks if the JSON field contains text. 
The first argument specify the JSON column name in DB, second argument is 
the path in the JSON field and the third argument is the text to check if 
JSON field contains.

``` php

$post = Post::jsonContains('body', 'title', 'Laravel')->first();

```

### OR JSON Contains
Add an ORed where clause to the query to checks if the JSON field contains text. 
The first argument specify the JSON column name in DB, second argument is 
the path in the JSON field and the third argument is the text to check if 
JSON field contains.

``` php

$post = Post::orJsonContains('body', 'title', 'Laravel')->first();

```

### JSON Extract
Add a select field to the query to select a value from the JSON field. 
The first argument specify the JSON column name in DB and second argument is 
the path in the JSON field.

``` php

$post = Post::jsonExtract('body', 'title')->first();

```


### JSON Keys
Add a select field to the query to return all the keys in a  JSON field. 
The first argument specify the JSON column name in DB.

``` php

$post = Post::jsonKeys('body')->first();

```

If JSON field is nested with obther JSON objects in it, you can add a second argument
for the nestd JSON object to return its keys

``` php

$post = Post::jsonKeys('body', 'title')->first();

```

### JSON Search
Search for a value in a JSON field and returns the JSON path to that value. The first 
argument specify the JSON column name in DB, the second argument specify to return all
the found results or the first one and the third argument is the text to search for.

``` php

$post = Post::jsonSearch('body', 'one', 'Laravel')->first();

```

``` php

$post = Post::jsonSearch('body', 'all', 'Laravel')->first();

```

