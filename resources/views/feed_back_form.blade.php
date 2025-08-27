<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Faculty Feedback Form</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    :root {
      --input-height: 40px;
      --input-radius: 8px;
      --input-border: 1px solid #d1d5db;
      --focus-border: #2980b9;
      --placeholder-color: #9ca3af;
      --text-color: #243242;
      --bg: #ffffff;
    }

    body {
      background: linear-gradient(135deg,#e6f3ff 0%, #ffffff 100%);
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      padding: 10px;
      display: flex;
      justify-content: center;
    }

    .container {
      width: 100%;
      max-width: 720px;
      background: var(--bg);
      padding: 28px;
      border-radius: 14px;
      box-shadow: 0 12px 30px rgba(20,30,60,0.08);
    }

    h2 { text-align:center; color:#15324a; margin-bottom: 18px; font-size:22px; }

    .form-group { margin-bottom: 16px; }
    .form-group label { display:block; margin-bottom:8px; font-weight:600; color:#244055; }

    /* regular input styles */
    input[type="text"],
    input[type="tel"],
    textarea,
    .form-select {
      width: 100%;
      padding: 8px 8px;
      height: var(--input-height);
      border: var(--input-border);
      border-radius: var(--input-radius);
      font-size: 15px;
      color: var(--text-color);
      box-sizing: border-box;
    }

    textarea { height: 140px; padding-top:12px; padding-bottom:12px; resize:vertical; }

    input:focus, textarea:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(41,128,185,0.06);
      border-color: var(--focus-border);
    }

    .btn-submit {
      margin-top: 10px;
      width: 100%;
      height: 48px;
      border-radius: 10px;
      background: linear-gradient(90deg,#2b83c9,#40a2df);
      color: #fff;
      border: none;
      font-weight: 700;
      cursor: pointer;
    }

    /* ===== SELECT2 STYLE OVERRIDES ===== */

    /* make the Select2 container full width like inputs */
    .select2-container { width: 100% !important; font-size: 15px; }

    /* selection box styling similar to inputs */
    .select2-container--default .select2-selection--single {
      height: var(--input-height);
      padding: 6px 12px;
      border: var(--input-border);
      border-radius: var(--input-radius);
      display: flex;
      align-items: center;
      box-sizing: border-box;
      background: var(--bg);
    }

    /* rendered text alignment & placeholder color */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: var(--text-color);
      line-height: 1;
      margin: 0;
      padding: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
      color: var(--placeholder-color);
    }

    /* down arrow vertical alignment and spacing */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: calc(var(--input-height));
      right: 10px;
      top: 0;
      width: 28px;
    }

    /* focus/open states */
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:hover {
      border-color: var(--focus-border);
      box-shadow: 0 0 0 4px rgba(41,128,185,0.06);
    }

    /* dropdown options styling */
    .select2-container--default .select2-results__option {
      padding: 9px 12px;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background-color: rgba(41,128,185,0.08);
      color: var(--text-color);
    }

    /* small touch up for mobile (makes touch area bigger) */
    @media (max-width:420px){
      .select2-container--default .select2-selection--single { padding-left:10px; padding-right:36px; }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Feedback Form</h2>

    @if(session('success'))
      <p class="success-msg">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ url('submitFeedback') }}" id="feedbackForm">
      @csrf

      <div class="form-group">
        <label for="faculty_name">Name of the Faculty</label>
        <input type="text" name="faculty_name" id="faculty_name" required placeholder="Enter Name">
      </div>

      <div class="form-group">
        <label for="college_name">College Name</label>
        <!-- placeholder is read from the empty option, Select2 will use it -->
        <select class="form-select single-select-clear-field" name="college_name" id="college_name" required>
          <option value="">Select College</option>
          @foreach ($college_mast as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="department">Department</label>
        <select class="form-select single-select-clear-field" name="department" id="department" required>
          <option value="">Search or select a department</option>
          @foreach ($department_data as $key => $value)
            <option value="{{ $value }}">{{ $value }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="mobile_number">Mobile Number</label>
        <input type="tel" name="mobile_number" id="mobile_number" maxlength="10" pattern="[0-9]{10}" required placeholder="Enter Mobile no.">
      </div>

      <div class="form-group">
        <label for="feedback">Feedback / Suggestion</label>
        <textarea name="feedback" id="feedback" placeholder="Write Your Feedback" required></textarea>
      </div>

      <button type="submit" class="btn-submit">Submit Feedback</button>
    </form>
  </div>

  <!-- jQuery and Select2 scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(function () {
      // Initialize all selects with this class in one place
      $('.single-select-clear-field').select2({
        placeholder: function(){
          // use placeholder from the first empty option if present
          var ph = $(this).find('option[value=""]').text();
          return ph ? ph : "Select";
        },
        allowClear: true,
        width: '100%'
      });

      // form submit handling (example: simple mobile validation)
      $('#feedbackForm').on('submit', function (e) {
        var mobile = $('#mobile_number').val().trim();
        if (!/^[0-9]{10}$/.test(mobile)) {
          e.preventDefault();
          alert('Please enter a valid 10-digit mobile number.');
          return false;
        }
        // allow native form submit (server-side will handle it)
      });
    });
  </script>
</body>
</html>
