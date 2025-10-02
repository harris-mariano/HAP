<!doctype html>
<html>
<body style="font-family: sans-serif; min-height: 100vh; display: flex;">
    <div style="width: 100%; padding: 2.5rem; display: flex; flex-direction: column; align-items: center;">
        <div style="width: 100%; border-radius: 0.25rem; display: flex; flex-direction: column; gap: 5px; padding: 2rem;">
            <img src="https://github.com/harris-mariano/HAP/blob/develop/public/images/logo-name.png?raw=true" style="width: 110px; height: 50px;"/>
            <p style="font-size: 0.875rem;">Hello <span style="font-weight: 700;">{{ $name }}</span>,</p>
            <p style="font-size: 0.875rem;">We have received a request to reset your password. To proceed, kindly click the button below.</p>
            <a href="{{ route('reset.link', ['token' => $token]) }}" target="_blank">
                <button type="submit" style="cursor: pointer; background-color:#E88504; border:#E88504; color: #ffffff; width:15%; height: 40px; border-radius: 7px; font-weight: 700;">Reset My Password</button>
            </a>
            <p style="font-size: 0.875rem;">The password request link will expire in an hour. If you did not request a password reset, you can safely ignore this email.</p>
            <p style="font-size: 0.875rem;">Have questions? Just hit reply. </p>
            <div>
                <p style="font-size: 0.875rem;">Our Best, </p>
                <p style="font-size: 0.875rem; color: #E88504;">adish HAP Team </p>
            </div>
            <hr style="background-color: #D3D3D3; border: #D3D3D3; width: 100%; height: 2px;"></hr>
            <p style="font-size: 0.875rem;text-align: center; ">Empowering support, one ticket at a time with <span style="color: #E88504;">adish HAP.</span></p>
        </div>
    </div>
</body>
</html>

