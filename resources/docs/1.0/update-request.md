# Basic Update Request
Updating a data in database is much like creating the data except that the requesting agent has to specify the _id_ and the there is no required in validation,

__LINK:__ api/{api-resource}/create

## Parameters

The request expects an object with key value that is identical to the main table. The key is the column and the value is the value to be updated. The parameter __id__ is also required to specify the entry to modify.

Below is an example of inserting a new product in database.
```javascript
[
  id: 1,
  description: 'San Mig Double White Coffee',
  price: 10
]
```

### Updating Table Entry with Foreign Table

It is possible to update foreign table aside from the main table in an API Resource. To do so, the foreign tables must be a child table.

Below is an example of updating a new product in database with attribues.
```javascript
{
  id: 1,
  category_id: 1,
  description: 'San Mig Double White Coffee',
  price: 10,
  product_information: {
    id: 1,
    short_name: 'SMDoubl WC',
    barcode: 12223,
    brand: 'San Mig'
  },
  product_attributes: [
    {
      id: 1,
      attribute_id: 1,
      value: 1
    },
    {
      id: 1,
      attribute_id: 2,
      value: 10
    }
  ]
}
```
The example above shows that there two foreign table involved, the __product\_information__ and the __product\_atrributes__.

For foreign table with _one is to one_ relationship with the product, the value is expected to be an object and the foreign table name is singular as shown in __product\_information__.

For foreign table with _one is to many_ relation, the value is expected to be an array and the foregin table name is plural as shown in __product\_atrributes__.

#### Updating One is to Many Foreign Table
In updating multiple foreign table entries, the requesting agent can either create, update, or delete. To update an existing entry, the id must be specified. To delete existing, add a key _delete_ which has a value of true.

**Sample Request:**

```javascript
{
  id: 1,
  price: 10,
  product_information: {
    id: 1, // update
    short_name: 'SMDoubl WC',
    barcode: 12223,
    brand: 'San Mig'
  },
  product_attributes: [
    {
      id: 1, // update because id is present
      attribute_id: 1,
      value: 1
    },
    { // this entry will be created
      attribute_id: 2,
      value: 10
    },
    {
      id: 2,
      deleted: true //this entry will be deleted
    }
  ]
}
```

**Response**

```javascript
data: {
  id: 1,
  price: 10,
  product_information: {
    id: 1
  },
  product_attributes: [
    {
      id: 1 //update
    },
    {
      id: 10 //create
    },
    {
      id: 2,
      deleted: true //delete
    }
  ]
}
```