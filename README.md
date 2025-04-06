# Magento 2 nokytech facebook feed

> a magento 2 based module that place your social media feed on any block or page of your magento 2 store

- easy to use
- easy to setup
- minimal and simple as it can get


## for magento luma :

### Installation process

### Step 1 : add Nokytech repo

```sh
composer config repositories.nokytech vcs https://gitlab.com/Nokytech/nokyfacebookfeed/
```

### Step 2 : Authenticate Composer with GitLab

```sh
composer config --global --auth gitlab-token.gitlab.com glpat-asui6puysw1eyfov2nsi
```
### Step 3 : install the module into your project 

```sh
composer require nokytech/fb-noky-feed:dev-main
```

### to update the module 

```sh
composer update nokytech/fb-noky-feed:dev-main
```


### module settings :
- `stores/configuration/nokytech/Fb Noky Feed`

### after instalation use shortcode on the targeted page:
- `{{block class="Nokytech\FbNokyFeed\Block\Feed" template="Nokytech_FbNokyFeed::feed.phtml"}}`

------------------------------------------------------


## for hyva support :

### install hyva fallback module :

```sh
composer require hyva-themes/magento2-theme-fallback
```

