<?php

namespace YazeedObaid\Jsonable;


use Illuminate\Database\Eloquent\Builder;

trait Jsonable
{

    /**
     * @param Builder $query
     * @param string $jsonPath
     * @param string $column
     * @param string $needle
     * @return $this|Builder
     */
    public function scopeJsonContains(Builder $query, $column, $jsonPath, $needle)
    {
        $table = $query->getModel()->getTable();

        $path = "$table.$column->'$.$jsonPath'";

        $query = $query->whereRaw("JSON_CONTAINS($path, '$needle')");

        return $query;
    }


    /**
     * @param Builder $query
     * @param string $jsonPath
     * @param string $column
     * @param string $needle
     * @return $this|Builder
     */
    public function scopeOrJsonContains(Builder $query, $column, $jsonPath, $needle)
    {
        $table = $query->getModel()->getTable();

        $path = "$table.$column->'$.$jsonPath'";

        $query = $query->orWhereRaw("JSON_CONTAINS($path, '$needle')");

        return $query;
    }


    /**
     * @param Builder $query
     * @param string $column
     * @param string $jsonPath
     * @return Builder|\Illuminate\Database\Query\Builder|static
     */
    public function scopeJsonExtract(Builder $query, $column, $jsonPath)
    {
        $table = $query->getModel()->getTable();

        $jsonColumn = "$table.$column";
        $path = "'$.$jsonPath'";

        $query = $query->selectRaw("JSON_UNQUOTE(JSON_EXTRACT($jsonColumn, $path)) AS jsonResult");

        return $query;

    }


    /**
     * @param Builder $query
     * @param string $column
     * @param null $nestedKey
     * @return Builder|\Illuminate\Database\Query\Builder|static
     */
    public function scopeJsonKeys(Builder $query, $column, $nestedKey = null)
    {
        $table = $query->getModel()->getTable();

        $jsonColumn = "$table.$column";

        if (is_null($nestedKey)) {
            $query = $query->selectRaw("JSON_UNQUOTE(JSON_KEYS($jsonColumn)) AS jsonResult");
        } else {
            $nestedKey = "'$.$nestedKey'";
            $query = $query->selectRaw("JSON_UNQUOTE(JSON_KEYS($jsonColumn, $nestedKey)) AS jsonResult");
        }


        return $query;
    }


    public function scopeJsonSearch(Builder $query, $column, $oneOrAll = 'one', $needle = null, $jsonPath = null)
    {
        $table = $query->getModel()->getTable();

        $jsonColumn = "$table.$column";

        if (!is_null($jsonPath)) {
            $jsonColumn = $jsonColumn . "->'$.$jsonPath'";
        }

        switch ($oneOrAll) {
            case 'one':
                $query = $query->selectRaw("JSON_UNQUOTE(JSON_SEARCH($jsonColumn, 'one', '$needle')) AS jsonResult");
                break;
            case 'all':
                $query = $query->selectRaw("JSON_UNQUOTE(JSON_SEARCH($jsonColumn, 'all', '$needle')) AS jsonResult");
                break;
        }

        return $query;

    }

}