# open_cart
Addition for OpenCart API 
# Features:
- Added ability to get products list
- Added ability to get categories list
- Added ability to get manufacturers list
- Added ability to add new product
- Added ability to edit existing product

# Installation:
1. Add product.php to folder: /catalog/controller/api
2. Add admin.php to foled: /catalog/model/catalog

# Connection:
1. Post request to: YOUR_WEBSITE/index.php?route=api/login With your API KEY. 
As a result you will receive api_token as json (YOUR_TOKEN on the next lines)

# How to use:
- Get products/categories/manufacturers lists: Request to YOUR_WEBSITE/index.php?api_token="YOUR_TOKEN"&route=api/product
- Add new product: Post request with product information as JSON to YOUR_WEBSITE/index.php?api_token="YOUR_TOKEN"&route=api/product/add
- Edit existing product: Post request with product information as JSON to YOUR_WEBSITE/index.php?api_token="YOUR_TOKEN"&route=api/product/edit

# Examples:
1. Example of product information to add/edit:

{
    "product_description": 
        {
            "1": 
                {"name": "Name of the product", "description": "", "meta_title": "Name of the product", "meta_description": "", "meta_keyword": "", "tag": ""}
        }, 
    "product_category": "category", 
    "product_store": ["Default"], 
    "model": "Name of the product",
    "sku": "", 
    "upc": "", 
    "ean": "", 
    "jan": "", 
    "isbn": "", 
    "mpn": "", 
    "location": "", 
    "price": "221", 
    "tax_class_id": "0", 
    "minimum": "1", 
    "subtract": "1", 
    "quantity": "4", 
    "stock_status_id": "7", 
    "shipping": "1",
    "date_available": "2020-07-11", 
    "length": "", 
    "width": "", 
    "height": "", 
    "length_class_id": "1",
    "weight": "", 
    "weight_class_id": "1", 
    "status": "1", 
    "sort_order": "1", 
    "manufacturer_id": 0, 
    "filter": "", 
    "download": "", 
    "related": "", 
    "option": "", 
    "image": "", 
    "points": ""
}
