# PHP Session Class
### Allows you to deal with Session in php
---

# Installation
```php
#include your file
include './to/path/session-manager.php';

use Prog98rammer\Session\Session;

// start the session.
$session = new Session();

```
# Usage 
-- **Basic Usage**

## Set the sessoin prefix
#### There are two ways to set the prefix

-- **First One**
```php
$session = new Session($prefix);
```

-- Example
```php
$session = new Session('test_');
```

#### Second way
```php
$session = new Session;
$session->prefix('test_')->set('name', 'khalid'); // it will set the session as "test_name"
```

#### Or you can generate a random prefix and use it.
```php
$session->randomPrefix($length = 15);

// example
$session->randomPrefix()->set('name', 'khalid'); // [L8Qv6hbnBHj71t0_name] => khalid
```
#### Get the session prefix
```php
$sesssion->getPrefix(); // will return the session prefix
```

#### Get all session keys
```php
$sesssion->all();
```

#### Add new session
```php
// store the new session
$session->set($key, $value);

// for Example
$session->set('name', 'John');
```
#### Add more than one session by Chaining method
```php
$session->set('name', 'Khalid')
        ->set('age', 19)
        ->set('country', 'Iraq')
        ->set('city', 'Baghdad');
```
#### Add more than one session by providing an array
```php
$session->set([
    'name' => 'khalid',
    'age' => 19,
    'location' => [
        'country' => 'iraq',
        'city' => 'baghdad'
    ]
]);
```

#### Get one session by key
```php
$sesssion->get($key); // will use the default prefix.
```

#### Get All Session by spicefic prefix
```php
$session->fromPrefix($prefix);

#example
$session->fromPrefix('test'); // returns an array of all session that have a "test" prefix

```
#### Remove Session by key
```php
$sesssion->remove($key);
```
#### by chaining method
```php
$session->remove('name')
        ->remove('age')
        ->remove('location');
```

#### by providing an array of keys
```php
$session->remove([
    'name', 'age', 'location'
]);
```

#### or just like this
```php 
$session->remove('name', 'age', 'location');
```

#### Get the session id
```php
$sesssion->id(); // will return the id of the session.
```

#### Regenerate the session id
```php
$sesssion->regenerate_id(); // will return the id of the session.
```

#### if you like to remove all session at one 
```php
$session->destroy();
```
