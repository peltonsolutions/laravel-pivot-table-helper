# laravel-pivot-table-helper

Description WIP

## Things to add

- allow nullable relationships, when you have multiple
- add morphToMany
- add command to automatically create the migration file from a model/relationship
- If the target table already exists, update the table instead

## Install

You can install the package via composer using the following command:

``` bash
composer require peltonsolutions/laravel-pivot-table-helper
```

## Usage

```php
<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PeltonSolutions\LaravelPivotTableHelper\Models\GenerateBelongsToManyMigration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		GenerateBelongsToManyMigration::createMigration(
			(new User())->roles()
		);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists((new User())->roles()->getTable());
	}
};


```

```php
<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use PeltonSolutions\LaravelPivotTableHelper\Models\GenerateBelongsToManyMigration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		GenerateBelongsToManyMigration::createMigration(
			(new User())->roles()
		);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists((new User())->roles()->getTable());
	}
};


```

### Security

If you discover any security-related issues, please
email [security@peltonsolutions.com](mailto:security@peltonsolutions.com) instead of using the issue tracker.

## Credits

- [Nathan Pelton](https://www.nathanpelton.com)

## License

laravel-pivot-table-helper is open-sourced software. It's licensed under
the [MIT license](https://opensource.org/licenses/MIT),
which is a permissive license allowing the software to be used, modified, and shared.