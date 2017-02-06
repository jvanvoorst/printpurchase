<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Print Purchase on Demand</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>

    <body>

    <?php
        // grab shibboleth attributes
        $givenName = trimStr($_SERVER['givenName']);
        $sn = trimStr($_SERVER['sn']);
        $mail = $_SERVER['mail'];
        $homeDepartment = $_SERVER['cuEduPersonHomeDepartment'];
        
        // trim after ':'
        function trimStr($sourceStr) {
            if(($pos = strpos($sourceStr, ';')) !== FALSE) {
                return substr($sourceStr, 0, $pos);
            } else {
                return $sourceStr;
            }
        }
    ?>

    <header>
        <div class="container banner">
            <p class="banner-text">University Libraries</p>
        </div>
    </header>

    <div class="container">
        <p class="lead">The University Libraries does not own this book. By completing this form you are requesting that the Libraries purchase this book for the collection. There is no charge for this service.</p>
    </div>

    <form class="container">

        <!-- Patron ====================================================== -->
        <h1 class="h2">Patron <small>Please verify your info</small></h1>
        <!-- First name Last name -->
        <div class="row">
            <fieldset class="form-group col-md-6">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $givenName; ?>" required>
            </fieldset>
            <fieldset class="form-group col-md-6">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $sn; ?>" required>
            </fieldset>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- Department Major -->
                <fieldset class="form-group">
                        <label for="department">Department/Major</label>
                        <input type="text" class="form-control" name="department" id="department" value="<?php echo $homeDepartment; ?>" required>
                </fieldset>
                <!-- Email Address -->
                <fieldset class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $mail; ?>"required>
                </fieldset>
            </div>
            <!-- Affiliation -->
            <div class="col-md-6">
                <fieldset class="radio-group">
                    <legend class="radio-legend">Affiliation</legend>
                    <div class="radio">
                        <label for="grad">
                            <input id="grad" type="radio" value="grad" name="affiliation" required>
                            Graduate Student
                        </label>
                    </div>
                    <div class="radio">
                        <label for="faculty">
                            <input id="faculty" type="radio" value="faculty" name="affiliation" required>
                            Faculty
                        </label>
                    </div>
                    <div class="radio">
                        <label for="staff">
                            <input id="staff" type="radio" value="staff" name="affiliation" required>
                            Staff
                        </label>
                    </div>
                </fieldset>
            </div>
        </div>

        <!-- Book ======================================================== -->
        <h2 class="h2">Book</h2>
        <div class="row">
            <!-- Title -->
            <fieldset class="form-group col-md-6">
                <label for="title">Title</label>
                <textarea rows="2" class="form-control" id="title" name="title" readonly></textarea> 
            </fieldset>
            <!-- Author -->
            <fieldset class="form-group col-md-6">
                <label for="author">Author/Publisher</label>
                <textarea class="form-control" id="author" name="author" readonly></textarea>
            </fieldset>
        </div>

        <div class="row">
            <!-- ISBN -->
            <fieldset class="form-group col-md-6">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" readonly>
            </fieldset>
        </div>

        <!-- Delivery ==================================================== -->
        <h3 class="h2">Estimated Delivery Time</h3>
        <!-- Delivery Time (modified from what Coutts sends back) -->
        <div class="row">
            <fieldset class="form-group col-md-6">
                <label for="deliveryTimePatron">(business days)</label>
                <div id="deliveryTimePatron">
                    <img alt="loading" src="img/spin.svg">
                </div>
            </fieldset>
        </div>
        <!-- hidden input for the real delivery time returned from Coutts -->
        <fieldset class="form-group" hidden>
            <label for="deliveryTime">Delivery Time (real)</label>
            <input type="text" class="form-control" id="deliveryTime" name="deliveryTime" readonly>
        </fieldset>
        <!-- Delivery selection -->
        <div class="row">
            <fieldset class="radio-group col-md-6">
                <!-- Delivery speed selection -->
                <legend class="radio-legend">Choose One:</legend>
                <div class="radio">
                    <label for="regular">
                        <input id="regular" type="radio" value="regular" name="delivery" required>
                        The delivery time listed above is sufficient
                    </label>
                </div>
                <div class="radio">
                    <label for="rush">
                        <input id="rush" type="radio" value="rush" name="delivery" required>
                        I need this book faster
                    </label>
                </div>
            </fieldset>
        </div>
        <!-- submit button -->
        <div class="row text-center">
            <button type="submit" value="submit" class="btn btn-lg btn-warning btn-submit" id="submitBtn">Submit</button>
        </div>

    </form>

    </body>

</html>