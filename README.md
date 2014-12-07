# PHP Apache Rewrite Proxy

## Purpose

If you need to develop the front-end part of a web application and have to make AJAX requests to an API which is not accessible through the same domain, these requests are blocked by the web browser due to same origin policy restriction.

To get around this you could send all API requests to the host you’re developing the front-end on while your local development host would only act as a proxy server for API requests, which means it accepts your AJAX request, sends the same request to the actual API host, and passes everything back to your JavaScript.

## How does this script work?

The PHP script `proxy.php` does exactly what’s described above. It reads all request headers and the body, passes everything on to the remote host and returns all headers and body back to the client.

It also passes on the request method, which makes it compatible with GET, POST, PUT, DELETE or any other request methods you like.

There is also a sample `.htaccess` included which passes all requests starting with `http://your-dev-host/api/` to `proxy.php`. If your API path starts with anything other than `api/` simply change this.

To make things clearer, using the sample configuration a request to `http://your-dev-host/api/endpoint?x=1` would be passed on to `http://127.0.0.1:9000/api/endpoint?x=1`.

## Configuration options

  1. As described above, adjust the path of `RewriteRule` in `.htaccess` to ideally match the API path of the remote host.
  2. Set the correct base URL of your remote API host in `$upstream_base_url` in file `proxy.php`.
  3. You may set a `$timeout` in seconds for remote requests. Especially if your remote API host is not in your local network or responds slowly, you may want to increase the 5 seconds default value.

## What does the proxy script change in requests and responses?

This script does not really add or remove anything to headers or body, generally it passes everything on in both ways as it is. But please be aware, your local server may add other headers like `Server` or `X-Powered-By` which were not in the API response. This rather simple implementation does also not take multiple headers with the same key into account. Headers are passed back to the client with the `replace` option of PHP’s `header()` function being `true` by default (see [PHP header() documentation](http://php.net/manual/en/function.header.php)).
