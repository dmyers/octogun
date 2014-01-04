# Octokit [![Build Status](https://secure.travis-ci.org/dmyers/octokit.png?branch=master)](http://travis-ci.org/dmyers/octokit) [![Coverage Status](https://coveralls.io/repos/dmyers/octogun/badge.png)](https://coveralls.io/r/dmyers/octogun)

Simple PHP wrapper for the GitHub API. This is an unofficial port of [Octokit.rb](https://github.com/octokit/octokit.rb) in PHP. The goal is to have feature parity between languages.

## Installation

Simply add the following to your composer.json require block:

	'dmyers/octokit'

### Examples

#### Show a user

```php
$client = \Octokit\Octokit::users();
$client->user('sferik');
```

#### Show a repository

```php
$client = \Octokit\Octokit::repositories();
$client->repo('octokit/octokit.rb');
```

#### Authenticated Requests

For methods that require authentication, you'll need to setup a client with
your login and password.

```php
$client = new \Octokit\Client(array('login' => 'me', 'password' => 'sekret'));
$client->users()->follow('sferik');
```

Alternately, you can authenticate with a [GitHub OAuth2 token][oauth].

[oauth]: http://developer.github.com/v3/oauth

```php
$client = new \Octokit\Client(array('login' => 'me', 'oauth_token' => 'oauth2token'));
$client->users()->follow('sferik');
```

### Using with GitHub Enterprise

To use with [GitHub Enterprise](https://enterprise.github.com/), you'll need to
set the API and web endpoints before instantiating a client.

```php
$client = new \Octokit\Client(array('login' => 'USERNAME', 'password' => 'PASSWORD'));
$client->configuration()->set('api_endpoint', 'https://github.company.com/api/v3';
$client->configuration()->set('web_endpoint', 'https://github.company.com/';
```
## Copyright

Copyright (c) 2013 Derek Myers. See [LICENSE][] for details.
[license]: LICENSE.md
