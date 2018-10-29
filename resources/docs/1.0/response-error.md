# Response Error
These are the following errors and error codes when the request fails. The error codes follows the [RFC](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes).

## Message Code
In order for the developer to compare message, a message code will be given.
### 1 Validation Error
When a request does not pass the validation rules, it would result to a validation error. The message of the error is an array of failed rules.

e.g.
```javascript
{
  error:[{
    code: 1,
    message: {
      description: ['required', 'unique'],
      price: ['numeric']
    }
  }]

}
```
## 2 Unathorize Error
The User must have a valid authentication token. The HTTP Status is 401.