# Sample Database
---
The sample database is a simple POS database. It has _Product, Category, Attribute, Product Attribute_.


## Category Table
Contains the list of product categories

|id|description|
|---|---|
|1|Coffee|
|2|Energy Drinks|
|3|Healthy Drink|

## Attribute
List of possible attributes of a product

|id|description|
|---|---|
|1|Weight(g)|
|2|Calories|
|3|Sugar|

## Product Table
Contains the list of products

|id|category_id|description|price|
|---|---|---|---|
|1|1|Neskape|5.00|
|2|1|Kapeko|7.00|
|3|2|Sting|23.00|
|4|2|Extra Juice|20.00|
|5|3|Yakult|5|

## Product Attribute
List of attributes of a Product. One Product has multiple Product Attribute

|id|product_id|attribute_id|value|
|---|---|---|---|
|1|1|1|2|
|2|1|2|3|
|3|1|3|4|
|4|2|1|1|
|5|2|2|3|
|6|2|3|2|
|7|3|1|10|
|8|3|2|15|
|9|3|3|20|

## Product Information Table
Contains other information of a product. The Product - Product Information is one is to one

|id|product_id|short_name|barcode|brand|
|---|---|---|---|---|
|1|1|Neskp|12321|Nescafe|
|2|2|Kpko|11111|Kopiko|
|3|3|Stng|23456|IDK|
|4|4|Xtra Juice|12543|Robin Padilla|
|5|5|Yklt|12512|OK Kabachan|