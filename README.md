A simple Tallstack e-commerce application with [filamentphp](https://filamentphp.com) admin panel. Though the script is simple but there are some basic implementation of advanced start. Multilingual, Multi Currency, Stripe Payment API with Webhook integration.

The Project is still under development and subjected to heavy change over the time and some functionality may not be perfectly work in different situation.

### Preview
![Banner](https://raw.githubusercontent.com/sahapranta/tall_ecommerce/main/screenshots/tall_ecommerce_preview.jpg)
<video src="screenshots/preview.mp4" controls title="Preview Checkout"></video>

### For installation use
```bash
composer install
npm install && npm run dev
```

### External API
`.env` file contains a `CURRENCY_EXCHANGE_API_KEY` which can be found on [Exchange Rates Data API](https://apilayer.com/marketplace/exchangerates_data-api) as FREE

Also set Stripe API KEY and also google recaptcha v3 api.


```bash
php artisan migrate --seed
php artisan serve
```


The basic seeder will seed the database with a test user

- user: `test@example.com`
- password: `password`

## Todo

### FRONTEND
---
- [x] Display Product
- [x] Switch Language
- [x] Switch Currency
- [x] Product View
- [x] Product Image Media
- [x] Cart (Session & DB)
- [x] Promo Code (Session & DB)
- [x] Checkout
- [x] Payment
- [x] Stripe API and Webhook Integration
- [x] Checkout Customer Address Choice
- [x] Purchase Success, Failed, Confirmed
- [ ] Category Filter
- [ ] Search Functionality
- [ ] Static Pages
- [ ] Email- Confirm Order, Invoice, Delivery
- [x] Subscription
- [x] Google Recaptcha
- [ ] Prodouct Reviews
- [ ] Blog
- [ ] Blog Comments
- [ ] SEO Optimization


### ADMIN
---
- [x] Manage Currency
- [x] Manage Static Pages
- [x] Manage Category
- [x] Manage Product
- [x] Manage Product Variation
- [x] Manage Coupon
- [ ] Manage Customer & Address
- [ ] Manage Order
- [ ] Dashboard Analytics
- [x] Manage Subscriber
- [ ] Manage Email
- [ ] Manage Blog




## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.


## License
[MIT license](https://opensource.org/licenses/MIT).
