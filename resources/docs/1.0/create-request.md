# Basic Create Request
Inserts a data to the resource.

__LINK:__ api/{api-resource}/create

## Parameters

The request expects an object with key value that is identical to the main table. The key is the column and the value is the value to be inserted.

Below is an example of inserting a new product in database.
```javascript
[
  category_id: 1,
  description: 'San Mig Double White Coffee',
  price: 10
]
```

### Inserting Table Entry with Foreign Table

It is possible to insert foreign table aside from the main table in an API Resource. To do so, the foreign tables must be a child table.

Below is an example of inserting a new product in database with attribues.
```javascript
{
  category_id: 1,
  description: 'San Mig Double White Coffee',
  price: 10,
  product_information: {
    short_name: 'SMDoubl WC',
    barcode: 12223,
    brand: 'San Mig'
  },
  product_attributes: [
    {
      attribute_id: 1,
      value: 1
    },
    {
      attribute_id: 2,
      value: 10
    }
  ]
}
```
The example above shows that there two foreign table involved, the __product\_information__ and the __product\_atrributes__.

For foreign table with _one is to one_ relationship with the product, the value is expected to be an object and the foreign table name is singular as shown in __product\_information__.

For foreign table with _one is to many_ relation, the value is expected to be an array and the foregin table name is plural as shown in __product\_atrributes__.

## Success Response

If the request is successful, the id of created entries will be shown in the response
```javascript
{
  data: {
    id: 6,
    product_information: {
      id: 6
    },
    product_attributes: [
      {
        id: 10
      }, {
        id: 11
      },{
        id: 12
      },
    ]
  }
}
```