## Task
Build a simple blog platform, that allow registered users could CRUD their posts and view others. Admin is required to publish users’ posts.
#### Core features
* Everyone could see list of posts and check their detail
* People could register for new account and login/logout to the system
* Registered users could CRUD their posts.
* Posts’ body understand markdown syntax and could render properly
* Admin could see a list of created posts
* Admin could publish or unpublish created posts
#### Optional features
* Only published posts would be display in public listing page
* Admin could see highlighting unpublished posts in list of all posts
* Admin could filter/order posts by date or status
* Admin could schedule post publishing. E.g I want publish this post automatically in tomorrow 9AM
#### Very Very Very Optional features
* 100% Unit Tested
* Clean commit messages

## Installation:
* Import `sql/database.sql`
* Use code in `src` 
* Rename `config/config.php.sample` to `config/config.php`
* Config your blog in `config/config.php`
* Setup your apache config domain to `mytest.local` or any domain defined in config.php `URL`
* Pre-defined admin username/password: `admin@admin.co/test123`
* Pre-defined user username/password: `test@me.com/test123`