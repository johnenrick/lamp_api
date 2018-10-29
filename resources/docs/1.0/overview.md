# Overview
---
- [First Section](#first-section)

## API Resource
_API Resource_ the resource that has basic api operation and other operations. By default, one database table has one API Resource

### The Basic Operations

By default, the API has four basic supported operation. These operation maybe modified or disabled. The four operations are: _Create, Retrieve, Update, Delete_. This operations functions as its name suggests.
<a id="first-section"></a>
### API Request Link
The link for making an API request is as follows:
```php
  {web-address}/api/{api-resource}/{operation}
```
__web-address__ is the domain or ip address of the server. The __api-resource__ is the name of the API Resouce is kebab-case. The __operation__ is the end point of the request and it is the actual operation being reqouested.
e.g. localhost/api/product/create

### Request Reponse
```javascript
{
  success: ...,
  error: ...
}
```
The default response has a success and fail. If the request is sucessful, the result of the request will be stored in sucess. If the request fails, the error messages will be stored in fail. Refer to [Response Error](/docs/{{version}}/response-error) for the list of errors and error codes.

## Sample Database
To make sampling easier, we will be using a [sample database](/docs/{{version}}/sample-db) of a simple POS
