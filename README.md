# online-marketplace

project stack:
- php 8+
- mySQL (relational database system)
- git (VM)

client side:
- bootstrap 5
- along with custom-made scripts for our purposes

project alike of common online marketplace websites that enable users  
to publish their products and services, and searchers to find what they need.



# table-entity-structure-story ( Entity Relationship Diagram - ERD )

---

Below you will be able to see a relations map of my tables, and how my app functions in essence, with how fetching/storing relating is functioning.

```
User 
 └── hasMany Articles
Article
 ├── belongsTo User
 ├── belongsTo Category
 ├── hasMany Tags (ManyToMany)
 └── hasMany Images ( will come )
Category
 └── hasMany Articles
Tag
 └── belongsToMany Articles
Image
 └── belongsTo Article
```

---

# Essential Pages

## Home
- User first visits it
- Shows some stats and way to market.php/login/register

## Market.php
- Main page of the app
- Lets users see articles that other users have created

Supposed features::

- **Search Results** - Filtered listings by category, price, location

- **Category Browse** - All articles in a specific category
Advanced Search - Multiple filters (price range, condition, etc.)

## Admin.php
page supposed for only admins to see it ( requires authorizaiton )
it enables admins to create new categories, tags for users to use, and even to menage current statues of articles, or to see and menage users.. ( top-level admins )

Supposed features::

#### Full CRUD Operations
- **Articles** - Create, Read, Update, Delete
- **Tags** - Create, Read, Update, Delete  
- **Categories** - Create, Read, Update, Delete
- **Users** - Create, Read, Update, Delete (if allowed)

#### Additional Features
- **Search and Filter** - By title, tag, or category
- **Pagination** - For better performance with large datasets
- **WYSIWYG/Markdown Editor** - For rich article content



---

# App Features

-- essentials
## Authentication
Login/Register - User authentication
Password Reset - Forgot password functionality
Email Verification - Confirm user accounts


-- moderate
## Article/Listing Pages
Article Detail - Full view with images, description, seller info
Create Article - Form to add new listings
Edit Article - Modify existing listings
My Listings - User's own articles with status (active/sold/pending)

## Communication - Chat System ( user-to-user )
Contact Seller - Messaging system between users
Inbox - User's messages
Notifications - System alerts and updates

## Additionals
Favorites/Wishlist - Save items for later
Reviews & Ratings - User feedback system
Help/FAQ - Support documentation
Terms & Privacy - Legal pages