<?php
$update_array = json_decode(htmlspecialchars_decode($_GET['data-to-update']));
?>
<div class="container">
    <div class="body">
        <div class="possible-alerts">
            <div style="display: none;" role="alert" id="updatepass" class="alert alert-success alert-dismissible"><strong>Success!</strong> <span class="message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="display: none;" role="alert" id="updatefail" class="alert alert-danger alert-dismissible"><strong>Error!</strong> <span class="message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <h1>Editing Row #<?=$update_array[0]?></h1>
        <form class="needs-validation" id="updatesurvey" role="form" novalidate>
            <div class="form-group">
                <label for="pnameord1">Name <span class="text-danger">*</span></label>
                <input class="form-control" value="<?=$update_array[1]?>" type="text" name="pname" id="pnameord1" placeholder="John Smith" required>
            </div>
            <div class="form-group">
                <label for="genderord2">Gender <span class="text-danger">*</span></label>
                <select class="form-control" name="gender" id="genderord2" required>
                    <option <?php if ($update_array[2] === "m") {echo("selected");} ?> value="m">Male</option>
                    <option <?php if ($update_array[2] === "f") {echo("selected");} ?> value="f">Female</option>
                    <option <?php if ($update_array[2] === "o") {echo("selected");} ?> value="o">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ageord3">Age <span class="text-danger">*</span></label>
                <input class="form-control" value="<?=$update_array[3]?>" type="number" name="age" id="ageord3" placeholder="6" required>
            </div>
            <div class="form-group">
                <label for="favponeord4">Favourite Pony? <span class="text-danger">*</span></label>
                <input class="form-control" value="<?=$update_array[4]?>" type="text" name="favpony" id="favponeord4" placeholder="Pinkie Pie"
                       required>
            </div>
            <div class="form-group">
                <label for="locationord5">Location</label>
                <input class="form-control" value="<?=$update_array[5]?>" type="text" name="location" id="locationord5" placeholder="Australia">
            </div>
            <input type="hidden" name="id" value="<?=$update_array[0]?>">
            <a class="btn btn-secondary" href="?site-page=results"><i class="fas fa-arrow-left"></i> Back</a>
            <a style="display: none;" id="neword6" class="btn btn-success" href="?site-page=survey"><i class="fas fa-plus"></i> New Row</a>
            <button class="btn btn-primary" name="update" value="update_row" id="update_row_button" type="submit"><i class="fas fa-sync-alt"></i> Update Row</button>
            <button class="btn btn-danger" name="update" value="delete_row" id="delete_row_button" type="submit"><i class="fas fa-times"></i> Delete Row</button>
        </form>
    </div>
</div>