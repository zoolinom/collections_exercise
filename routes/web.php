<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Person;

Route::get('/', function () {
    // return view('welcome');

    $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

    echo 'Average: ' . $collection->avg();
    echo '<br/>';
    echo '<br/>';

    echo 'Number of items: ' . $collection->count();
    echo '<br/>';
    echo '<br/>';

    $collection = collect([1, 1, 3, 4, 5, 5, 5, 8, 9, 10]);
    $count = $collection->countBy()->all();
    foreach ($count as $key => $value) {
        echo $key . '->' . $value . '<br>';
    }
    echo '<br/>';

    $collection->each(function ($item, $key) {
        echo 'each: ' . $item * 2 . '<br/>';
    });
    echo '<br/>';

    echo 'every: ' . $collection->every(function ($value, $key) {
        return $value > 0;
    });
    echo '<br/>';

    echo 'except: <br/>';
    $collection2 = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);
    $filtered = $collection2->except(['price', 'discount']);
    $fil = $filtered->all();
    foreach ($fil as $key => $value) {
        echo $key . '->' . $value . '<br>';
    }
    echo '<br/>';

    echo 'filtered: <br/>';
    $fil = $collection->filter(function ($value, $key) {
        return $value > 5;
    })->all();
    foreach ($fil as $key => $value) {
        echo $key . '->' . $value . '<br>';
    }
    echo '<br/>';

    echo 'firstWhere: <br/>';
    $collection3 = collect([
        ['name' => 'Regena', 'age' => 57],
        ['name' => 'Linda', 'age' => 14],
        ['name' => 'Diego', 'age' => 23],
        ['name' => 'Linda', 'age' => 84],
    ]);
    $first = $collection3->firstWhere('name', 'Linda');
    foreach ($first as $key => $value) {
        echo $key . '->' . $value . '<br>';
    }
    echo '<br/>';

    $first = $collection3->firstWhere('age', '>', '23');
    foreach ($first as $key => $value) {
        echo $key . '->' . $value . '<br>';
    }
    echo '<br/>';

    echo 'groupBy: <br/>';
    $collection4 = collect([
        ['account_id' => 1, 'name' => 'Mark', 'account_type' => 'admin'],
        ['account_id' => 2, 'name' => 'Jane', 'account_type' => 'user'],
        ['account_id' => 3, 'name' => 'George', 'account_type' => 'power_user'],
        ['account_id' => 4, 'name' => 'Ian', 'account_type' => 'user']
    ]);
    $grouped = $collection4->groupBy('account_type')->all();
    foreach ($grouped as $key => $value) {
        echo $key . '->' . $value . '<br>';
    }
    echo '<br/>';

    echo 'map: <br/>';
    $multiplied = $collection->map(function ($item, $key) {
        return $item * 2;
    })->all();
    foreach ($multiplied as $value) {
        echo $value . '<br>';
    }
    echo '<br/>';

    echo 'pluck: <br/>';
    $plucked = $collection4->pluck('name')->all();
    foreach ($plucked as $value) {
        echo $value . '<br>';
    }
    echo '<br/>';

    echo 'reject: <br/>';
    $filtered = $collection->reject(function ($value, $key) {
        return $value > 4;
    })->all();
    foreach ($filtered as $key => $value) {
        echo $value . '<br>';
    }
    echo '<br/>';
});

Route::get('/db', function () {

    $persons = Person::all();

    echo 'groupBy age: <br/>';
    $groupAge = $persons->groupBy('age')->all();
    foreach ($groupAge as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'filter age greater than 30: <br/>';
    $ageGreatherThan30 = $persons->filter(function ($item) {
        return $item->age > 30;
    });
    foreach ($ageGreatherThan30 as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'where name is Mark: <br/>';
    $names = $persons->where('name', 'Mark')->all();
    foreach ($names as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'whereBetween age 30 - 60: <br/>';
    $ageBetween = $persons->whereBetween('age', [30, 60]);
    foreach ($ageBetween as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'pluck name: <br/>';
    $nameAge = $persons->pluck('name')->all();
    foreach ($nameAge as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'pluck name(key) => age(value): <br/>';
    $nameAge = $persons->pluck('age', 'name')->all();
    foreach ($nameAge as $key => $person) {
        echo $key . ' -> ' . $person . '<br>';
    }
    echo '<br/>';

    echo 'reduce, sum of ages: ';
    $total = $persons->reduce(function ($carry, $item) {
        return $carry + $item->age;
    });
    echo $total;
    echo '<br/>';

    echo 'reject if name is Mark: <br/>';
    $rejectedNames = $persons->reject(function ($person) {
        return $person->name == 'Mark';
    })->all();
    foreach ($rejectedNames as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'map, increase age by 1: <br/>';
    $persons2 = clone $persons;
    $changedAges = $persons2->map(function ($person) {
        $per = $person;
        ++$per->age;
        return $per;
    })->all();
    foreach ($changedAges as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'transform, increase age by 1: <br/>';
    $persons3 = clone $persons;
    $changedItems = $persons3->transform(function ($person) {
        $per = $person;
        ++$per->age;
        return $per;
    })->all();
    foreach ($changedItems as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'map, increase age by 1: <br/>';
    $persons4 = clone $persons;
    $changedAges = $persons4->map(function ($person) {
        $per = $person;
        ++$per->age;
        return $per;
    })->all();
    foreach ($changedAges as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

});
