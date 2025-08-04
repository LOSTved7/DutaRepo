<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NOC Application Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            min-height: 100vh;
        }
    </style>
</head>
<body>

<div class="flex items-start justify-center min-h-screen pt-10 px-4 pb-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-3xl">
        @if ($application)
            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">✅ NOC Application Verified</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800 mb-8">
                <div>
                    <p><strong>👤 Student Name:</strong> {{ $application->student_name }}</p>
                    <p><strong>📘 Course:</strong> {{ $application->course_name }}</p>
                    <p><strong>🧾 Reference No.:</strong> {{ $application->reference_no }}</p>
                </div>
                <div>
                    <p><strong>🕒 Application Date/Time:</strong> {{ \Carbon\Carbon::parse($application->created_at)->format('d-m-Y h:i A') }}</p>
                    <p><strong>📅 Generation Date/Time:</strong> {{ \Carbon\Carbon::parse($application->verified_at)->format('d-m-Y h:i A')}}</p>
                    <p><strong>🏢 Company:</strong> {{ $application->company_name }}</p>
                </div>
            </div>

            <hr class="my-6 border-t-2 border-indigo-200">

            <div class="mt-4">
                <h3 class="text-xl font-semibold text-indigo-600 mb-2">🔎 About Us</h3>
                <p class="text-gray-700 leading-relaxed">
                    This verification page is part of <strong>UniOne ERP System</strong>, designed to simplify academic and administrative workflows.
                    NOC applications, internships, and certifications are processed digitally with full transparency and authenticity.
                    QR codes are uniquely generated and verified through this platform for each approved application.
                </p>
            </div>

            <div class="text-center mt-8">
                <p class="text-sm text-gray-500">Copyright © {{date('Y')}}. All rights reserved by UniOne ERP Solutions.</p>
            </div>
        @else
            <h2 class="text-3xl font-bold text-center text-red-600 mb-6">⚠️ NOC Record Not Found</h2>

            <div class="text-center text-gray-700 text-lg">
                <p>The NOC you are trying to verify does not exist in our official records.</p>
                <p class="mt-2">Please ensure that the reference number is correct, or contact the issuing authority for clarification.</p>
            </div>

            <hr class="my-6 border-t-2 border-indigo-200">

            <div class="mt-4">
                <h3 class="text-xl font-semibold text-indigo-600 mb-2">🔎 About Us</h3>
                <p class="text-gray-700 leading-relaxed">
                    This verification page is part of <strong>UniOne ERP System</strong>, designed to simplify academic and administrative workflows.
                    NOC applications, internships, and certifications are processed digitally with full transparency and authenticity.
                    QR codes are uniquely generated and verified through this platform for each approved application.
                </p>
            </div>

            <div class="text-center mt-8">
                <p class="text-sm text-gray-500">Copyright © {{date('Y')}}. All rights reserved by UniOne ERP Solutions.</p>
            </div>
        @endif
    </div>
</div>

</body>
</html>
