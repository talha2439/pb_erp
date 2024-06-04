<?php
namespace App\Trait;

use Illuminate\Support\Facades\Schema;

trait Crud {
    public static function columns($table){
        $columns = Schema::getColumnListing($table);
        return $columns;
    }

}
