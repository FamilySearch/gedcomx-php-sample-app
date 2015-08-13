# gedcomx-php-sample-app

An application that demonstrates the usage of the [gedcomx-php](https://github.com/FamilySearch/gedcomx-php) library in conjunction with the FamilySearch API.
A running version of the app is available at [http://gedcomx-php-sample-app.herokuapp.com/](http://gedcomx-php-sample-app.herokuapp.com/).

The sample app requires a FamilySearch Family Tree sandbox user account. A sandbox user account is obtained when you [register](https://grms.force.com/Developer/FSDev_DevRegistration) as a FamilySearch development partner.

## Installation

Requirements:

* git
* php
* composer [installed globally](https://getcomposer.org/doc/00-intro.md#globally).

Steps:

1. [Fork](https://help.github.com/articles/fork-a-repo/) this repository.
2. Pull the code down to your local machine: `git clone https://github.com/YOUR-USERNAME/gedcomx-php-sample-app.git`
3. `cd gedcomx-php-sample-app`
4. Install dependencies: `composer install`
5. [Register your app to get an app key](https://familysearch.org/developers/docs/guides/getting-started#WelcometoDevelopingwithFamilySearch-RegisterYourAppWithFamilySearch).
  The redirect URI will be `http://localhost:8080/examples/OAuth2Code.php`.
6. Update the SDK configuration in `includes/setup.php` with your new app key.
7. Run a simple webserver (requires PHP 5.4+): `php -S localhost:8080 -t src/`
8. Open `http://localhost:8080` to begin using the sample app.
