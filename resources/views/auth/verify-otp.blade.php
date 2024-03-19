<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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
            <div id="errorMessage" class="error-message"></div>
            <!-- Hidden input field to store OTP value -->
            <input type="hidden" id="otpValue" name="otp">
            <button id="submitButton" type="button">Submit</button>
        </div>
    </form>
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
</body>

</html>
