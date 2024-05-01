<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/bootstrap/bootstrap.min.css') }}">

    {{-- Font Awesome CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/font-awesome/css/all.css') }}">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/toastr/toastr.min.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #D7BAC5; */
            background: url('{{ asset("public/admin_images/bg_admin.jpg") }}');
            display: flex;
            background-size: contain;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .otp-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .otp-input {
            width: 40px;
            height: 40px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 20px;
            outline: none;
        }

        .otp-input:focus {
            border-color: blue;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        #successMessage {
            color: green;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <form id="otpForm" action="{{ route('verify.otp') }}" method="POST">
        @csrf
        <div class="otp-container">
            <h2>Enter OTP</h2>
            <div id="otpInputs">
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
                <input type="text" class="otp-input" maxlength="1" required>
            </div>
            <div id="loader" class="mt-4" style="display: none;">
                <img src="{{ asset('/public/images/loader/loading.gif') }}" height="30px" width="30px"
                    alt="Loader">
            </div>
            <div id="countdownTimer" class="mt-3"></div>
            <div id="successMessage" class="successMessage mt-3"></div>
            <div id="errorMessage" class="error-message">
                @if (session()->has('error'))
                    {{ session('error') }}
                @endif
            </div>
            <!-- Hidden input field to store OTP value -->
            <input type="hidden" id="otpValue" name="otp">
            <button id="submitButton" type="submit">Submit</button>
            <button id="resendButton" type="button">Resend OTP</button>

        </div>
    </form>

    {{-- Toastr --}}
    <script src="{{ asset('public/assets/admin/js/toastr/toastr.min.js') }}"></script>


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}

    <script>
        // Variable to track if the resend button was clicked
        var resendButtonClicked = false;
        document.getElementById('resendButton').style.display = 'none';
        // Function to update the countdown timer
        function updateCountdownTimer(errorMessage = '') {

            document.getElementById('errorMessage').innerText = errorMessage;
            var startTime = "{{ session('otp_start_time') }}";
            var expiryTime = new Date("{{ session('otp.expires_at') }}").getTime();
            var currentTime = new Date().getTime();
            var timeDifference = expiryTime - currentTime;

            if (timeDifference > 0) {
                // Calculate remaining minutes and seconds
                var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                // Update the countdown timer in the UI
                document.getElementById('countdownTimer').innerText = minutes + ' minutes ' + seconds + ' seconds';

                // Hide the resend button
                document.getElementById('resendButton').style.display = 'none';

            } else {

                // Check if resend button was clicked before displaying the message
                if (!resendButtonClicked) {
                    document.getElementById('errorMessage').innerText = 'OTP Expired';
                    document.getElementById('countdownTimer').innerText = '';
                    // Show the resend button
                    document.getElementById('resendButton').style.display = 'inline-block';
                }

            }
        }

        function displayInvalidOTPMessage() {
            updateCountdownTimer('Invalid OTP');
            // Reset the message after 5 seconds
            setTimeout(function() {
                updateCountdownTimer('');
            }, 5000);
        }
        // // Check OTP expiry and update countdown timer initially
        // updateCountdownTimer();

        // Update countdown timer every second
        setInterval(function() {
            updateCountdownTimer();
        }, 1000);

        // Limit input to numbers only
        document.querySelectorAll('.otp-input').forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });

        // Focus next input on typing
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });

        // Handle form submission
        document.getElementById('submitButton').addEventListener('click', function() {
            var otp = '';
            document.querySelectorAll('.otp-input').forEach(input => {
                otp += input.value;
            });

            // Validate OTP length
            if (otp.length !== 6) {
                document.getElementById('errorMessage').innerText = 'Please enter a valid OTP.';
                return;
            }

            // Assign the OTP to the hidden input field in the form
            document.getElementById('otpValue').value = otp;

            // Submit the form
            document.getElementById('otpForm').submit();
        });

        // Resend Button
        document.getElementById('resendButton').addEventListener('click', function() {
            // Set resendButtonClicked to true when resend button is clicked
            resendButtonClicked = true;

            // Hide error message
            document.getElementById('errorMessage').innerText = '';
            resendOTP();
        });

        function resendOTP() {

            // Hide error message
            document.getElementById('errorMessage').innerText = '';

            // Show loader
            document.getElementById('loader').style.display = 'block';


            // Make an AJAX request to resend the OTP
                    fetch("{{ route('resend.otp') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})

                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to resend OTP.');
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide loader after the OTP is successfully resent
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('errorMessage').innerText = '';

                    if (data && data.success) {
                        document.getElementById('successMessage').innerText = 'Otp Sent Successfully ';
                        document.getElementById('errorMessage').innerText = '';

                        // Hide success message after 2 seconds
                        setTimeout(function() {
                            document.getElementById('successMessage').innerText = '';
                            // Update countdown timer after hiding the success message
                            updateCountdownTimer();
                        }, 2000);


                        window.location.reload();

                    } else {
                        document.getElementById('errorMessage').innerText =
                            'Failed to resend OTP. Please try again later.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong.');
                    // Hide loader in case of error
                    document.getElementById('loader').style.display = 'none';
                });
        }

        // Copy otp
        const otpInputs = document.querySelectorAll('.otp-input');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Move to the next input field if the current one is filled
                if (input.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && input.value === '') {
                    // Move to the previous input field on backspace if the current field is empty
                    otpInputs[index - 1].focus();
                }
            });
        });

        otpInputs[0].addEventListener('paste', (e) => {
            const pastedText = e.clipboardData.getData('text');

            // Distribute each character of the pasted OTP into individual input fields
            pastedText.split('').forEach((char, index) => {
                if (index < otpInputs.length) {
                    otpInputs[index].value = char;
                    if (index < otpInputs.length - 1) {
                        otpInputs[index].dispatchEvent(new Event('input'));
                    }
                }
            });

            e.preventDefault(); // Prevent default paste behavior
        });
    </script>


</body>

</html>
