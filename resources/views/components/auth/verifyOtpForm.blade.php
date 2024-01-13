<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4 class="text-center">ENTER OTP CODE</h4>
                    <br />
                    <label>4 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text" />
                    <br />
                    <button onclick="verifyOtp()" class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function verifyOtp() {
        let postBody = {
            "email": sessionStorage.getItem("email"),
            "otp": document.getElementById('otp').value
        }

        showLoader();
        let res = await axios.post("/verify-otp", postBody);
        hideLoader();

        if (res.status === 200 && res.data['status'] === 'success') {
            successToast(res.data['message']);

            setTimeout(function() {
                setToken(res.data['token'])
                window.location.href = "/resetPassword";
            }, 1500);

        } else {
            errorToast(res.data['message']);
        }
    }
</script>
