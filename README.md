# Twig Safe Date Extension

[![Build Status](https://travis-ci.org/vivait/twig-safe-date.svg?branch=master)](https://travis-ci.org/vivait/twig-safe-date)

Simple filter in twig to help avoid problems with things like: `{{ null|date('Y-m-d') }}`

There are ways around it using twig - the [documentation](https://twig.symfony.com/doc/2.x/filters/date.html) even states:

> If the value passed to the date filter is null, it will return the current date by default. If an empty string is desired instead of the current date, use a ternary operator:
>
> `{{ post.published_at is empty ? "" : post.published_at|date("m/d/Y") }}`

But often, this is overlooked.

## Requirements

* PHP >= 5.6
* Twig ^1.27|^2.0

## Installation & Usage

`composer require vivait/twig-safe-date`

Once required, register the extension with Twig:

```php
$twig = new \Twig_Environment($loader);
$twig->addExtension(new TwigSafeDateExtension);
```

Once registered, you can use the filter `date` to output dates as before, with the change that: **null values will get turned into known content (default: `-`) rather than today's date**

The default format is `'F j, Y H:i.'` (the same as the core `date` filter in Twig)

```
{{ post.posted_at|date }}
```

If you wish to change the format of the date, pass it a parameter with your preferred format:

```
{{ post.posted_at|date("d/m/Y") }}
```

If `post.posted_at` is `null`, then by default the filter will output `-`, if you wish to change this to a different value, pass a new default as the third parameter:

```
{{ post.posted_at|date("d/m/Y", "Europe/London" "Content if null") }}
```
