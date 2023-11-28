<?php

namespace App\Tables;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilesTable extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        $searchByFileName = AllowedFilter::callback('global', function (Builder $query, $value) {
            $query->where(function (Builder $query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        // user's file name
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        // real file name
                        ->orWhereHas(
                            'media',
                            fn(Builder $q) => $q->where('name', 'LIKE', "%{$value}%")
                        );
                });
            });
        });

        return QueryBuilder::for(File::class)
            ->defaultSort('-id')
            ->allowedFilters([$searchByFileName]);
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(columns: ['id'])
            ->column('id', sortable: true)
            ->column('computedName', 'Name')
            ->column('media_size', 'Size')
            ->column('media_ext', 'Extension')
            ->column('media_preview', 'Preview')
            ->column('download_link', 'Download')
            ->column('actions')
            ->searchInput('name')
            ->paginate(50);
    }
}
