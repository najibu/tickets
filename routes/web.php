<?php

use Illuminate\Support\Facades\Route;

Route::view('/docs', 'scribe.index')->name('public_docs');
