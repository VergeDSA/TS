<?php
//include ROOT . '/views/layouts/header.php';
?>
    <section>
        <div class="container">
            <div class="row">
                <br/>
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Adminpanel</a></li>
                        <li><a href="/admin/task">User management</a></li>
                        <li class="active">To delete a user</li>
                    </ol>
                </div>
                <h4>To delete a user #<?php echo $id; ?></h4>
                <p>Do you want to remove this user?</p>
                <form method="post">
                    <input type="submit" name="submit" value="Delete"/>
                </form>
            </div>
        </div>
    </section>
<?php
//include ROOT . '/views/layouts/footer.php';
?>