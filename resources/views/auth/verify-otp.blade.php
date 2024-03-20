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
        background-color: #f4f4f4;
        display: flex;
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
    #successMessage{
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
            <div id="successMessage" class="successMessage"></div>
            <div id="errorMessage" class="error-message">
                @if (session()->has('error'))
                    {{ session('error') }}
                @endif
            </div>
            <!-- Hidden input field to store OTP value -->
            <input type="hidden" id="otpValue" name="otp">
            <button id="submitButton" type="submit">Submit</button>
            @if (session()->has('error') && session('error') === 'OTP Expired')
                <button id="resendButton" type="button">Resend OTP</button>
            @endif
        </div>
    </form>

    {{-- Toastr --}}
    <script src="{{ asset('public/assets/admin/js/toastr/toastr.min.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
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

    </script>
    <script>
    document.getElementById('resendButton').addEventListener('click', function() {
        resendOTP();
    });

    function resendOTP() {
        // Make an AJAX request to resend the OTP
        fetch('{{ route("resend.otp") }}', {
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

            if (data && data.success) {
             
            document.getElementById('successMessage').innerText = 'Otp Sent Successfully ✔';
            document.getElementById('errorMessage').innerText = '';
            } else {
           
            document.getElementById('errorMessage').innerText = 'Failed to resend OTP. Please try again later.';
            document.getElementById('successMessage').innerText = ''; 
           
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong.');
        });
    }
</script>

</body>

</html>
