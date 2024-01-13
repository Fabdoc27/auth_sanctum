<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4 class="text-center">SIGN IN</h4>
                    <input id="email" placeholder="User Email" class="form-control mb-3" type="email" />
                    <input id="password" placeholder="User Password" class="form-control mb-3" type="password" />
                    <button onclick="submitOnLogin()" type="submit" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr />
                    <div class="d-flex justify-content-center mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{ route('registration.page') }}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{ route('otp.page') }}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function submitOnLogin() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if (email.length === 0) {
            errorToast("Email is required");
        } else if (password.length === 0) {
            errorToast("Password is required");
        } else {
            showLoader();
            let res = await axios.post("/user-login", {
                email: email,
                password: password
            });
            hideLoader();

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);
                setTimeout(function() {
                    setToken(res.data['token'])
                    window.location.href = "/dashboard";
                }, 1500);
            } else {
                errorToast("Login Credentials are Invalid");
            }
        }
    }
</script>
