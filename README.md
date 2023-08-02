# saving_user_form_data_into_DB_with_hashed_password

`php artisan make:model Registration -mcr`

## web.php
```
use App\Http\Controllers\RegistrationController;
Route::resource('/', RegistrationController::class);
```
## resources/views/form.blade.php
```
<body>
    @if (session()->has('success'))
        <b>{{ session()->get('success') }}</b>
    @endif
    
    <form action="{{ url('/') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="name"><br>
        <span>
            @error('name')
                {{ $message }}
            @enderror
        </span><br>
        <input type="email" name="email" placeholder="email"><br>
        <span>
            @error('email')
                {{ $message }}
            @enderror
        </span><br>
        <input type="password" name="password" placeholder="password"><br>
        <span>
            @error('password')
                {{ $message }}
            @enderror
        </span><br>
        <input type="password" name="confirm_password" placeholder="confirm password"><br>
        <span>
            @error('confirm_password')
                {{ $message }}
            @enderror
        </span><br>

        <input type="submit" value="Submit">
    </form> <br>

    <table border="1px">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $dt)
                <tr>
                    <th> {{ $dt->id }} </th>
                    <td> {{ $dt->name }} </td>
                    <td> {{ $dt->email }} </td>
                    <td> {{ $dt->password }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
```
## database/migrations
```
 $table->id();
$table->string('name');
$table->string('email');
$table->string('password');
$table->timestamps();
```
## app\Http\Controllers\RegistrationController.php
```
public function index()
    {
        // FOR SHOWING DATA IN INDEX PAGE
        $data = Registration::all();
        return view('form', ['data' => $data]);
    }

    public function store(Request $request)
    {
        // validations
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]
        );

        Registration::create($request->all());
        return redirect('/')->withSuccess('Added successfully!');
        // print_r($request->all());
    }
```
## app\Models\Registration.php
```
use HasFactory;

    protected $fillable = ['name', 'email', 'password'];

    public function setPasswordAttribute($password)
    {
        // for automatic password hashing 
        if (trim($password) === "") {
            return;
        }
        $this->attributes['password'] = Hash::make($password);
    }
```
## For Seeding
``` * php artisan make:seeder RegistrationSeeder ```

```
=== database/seeders/RegistrationSeeder.php

// Added manually
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('registrations')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'password' => Hash::make('password'),
        ]);
       // FOR CREATING/SEEDING MULTIPLE DATA
        // for ($i = 0; $i < 10; $i++) {
        //     DB::table('registrations')->insert(
        //         [
        //             'name' => Str::random(10),
        //             'email' => Str::random(10) . '@gmail.com',
        //             'password' => Hash::make('password'),
        //         ]
        //     );
        // }
    }
}
```

`* php artisan migrate:fresh --seed --seeder=RegistrationSeeder`
#### Seeding without deleting previous data
`* php artisan migrate --seed --seeder=RegistrationSeeder`
