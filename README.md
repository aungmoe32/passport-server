# Simple Oauth Passport Server and Client

## Demo 
- Passport server : https://passport-server.fly.dev/
- Passport client : https://passport-client.fly.dev/


## Tech Stack
- Laravel
- Passport
- Filament for Admin Panel

## Installation
### For Server
- run `composer install`
- connect your database and run `php artisan migrate`
- run `php artisan passport:install`
- run `php artisan passport:client`, enter `http://localhost:9001/callback` for redirect uri and note id, secret for client server
- run `php artisan serve --port=9000`
- go to `http://127.0.0.1:9000`


### For Client
- run `npm install`
- run `vite build`
- run `composer install`
- connect your database and run `php artisan migrate`
- copy `.env.example` to `.env`
- enter `API_CLIENT_ID` and `API_CLIENT_SECRET` to `.env` from noted above
- add `http://127.0.0.1:9000`(server's address) to `API_URL` in `.env`
- run `php artisan serve --port=9001`
- go to `http://localhost:9001`
* note that it should be localhost not 127.0.0.1 for cookie conflicts


### Usage
- Register new user in server
- Go to client and click "Login as Passport"
- Authorize login in server
- Done, your client account connected with server's account
- You can revoke access tokens at server's dashboard

### Contact me
aungmoemyintthu@gmail.com


