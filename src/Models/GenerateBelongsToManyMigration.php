<?php

namespace PeltonSolutions\LaravelPivotTableHelper\Models;

use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class GenerateBelongsToManyMigration
{
	/**
	 * @throws Exception
	 */
	static public function createMigration(BelongsToMany|array $belongsToMany, ?string $tableName = null): void
	{
		$tableName = $tableName ?: $belongsToMany->getTable();

		$array = Arr::wrap($belongsToMany);

		$array = array_filter($array, function ($relationship) {
			return $relationship instanceof BelongsToMany;
		});

		if (count($array) == 0) {
			throw new Exception("No BelongsToMany found");
		}

		Schema::create($tableName, function (Blueprint $table) use ($array) {
			foreach ($array as $belongsToMany) {
				if ($belongsToMany instanceof BelongsToMany) {
					$pivotClassName = $belongsToMany->getPivotClass();
					$pivotInstance = (new $pivotClassName);
					if ($pivotInstance->getKeyType() == 'int') {
						$table->id($pivotInstance->getKeyName());
					} else {
						$table->uuid($pivotInstance->getKeyName())->primary();
					}
					$table->foreignIdFor(get_class($belongsToMany->getParent()))
						  ->constrained(
							  column: $belongsToMany->getParent()->getKeyName(),
							  indexName: $belongsToMany->getParent()->getTable().'_'.$belongsToMany->getParent()
																								   ->getKeyName().'_foreign',
						  )
						  ->cascadeOnUpdate()->cascadeOnDelete();

					foreach ($array as $relationship) {
						if ($relationship instanceof BelongsToMany) {
							$relatedClassName = get_class($relationship->getRelated());
							$instance = new $relatedClassName;
							$table->foreignIdFor($relatedClassName)
								  ->constrained(
									  column: $instance->getKeyName(),
									  indexName: $instance->getTable().'_'.$instance->getKeyName().'_foreign',
								  )
								  ->cascadeOnUpdate()->cascadeOnDelete();
						}
					}

					$table->softDeletes();
				}
			}
		});
	}
}
