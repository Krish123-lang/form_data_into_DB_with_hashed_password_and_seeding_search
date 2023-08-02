<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
</head>

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

</html>
