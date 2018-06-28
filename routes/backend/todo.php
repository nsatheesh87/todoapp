<?php

/**
 * All route names are prefixed with 'admin.todo'.
 */
Route::group([
    'prefix'     => 'todo',
    'as'         => 'todo',
], function () {

        /*
         * Todo Management
         */

    Route::resource('task', 'TodoController');
});

