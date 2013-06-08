# Octokit

Simple PHP wrapper for the GitHub API.

## Installation

Simpley add the following to your composer.json require block:

	'dmyers/octokit'


### Examples

#### Show a user

```php
$client = \Octokit\Octokit::users();
$client->user('sferik');
```

#### Authenticated Requests
For methods that require authentication, you'll need to setup a client with
your login and password.

```php
$client = new \Octokit\Client(array('login' => 'me', 'password' => 'sekret'));
$client->follow('sferik');
```

Alternately, you can authenticate with a [GitHub OAuth2 token][oauth].

[oauth]: http://developer.github.com/v3/oauth

```php
$client = new \Octokit\Client(array('login' => 'me', 'oauth_token' => 'oauth2token'));
$client->follow('sferik');
```

### Using with GitHub Enterprise

To use with [GitHub Enterprise](https://enterprise.github.com/), you'll need to
set the API and web endpoints before instantiating a client.

```php
$client = new \Octokit\Client(array('login' => 'USERNAME', 'password' => 'PASSWORD'));
$client->configuration->api_endpoint = 'https://github.company.com/api/v3';
$client->configuration->web_endpoint = 'https://github.company.com/';
```
