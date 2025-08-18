<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Student Details</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 20px; padding: 0;">
    <div
        style="width: 600px;margin:0 auto;background-color: #ffffff; padding: 20px; border-collapse: collapse; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <table style="width: 100%;">
            <tr>
                <td colspan="2">
                    <h4 style="text-align: center">Student Details:-</h4>
                </td>
            </tr>
            <tr>
                <td>Course</td>
                <td>: {{ $student->studentcourse?->course?->course_name }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>: {{ $student->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{ $student->email }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>: {{ $student->phone }}</td>
            </tr>
            <tr>
                <td>Alternate Phone</td>
                <td>: {{ $student->phone_2 }}</td>
            </tr>
            <tr>
                <td>Age</td>
                <td>: {{ $student->age }}</td>
            </tr>
            <tr>
                <td>Current Country</td>
                <td>: {{ $student->country?->name }}</td>
            </tr>
            <tr>
                <td>Current State</td>
                <td>: {{ $student->state?->name }}</td>
            </tr>
            <tr>
                <td>Current City</td>
                <td>: {{ $student->city }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
