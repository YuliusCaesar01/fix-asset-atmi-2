<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Token</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f9fc; /* Light background color */
            margin: 0;
            padding: 0;
        }

.email-footer {
    background-color: #007cba; /* Monday.com primary color */
    padding: 15px;
    text-align: center;
    font-size: 12px;
    color: white; /* White text for contrast */
    display: flex;
    justify-content: center; /* Center content horizontally */
    gap: 20px; /* Space between the items */
}

.email-footer a {
    color: white; /* White links to match the footer background */
    text-decoration: none;
}

.contact-info {
    display: flex; /* Use flex instead of inline-flex */
    justify-content: center; /* Align items horizontally */
    align-items: center; /* Align items vertically */
    gap: 20px; /* Space between items */
}

.email-footer p {
    margin: 0 10px;
    white-space: nowrap; /* Prevent text from wrapping */
}



        .email-header {
            background-color: #007cba; /* Monday.com primary color */
            padding: 30px; /* Increased padding for a more spacious header */
            text-align: center;
            color: white;
        }

        .email-header img {
                max-width: 180px; /* Slightly larger logo width */
                height: auto;
                margin-bottom: 10px;
                border-radius: 4px; /* Optional: add slight rounding */
            }


        .email-header h1 {
            margin: 10px 0; /* Increased margin for better spacing */
            font-size: 22px; /* Increased size for visibility */
        }

        .email-body {
            padding: 30px;
            text-align: left; /* Align text to the left for better readability */
            font-size: 16px; /* Base font size */
            color: #333; /* Darker text color for contrast */
            line-height: 1.6; /* Increased line height for readability */
        }

        h2 {
            font-size: 24px; /* Slightly larger heading */
            color: #007cba; /* Primary color for the heading */
            margin: 0 0 20px;
        }

        p {
            margin: 10px 0;
        }

        .token {
            font-size: 24px;
            font-weight: bold;
            color: #007cba; /* Highlight token color */
            background-color: #e7f4ff; /* Light background for the token */
            padding: 15px; /* Increased padding */
            border-radius: 4px;
            display: inline-block;
            margin: 20px auto; /* Centered with margin */
            text-align: center; /* Centered text */
            width: fit-content; /* Fit the width to content */
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007cba;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            margin: 20px auto; /* Centered button */
            transition: background-color 0.3s;
            text-align: center; /* Center button text */
        }

        

        .email-footer {
            background-color: #f7f7f7; /* Light footer background */
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .email-footer a {
            color: #007cba;
            text-decoration: none;
        }

      

        .contact-info {
            font-size: 14px;
            color: #555; /* Slightly darker for better visibility */
            margin-top: 10px;
        }

        small {
            display: block; /* Small text in its own line */
            margin-top: 10px;
            color: #555; /* Slightly darker for better visibility */
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 20px; /* Adjust padding for mobile */
            }

            h2 {
                font-size: 20px; /* Adjust heading size for mobile */
            }

            p {
                font-size: 14px; /* Adjust paragraph size for mobile */
            }

            .btn {
                padding: 10px 20px; /* Adjust button size for mobile */
                font-size: 14px; /* Adjust font size for mobile */
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="http://localhost:8080/fixaset.png" alt="Company Logo"> <!-- Replace with your logo URL -->
            <h1>Fixed Asset ATMI</h1> <!-- Instance name -->
        </div>
        <div class="email-body">
            <h2>Halo, {{ $user->name }}!</h2>
            <p>Untuk memverifikasi akun Anda, silakan verifikasi berikut:</p>
        
            <a href="{{ url('password/reset', $token) }}" class="btn">Verifikasi Sekarang</a>
            
            <small>Jika Anda tidak melakukan permintaan ini, Anda dapat mengabaikan email ini.</small>
            <small>Salam hangat, Tim IT ATMI</small>
        </div>
        <div class="email-footer">
            <div class="contact-info">
                <p>Email: <a href="mailto:itatmicorp@gmail.com">itatmicorp@gmail.com</a></p>
                <p>Staff Email: <a href="mailto:daniel@atmi.co.id">daniel@atmi.co.id</a></p>
                <p>No. Telp: +(62) 271-714466</p>
            </div>
        </div>
        
        
    </div>
</body>
</html>
