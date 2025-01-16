<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        p {
            margin-bottom: 20px;
        }

        .message, .assignment {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .remarks {
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            color: red;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }

        hr {
            color: #999;
        }

        table {
            width: 70%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.5em;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f5f5f5;
        }

    </style>
</head>
<body>
    <div class="container">
        <p>Dear, <b>{{ $mailData['fullname'] }}</b></p>
        @if ($mailData['action_id'] == 1)
            <p>You have received a New Submission from <b>{{ $mailData['creator'] }}</b></p>
        @endif
        <div class="message">
            {{ $mailData['message'] }}
        </div>
        <table>
            @php
                $user = DB::table('users')->find($mailData['submission']->user_id);
                $data = DB::table('tbl_employee')->where('LoginName',$user->username)->first();
            @endphp
            <tbody>
                <tr>
                    <th>Code No</th>
                    <td>{{ $code }}</td>
                </tr>
                <tr>
                    <th>SAPID</th>
                    <td>{{ $data->SAPID }}</td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td>{{ $data->FullName }}</td>
                </tr>
                <tr>
                    <th>Company</th>
                    <td>{{ $data->companycode }}</td>
                </tr>
            </tbody>
        </table>
        @if (!empty($mailData['remarks']))
            <div class="remarks">
                Remarks : {{ ucfirst($mailData['remarks']) }}
            </div>
        @endif
        <hr>
        <p class="footer">Go To devjobportal Click <a href="{{ env('APP_URL') }}">Here</a></p>
        <p class="footer">If you require any further information, please feel free to get in touch with us.</p>
        <p class="footer">Thank you for your interest in our products/services.</p>
        <p class="footer">Best regards,<br>System Development</p>
    </div>
</body>
</html>
