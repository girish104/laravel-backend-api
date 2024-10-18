<?php

namespace App\Factory;

use App\Helpers\Helper;

abstract class Factory
{
    abstract public static function getDataTable();

    public static function create($model, $data)
    {
        return Helper::safeTransaction(function () use ($model, $data) {
            return $model::create($data);
        });
    }

    public static function update(&$instance, $data)
    {
        if (empty($instance) || empty($data)) return false;
        return Helper::safeTransaction(function () use ($instance, $data) {
            return $instance->update($data);
        });
    }

    public static function destroy(&$instance)
    {
        if (empty($instance)) return false;
        return Helper::safeTransaction(function () use ($instance) {
            return $instance->delete();
        });
    }

    public static function toggleStatus(&$instance)
    {
        if (empty($instance)) return false;
        // return Helper::safeTransaction(function () use ($instance, $column) {
        return Helper::safeTransaction(function () use ($instance) {
            $column = empty(request()->type) ? 'status' : request()->type;
            $instance->{$column} = empty($instance->{$column}) ? 1 : 0;
            return $instance->save();
        });
    }

    public static function mapItems($model, $column, &$instance, $mapTo,  $items){
        // if (empty($items)) return;
        $positions = [];
        foreach (array_unique($items) as $position => $item) {
            $positions[] = $position+1;
            Helper::safeTransaction(function() use ($model, $column, $instance, $mapTo, $position, $item){
                $model::updateOrCreate(
                    [$column => $instance->id, 'position' => $position+1],
                    [$mapTo => $item]
                );
            });
        }

        static::removeExtraItems($model, $column, $instance, $positions);
    }

    public static function removeExtraItems($model, $column,  &$instance, $positions){
        Helper::safeTransaction(function() use ($model, $column,  $instance, $positions){
            $query = $model::where($column, $instance->id);
            if(!empty($positions)):
                $query->whereNotIn('position', $positions);
            endif;
            $query->delete();
        });
    }

}
