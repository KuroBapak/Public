<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>

<body>
    <h1>Buat Account Baru</h1>

    <h2>Sign Up Form</h2>
    <form method="GET" action="{{ route('welcome') }}">
    <p>First Name :</p>
    <input type="text">

    <p>Last Name :</p>
    <input type="text">

    <p>Gender</p>

    <input type="radio">
    <label>Female</label>
    <br>
    <input type="radio">
    <label>Male</label>

    <p>Nationality</p>
    <select name="Country">
        <option value="Indonesia">Indonesia</option>
        <option value="English" selected>English</option>
        <option value="Japan">Japan</option>
        <option value="Korea">Other</option>
    </select>

    <p>Language Spoken</p>
    <input type="checkbox">
    <label>Bahasa Indonesia</label>
    <br>
    <input type="checkbox">
    <label>English</label>
    <br>
    <input type="checkbox">
    <label>Japan</label>
    <br>
    <input type="checkbox">
    <label>Other</label>

    <p>Bio</p>
    <textarea name="Bio" id="" cols="30" rows="10"></textarea>
    <br>
    <button type="submit"> Sign Up</button>

    </form>
</body>

</html>