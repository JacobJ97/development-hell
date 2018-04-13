<div class="container">
    <div class="body">
        <div class="possible-alerts">
            <div style="display: none;" role="alert" id="pwsuccessful" class="alert alert-success alert-dismissible"><strong>Success!</strong> <span class="message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="display: none;" role="alert" id="pwfailure" class="alert alert-danger alert-dismissible"><strong>Error!</strong> <span class="message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <h1>Login</h1>
        <form class="needs-validation" id="loginform">
            <div class="form-group">
                <label for="puname1">Username <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="puname1" id="punameord1" required>
            </div>
            <div class="form-group">
                <label for="pword2">Password <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="pword2" id="pwordord2" required>
            </div>
            <div class="form-check">
                <input class="form-check-input" value="yes" type="checkbox" name="ncheck3" id="newcheckord3">
                <label class="form-check-label" for="ncheck3">Check if you are a new user</label>
            </div>
            <div class="form-group">
                <a href="#">Reset password</a>
            </div>
            <button class="btn btn-primary" value="password" id="submitdeets3" type="submit">Submit <i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>
