<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-size: 17px;
            cursor: pointer;
            margin-top: 15px;
        }

        .btn-submit:hover {
            background-color: #2471a3;
        }

        .error-msg {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .success-msg {
            color: green;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <header>Update Your Profile</header>

    <div class="container">
        <h2>Basic Information</h2>

        @if(session('success'))
            <p class="success-msg">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{url('updateProfileInfo')}}">
            @csrf
        @if(Auth::user()->college_id == 2)
        <p style="color:red"><b>Note :</b> Please transfer your data from your institutional mail  IDs to your own personal mail IDs as the institutional IDs are likely to be disabled soon. Please do so by 15th August 2025. Please use your personal mail IDs in filling out the exam form on the Samarth Portal.</p>
        @endif
            <div class="form-group">
                <label for="father_name">Father's Name(as per 10th marksheet)<font style="color: red;"><b>*</b></font></label>
                <input type="text" id="father_name" name="father_name" required value="{{ $profile_data->father_name }}">
            </div>

            <div class="form-group">
                <label for="mother_name">Mother's Name(as per 10th marksheet)<font style="color: red;"><b>*</b></font></label>
                <input type="text" id="mother_name" name="mother_name" required value="{{ $profile_data->mother_name }}">
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth(as per 10th marksheet)<font style="color: red;"><b>*</b></font></label>
                <input type="date" id="dob" name="dob" required value="{{ $profile_data->dob }}">
            </div>

            <div class="form-group">
                <label for="gender">Gender<font style="color: red;"><b>*</b></font></label>
                <select id="gender" name="gender" required>
                    <option value="" disabled selected>-- Select Gender --</option>
                    <option value="1" {{($profile_data->gender_id == 1)?'selected':''}}>Male</option>
                    <option value="2" {{($profile_data->gender_id == 2)?'selected':''}}>Female</option>
                    <option value="3" {{($profile_data->gender_id == 3)?'selected':''}}>Trans</option>
                    <option value="4" {{($profile_data->gender_id == 4)?'selected':''}}>Rather Not Say</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Category<font style="color: red;"><b>*</b></font></label>
                <select id="category" name="category" required>
                    <option value="" disabled selected>-- Select Category --</option>
                    @foreach($category_mast as $key => $value)
                    <option value="{{$key}}"{{($profile_data->category_id == $key)?'selected':''}}>{{$value}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="email">Personal Email ID<font style="color: red;"><b>*</b></font></label>
                <input type="email" id="email" name="email" required value="{{ $profile_data->email}}">
            </div>

            <div class="form-group">
                <label for="mobile">Mobile Number<font style="color: red;"><b>*</b></font></label>
                <input type="text" id="mobile" name="mobile" required value="{{ $profile_data->contact_no }}">
            </div>

            <div class="form-group">
                <label for="current_address">Current Address<font style="color: red;"><b>*</b></font></label>
                <textarea id="current_address" name="current_address" required rows="3">{{ $profile_data->current_address }}</textarea>
            </div>

            <div class="form-group">
                <label for="permanent_address">Permanent Address<font style="color: red;"><b>*</b></font></label>
                <textarea id="permanent_address" name="permanent_address" required rows="3">{{ $profile_data->permanent_address }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Save Profile</button>
        </form>
    </div>
</body>
</html>
