<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zara Shop</title>
    <style>
        body {
            margin: 0;
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }

        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        b,
        strong {
            font-weight: bolder;
        }
    </style>
</head>

<body style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background-color: #e9ecef; margin: 0;">
    <div style="width: 420px">
        <div style="font-size: 2.1rem; font-weight: 300; margin-bottom: 0.9rem; text-align: center;">
            <a style="color: #495057" href="#"><b>Zara</b></a>
        </div>
        <div style="margin-bottom: 0; box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2); position: relative; display: flex; flex-direction: column; min-width: 0; word-wrap: break-word; background-color: #fff; background-clip: border-box; border: 0 solid rgba(0, 0, 0, 0.125); border-radius: 0.25rem;">
            <div style="border-radius: 0.25rem 0.25rem 0 0; background-color: #28a745; color: #fff; text-align: center; padding: 0.75rem 1.25rem; margin-bottom: 0;">
                <h3 style="font-size: 1.1rem; font-weight: 400; margin: 0;">Your Payment PIN</h3>
            </div>
            <div style="flex: 1 1 auto; min-height: 1px; padding: 1.25rem;">
                <p style="text-align: center !important; font-size: 1.25rem; font-weight: 300;">
                    Your payment PIN is: <strong>{{ $pin }}</strong>
                </p>
                <div style="position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem; color: #1f2d3d; background-color: #ffc107; border-color: #edb100; text-align: center !important;">
                    Keep this PIN secure and do not share it with anyone.
                </div>
            </div>
            <div style="padding: 0.75rem 1.25rem; background-color: rgba(0, 0, 0, 0.03); border-top: 0 solid rgba(0, 0, 0, 0.125); text-align: center !important; border-radius: 0 0 calc(0.25rem - 0) calc(0.25rem - 0);">
                <p>If you did not request this PIN, please ignore this email.</p>
                <hr style="border: none; border-top: 1px solid rgba(73, 70, 70, 0.3);">
            </div>
        </div>
    </div>
</body>

</html>