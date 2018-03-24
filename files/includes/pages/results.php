<div class="container">
    <div class="body">
        <div class="possible-alerts">

        </div>
        <h1>Results!</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Favourite Pony</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
            <?php
            include_once($_SERVER['DOCUMENT_ROOT'] . "../files/includes/Database.php");
            $db = new Database();
            $results = $db->get_data();
            ?>
            <form method="get">
                <input type="hidden" name="site-page" value="update">
            <?php for($i = 0; $i < $results[1]; $i++): ?>
                <tr>
                    <th scope="row"><?=$results[0][$i][0]?></th>
                    <td><?=$results[0][$i][1]?></td>
                    <td><?=$results[0][$i][2]?></td>
                    <td><?=$results[0][$i][3]?></td>
                    <td><?=$results[0][$i][4]?></td>
                    <td><?=$results[0][$i][5]?></td>
                    <td><button value="<?=htmlspecialchars(json_encode($results[0][$i]))?>" name="data-to-update" type="submit" class="btn btn-primary">Update</button></td>
                </tr>
            <?php endfor; ?>
            </form>
            </tbody>
        </table>
    </div>
</div>