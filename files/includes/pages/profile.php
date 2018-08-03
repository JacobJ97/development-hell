<?php
if ($_SESSION['loggedIn'] === true) {
    ?>
    <div class="container">
        <div class="body">
            <div class="possible-alerts">

            </div>
            <h1>Your Profile</h1>
            <form class="needs-validation" id="ponysurvey" role="form" novalidate>
                <h5>Details</h5>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input class="form-control" type="text" name="fnameprof" id="pfnameprof1" placeholder="First Name">
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" type="text" name="lnameprof" id="lfnameprof2" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" name="emailprof" id="emailprof3" placeholder="Email">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Description of you" rows="3"></textarea>
                </div>
                <button class="btn btn-primary" id="submitord6" value="add_survey" type="submit">Update Details <i class="fas fa-paper-plane"></i></button>
            </form>

            <form>
                <h5>Change password</h5>
                <div class="form-row align-items-center">
                    <div class="form-group col-sm-4">
                        <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="<?php echo $_SESSION['userName'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <input type="password" class="form-control" name="opwordprof" id="opwordprof5" placeholder="Old Password">
                    </div>
                    <div class="form-group col-sm-4">
                        <input type="password" class="form-control" name="npwordprof" id="npwordprof6" placeholder="New Password">
                    </div>
                </div>
                <button class="btn btn-primary" id="submitord6" value="add_survey" type="submit">Update Password <i class="fas fa-paper-plane"></i></button>
            </form>

        </div>
    </div>
<?php
}
else {
    die("You must be logged in.");
}?>