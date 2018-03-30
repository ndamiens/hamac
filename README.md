# Hamac
![](https://travis-ci.org/ndamiens/hamac.svg?branch=master)

Tools who deals with mac addresses

```php

Hamac::mac2bin("ae:cb:c7:16:e1:56");

# 192190241759574

Hamac::mac2bin("ae cb-c7 16:E1:56");

# 192190241759574

Hamac::isInRange(
	Hamac::mac2bin("ae:cb:c7:16:e1:56"),
	Hamac::mac2bin("ae:cb:c7:16:e1:00"),
	Hamac::mac2bin("ae:cb:c7:16:e1:ff")
);

# true

```

