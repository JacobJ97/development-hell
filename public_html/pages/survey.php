<div class="container">
    <div class="body">
        <div class="possible-alerts">
            <div style="display: none;" role="alert" id="submitpass" class="alert alert-success alert-dismissible"><strong>Success!</strong> The survey has been submitted successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="display: none;" role="alert" id="submitfail" class="alert alert-danger alert-dismissible"><strong>Error!</strong> Something has gone wrong, and the survey has not been submitted.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <h1>Survey</h1>
        <form class="needs-validation" id="ponysurvey" role="form" novalidate>
            <div class="form-group">
                <label for="pnameord1">Name <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="pname" id="pnameord1" placeholder="John Smith" required>
            </div>
            <div class="form-group">
                <label for="genderord2">Gender <span class="text-danger">*</span></label>
                <select class="form-control" name="gender" id="genderord2" required>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                    <option value="o">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ageord3">Age <span class="text-danger">*</span></label>
                <input class="form-control" type="number" name="age" id="ageord3" placeholder="6" required>
            </div>
            <div class="form-group">
                <label for="favponeord4">Favourite Pony? <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="favpony" id="favponeord4" placeholder="Pinkie Pie"
                       required>
            </div>
            <div class="form-group">
                <label for="locationord5">Location</label>
                <input class="form-control" type="text" name="location" id="locationord5" placeholder="Australia">
            </div>
            <button class="btn btn-primary" id="submitord6" type="submit">Submit Survey <i class="fas fa-paper-plane"></i></button>
            <a style="display: none;" class="btn btn-success" id="successord7" href="?site-page=results">Results <i class="fas fa-arrow-right"></i></a>
        </form>
    </div>
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>