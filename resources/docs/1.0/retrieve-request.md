# Retrieve Request
- [First Section](#first-section)

Retrieve data from the resource.

__LINK:__ api/{api-resource}/retrieve

## Parameter
Retrieving a data from API follows the concept of _You Get What You Want_. The requesting agent can use their creativity when retrieving the data that they want.

|Parameter|Type|Required|Description|Default|
|---|---|---|---|---|
|[Select](#select)|Array of Object or String|No|Specify the columns to retrieve||
|[Condition](#condition)|Array of Object or String|No|Specify the columns to retrieve||
|[Limit and Offset](#limit-offset)|Array of Object or String|No|Specify the columns to retrieve||
|[Sort](#sort)|Array of Sort Object|No|Specify the columns to retrieve||



### Select
The data to be retrieved must be specfied.

__Example:__
##### Request Parameter
```javascript
{
  select: [
    'description',
    'price'
  ]
}
```
##### Response
```javascript
[
  {
    description: 'Neskape',
    price: 5.00
  },
  {
    description: 'Kapeko',
    price: 7.00
  },
  {
    description: 'Sting',
    price: 23.00
  },
  {
    description: 'Extra Juice',
    price: 20.00
  },
  {
    description: 'Yakult',
    price: 5.00
  }
]
```
<a id="condition"></a>
### Condition
Retrieve only the data that passed the condition. Just add a condition parameter which is an array of _condition object_.

__Condition object__

|Key|description|Sample Value|
|---|---|---|
|column|the table and/or column of table|description, category.desciption|
|clause|the conditional clause| =, >, <, like|
|value|the value for the condition|1, null|

##### Request Parameter
```javascript
{
  select: [
    'description',
    'price'
  ],
  condition: [
    {
      column: 'price',
      clause: '>',
      value: 5
    },
    {
      column: 'category.id',
      clause: '=',
      value: 1
    }
  ]
}
```
##### Response
```javascript
data: [
  {
    description: 'Kapeko',
    price: 7.00
  }
],
data: false
```
#### Requesting With ID
When requesting with id in the parameter, the condition will be automatically ignored since the _id_ is unique. And in the _sucess response_, the value is object not array because it is expected that the result is only 1.

##### Request Parameter
```javascript
{
  id: 3,
  select: [
    'id',
    'description',
    'price'
  ]
}
```
##### Response
```javascript
data: [
  {
    id: 3
    description: 'Sting',
    price: 23.00
  }
],
data: false
```

### Limit and Offset
Limit and offset can be used to limit the result and at the same time can be used to paginate the results. Just specify the limit and offset in the parameter.

The __total result__ is the total number of entries if offset and limit is not implemented.

##### Request Parameter
```javascript
{
  limit: 3,
  offset: 1
}
```
##### Success Response
```javascript
data: [
  {
    description: 'Kapeko',
    price: 7.00
  },
  {
    description: 'Sting',
    price: 23.00
  },
  {
    description: 'Extra Juice',
    price: 20.00
  }
],
total_result: 5
```
### Sort
Sort the result. The sort parameter expects an array of _Sort Object_.
__Sort Object__

|Key|Description|
|---|---|
|column| The table and/or column to be sorted|
|order|'asc' for ascending, 'desc' for descending|

##### Request Parameter
```javascript
{
  sort: [
    {
      column: 'description',
      order: 'asc'
    }
  ]
}
```
##### Success Response
```javascript
data: [
  {
    description: 'Extra Juice',
    price: 20.00
  },
  {
    description: 'Kapeko',
    price: 7.00
  },
  {
    description: 'Neskape',
    price: 5.00
  },
  {
    description: 'Yakult',
    price: 5.00
  },
  {
    description: 'Sting',
    price: 23.00
  }
],
total_result: 5
```
### Selecting with Foreign table
To select the foreign table of the resource, just add the foreign table name in the __select__ clause. The value of the is a __parameter Object__

##### Request Parameter
```javascript
{
  select: [
    'description',
    'price',
    category: {
      select: ['id', 'description']
    }
  ],
  condition: [
    {
      column: 'price',
      clause: '>',
      value: 5
    },
    {
      column: 'category.id',
      clause: '=',
      value: 1
    }
  ]
}
```
##### Response
```javascript
data: [
  {
    description: 'Kapeko',
    price: 7.00,
    category: {
      id: 1,
      description: 'Coffee'
    }
  }
]
```