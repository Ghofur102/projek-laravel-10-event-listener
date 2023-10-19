<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        /* style.css */
        body {
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            width: 300px;
        }

        h1 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input,
        textarea {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        /* style.css */
        .alert {
            padding: 15px;
            background-color: #f44336;
            color: white;
            border-radius: 5px;
            margin: 10px 0;
        }

        .success {
            background-color: #4CAF50;
        }

        .danger {
            background-color: #f44336;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
</head>

<body>
    <div class="register-container">
        @if (session()->has('error'))
        <div class="alert danger">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ session('error') }}.
        </div>
        @endif
        @if (session()->has('success'))
        <div class="alert success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ session('success') }}.
        </div>
        @endif
        <h1>Register</h1>
        <form action="{{ route('process.register') }}" method="POST">
            @csrf
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Name">
            <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
            <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Password">
            <textarea id="biodata" name="biodata" value="{{ old('biodata') }}" placeholder="Biodata"></textarea>
            <button type="submit">Register</button>
            <a href="{{ route('login') }}" style="text-decoration: none;">Login</a>
        </form>
    </div>
</body>

</html>
