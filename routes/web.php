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

    $persons = Person::all();
    $person = Person::where('age', '>', 50)->get();

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

    echo 'first: <br/>';
    echo $collection->first();
    echo '<br/><br/>';

    echo 'first > 3: <br/>';
    echo $collection->first(function ($value, $key) {
        return $value > 3;
    });
    echo '<br/><br/>';

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

    echo 'contains 3: <br/>';
    echo $collection->contains(3);
    echo '<br/><br/>';

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

    echo 'first person: <br/>';
    echo $persons->first();
    echo '<br/><br/>';

    echo 'first person whose likes are < 15: <br/>';
    echo $persons->first(function ($person, $key) {
        return $person->likes < 15;
    });
    echo '<br/><br/>';

    echo 'contains person older than 50: <br/>';
    echo $persons->contains(function ($person) {
        return $person->age > 50;
    });
    echo '<br/><br/>';

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

    echo 'get average/max age, average/max likes: <br/>';
    echo 'Average ages: ' . $persons->avg('age') . '<br/>';
    echo 'Average likes: ' . $persons->avg('likes') . '<br/>';
    echo 'Max age: ' . $persons->max('age') . '<br/>';
    echo 'Max likes: ' . $persons->max('likes') . '<br/>';
    echo '<br/>';

    echo 'when account is user: <br/>';
    $collection4 = collect([
        ['account_id' => 1, 'name' => 'Mark', 'account_type' => 'admin'],
        ['account_id' => 2, 'name' => 'Jane', 'account_type' => 'user'],
        ['account_id' => 3, 'name' => 'George', 'account_type' => 'power_user'],
        ['account_id' => 4, 'name' => 'Ian', 'account_type' => 'user']
    ]);
    $map = $collection4->map(function ($person, $key) use ($collection4) {
        $collection4->when($person['account_type'] == 'user', function ($collection) {
            return $collection->pluck('name');
        });
    });
    echo $map;
});

Route::get('/db2', function () {
    $persons = Person::all();

    echo 'filter than pluck: <br/>';
    $age32 = $persons->filter(function ($item) {
        return $item->age == 32;
    })->pluck('name')->all();
    foreach ($age32 as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'get oldest person: <br/>';
    $sorted = $persons->sortByDesc('age')->first();
    echo $sorted;
    echo '<br/>';
    // foreach ($sorted as $person) {
    //     echo $person . '<br>';
    // }
    echo '<br/>';

    echo 'get number of peoples with names: <br/>';
    $counted = $persons->countBy(function ($person) {
        return $person->name;
    });
    echo $counted;
    echo '<br/>';

    echo 'get oldest person between 30 and 50 years old: <br/>';
    $filtered = $persons->reject(function ($value, $key) {
        return $value->age < 30 || $value->age > 50;
    })->sortByDesc('age');
    foreach ($filtered as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'get first 3 youngest persons: <br/>';
    $filtered = $persons->sortBy('age')->take(3);
    foreach ($filtered as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'get first 3 youngest persons with most likes: <br/>';
    $sorted = $persons->sortBy('age')->take(3)->sortByDesc('likes');
    foreach ($sorted as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'get people with likes: <br/>';
    $filtered = $persons->filter(function ($person, $key) {
        return $person->likes > 0;
    });
    foreach ($filtered as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'get people: <br/>';
    $multiplied = $persons->map(function ($person) use ($persons) {
        $otherPersons = $persons->reject(function ($value) use ($person) {
            return $value->id == $person->id;
        });
        $tmp = $otherPersons->map(function ($item) use ($person) {
            $temp = [
                'name' => $person->name,
                'against' => $item->name,
                'diff' => abs($person->likes - $item->likes)
            ];
            return $temp;
        });
        return $tmp;
    });
    //dd($multiplied);
    foreach ($multiplied as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'get person with most likes: <br/>';
    $filtered = $persons->filter(function ($person, $key) use ($persons) {
        return $person->likes == $persons->max('likes');
    });
    foreach ($filtered as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'get person with min likes: <br/>';
    $filtered = $persons->filter(function ($person, $key) use ($persons) {
        return $person->likes == $persons->min('likes');
    });
    foreach ($filtered as $person) {
        echo $person . '<br>';
    }
    echo '<br/>';

    echo 'map to groups (likes => name): <br/>';
    $grouped = $persons->mapToGroups(function ($item, $key) {
        return [$item['likes'] => $item['name']];
    });
    $grouped->toArray();
    foreach ($grouped as $likes => $name) {
        echo $likes . ' => ' . $name . '<br/>';
    }
    echo '<br/>';
});

Route::get('/db3', function () {
    $persons = Person::all();

    echo 'get peoples with same names: <br/>';
    $namesCount = $persons->countBy(function ($person) {
        return $person->name;
    });
    $filtered = $persons->filter(function ($value, $key) use ($namesCount) {
        return $namesCount[$value->name] > 1;
    });
    foreach ($filtered as $name) {
        echo $name . '<br>';
    }
    echo '<br/>';

    echo 'get peoples who are older: <br/>';
    $multiplied = $persons->mapWithKeys(function ($person) use ($persons) {
        $filtered = $persons->filter(function ($value, $key) use ($person) {
            return $value->age > $person->age;
        });
        return [$person->id => $filtered];
    });
    // dd($multiplied);
    $names = $persons->mapWithKeys(function ($person) {
        return [$person->id => [$person->name, $person->age]];
    });
    foreach ($multiplied as $index => $value) {
        echo 'name: ' . $names[$index][0] . ', age: ' . $names[$index][1] . '</br>';
        foreach ($value as $test) {
            echo $test . '<br>';
        }
    }
    echo '<br/>';

    echo 'map to groups (sorted by likes) : <br/>';
    $grouped = $persons->sortBy('likes')->mapToGroups(function ($item, $key) {
        return [$item['likes'] => $item['name']];
    });
    $grouped->toArray();
    foreach ($grouped as $likes => $name) {
        echo $likes . ' => ' . $name . '<br/>';
    }
    echo '<br/>';

    echo 'add languages: </br>';
    $languages = [['C', 'C++'], ['PHP'], ['Javascript'], ['C#', 'APS', '.NET'], ['GO', 'Erlang'], ['JAVA'], ['React', 'Vue', 'Angular']];
    $lang = $persons->map(function ($item, $key) use ($languages) {
        return [$item->name => $languages[$item->id - 1]];
    });

    $lang->each(function ($item, $key) {
        echo array_keys($item)[0] . ' knows: ' . implode(', ', array_values($item[array_keys($item)[0]])) . '</br>';
    });
    echo '<br/>';

    echo 'add languages: </br>';
    $languages = [['C', 'C++'], ['PHP'], ['Javascript'], ['C#', 'APS', '.NET'], ['GO', 'Erlang'], ['JAVA'], ['React', 'Vue', 'Angular']];
    $lang = $persons->map(function ($item, $key) use ($languages) {
        return [$item->id => $languages[$item->id - 1]];
    });

    $lang->each(function ($item, $key) {
        $name = Person::where('id', $key + 1)->pluck('name')->first();
        echo $name . ' knows: ' . implode(', ', array_values($item[$key + 1])) . '</br>';
    });
    echo '<br/>';
});
