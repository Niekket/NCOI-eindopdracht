<?php
include "../includes/db.php"; // include database connection
include "../includes/actions.php"; // include alle actions

// activeert de functie om data eenmalig in de database to zetten
splitAthleteFileAddDataOnce();

?>

<?php include "../includes/header.php";?>

<main class="container">
    <div class="row">
        <div class=" col-md-8 col-lg-6">
            <h1 class="font-weight-light mt-4 text-black mt-5">Find your Athlete</h1>
            <p class="lead text-black-50">Please type in the athlete you would like to lookup</p>
            <div class="input-group">
                <input type="search" class="form-control" id="search-athletes" placeholder="search athlete by name"
                    name="search-athlete">
            </div>
        </div>
    </div>
    <div class="row mt-4" id="row-data">
        <div class="col-lg-12 col-md-12 table-row">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr class="row">
                        <th class="col-sm-3 th-head-athlete-name">Athlete name</th>
                        <th class="col-md-9 col-sm-12 th-head-athlete-info">Athlete info</th>
                    </tr>
                </thead>
                <tbody id="result-athlete-data">
                </tbody>
            </table>
        </div>
    </div>
    <?php
// Wanneer gegevens zijn ingevoerd of niet $showData tonen op de webpagina
if (isset($_SESSION["succes"])) {
    echo $showData = "<p id='account-succes'>Account succesfully created</p>";
    unset($_SESSION["succes"]);
}

if (isset($_SESSION["accountExists"])) {
    echo $accountExists = "<p id='account-exists'>Account already exists</p>";
    unset($_SESSION["accountExists"]);
}

if (isset($_SESSION["nosucces"])) {
    echo $showData = "<p id='account-no-succes'>Please fill in all the input fields, or fill in correct username (a-z, A-Z, 0-9)</p>";
    unset($_SESSION["nosucces"]);
}
?>
    <!-- Modal Login-->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-login">Sign in</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../includes/actions.php" method="post">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email-login" name="email-login"
                                placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password-login" name="password-login"
                                placeholder="Password">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-success" name="sign-in">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="modal-register"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-register">Sign up</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../includes/actions.php" method="post" id="form"
                        oninput='pass2.setCustomValidity(pass2.value != pass1.value ? "Passwords do not match." : "")'>
                        <!--Check password match, anders een popup met de string "password do not match" Standaard bootstrap validatie-->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="fullname" type="text" class="form-control" id="name" placeholder="Your name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input name="email" type="email" class="form-control" id="email-register"
                                placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="pass1">Password</label>
                            <input name="pass1" type="password" class="form-control" id="password-register-1"
                                placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="pass2">Confirm password</label>
                            <input name="pass2" type="password" class="form-control" id="password-register-2"
                                placeholder="Password">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-success" name="sign-up">Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Change Athlete-->
    <div class="modal fade" id="change-athlete-content" tabindex="-1" role="dialog"
        aria-labelledby="change-athlete-content" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">change content of the current athlete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../includes/actions.php" method="post">
                        <input type="hidden" id="athlete-edit-id-input">
                        <div class="form-group">
                            <label for="change-athlete-name">Change athlete name</label>
                            <input type="text" class="form-control" id="athlete-edit-name-input"></div>
                        <div class="form-group">
                            <label for="change-athle-info">Change athlete info</label>
                            <textarea class="form-control" id="athlete-edit-info-input" rows="10"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="btn-send-athlete-data">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "../includes/footer.php";?>