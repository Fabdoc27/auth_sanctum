<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4 class="text-center">SET NEW PASSWORD</h4>
                    <br />
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password" />
                    <br />
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password" />
                    <br />
                    <button onclick="resetPassword()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function resetPassword() {
        let password = document.getElementById('password').value;
        let cpassword = document.getElementById('cpassword').value;

        if (password
            .length < 6) {
            errorToast('Password must be 6 charecter')
        } else if (cpassword
            .length < 6) {
            errorToast('Confirm password must be 6 charecter');
        } else if (password !== cpassword) {
            errorToast('Password & confirm password must be same');
        } else {
            showLoader();
            let res = await axios.post("/reset-password", {
                password: password
            }, headerToken());
            hideLoader();

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast(res.data['message']);

                setTimeout(function() {
                    window.location.href = "/dashboard";
                }, 2000);

            } else {
                errorToast(res.data['message']);
            }
        }
    }
</script>
