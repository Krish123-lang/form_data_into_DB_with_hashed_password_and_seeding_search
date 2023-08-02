# saving_user_form_data_into_DB_with_hashed_password

`php artisan make:model Registration -mcr`

## web.php
use App\Http\Controllers\RegistrationController;\
Route::resource('/', RegistrationController::class);

## resources/views/form.blade.php
<body>
    @if (session()->has('success'))
        <b>{{ session()->get('success') }}</b>
    @endif
    
    <form action="{{ url('/') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="name" value="{{ old('name') }}"><br>
        <span>
            @error('name')
                {{ $message }}
            @enderror
        </span><br>
        <input type="email" name="email" placeholder="email" value="{{ old('email') }}"><br>
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
    </form>
</body>

## database/migrations
 $table->id();\
$table->string('name');\
$table->string('email');\
$table->string('password');\
$table->timestamps();

## app\Http\Controllers\RegistrationController.php
public function index()\
    {\
        return view('form');\
    }\

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

## app\Models\Registration.php
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
