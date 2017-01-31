<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
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
            if(($pos = strpos($sourceStr, ':')) !== FALSE) {
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
        <h1 class="title">Request this Book</h1>
        <p>The University Libraries does not own this book. By completing this form you are requesting that the Libraries purchase this book for the collection. Regular orders may take up to 2 weeks to arrive. If you need this book immediately, please make that choice below.</p>
    </div>

    <form class="container">
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
            <fieldset class="radio-group col-md-6">
                <legend>Affiliation</legend>
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

        <h2 class="title">About the Book</h2>
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
            <!-- Delivery Time (modified from what Coutts sends back) -->
            <fieldset class="form-group col-md-6">
                <label for="deliveryTimePatron">Estimated Delivery Time (business days)</label>
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

        <div class="row">
            <fieldset class="radio-group col-md-6">
                <!-- Delivery speed selection -->
                <legend>Choose One:</legend>
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
            <div class="col-md-6">
                <button type="submit" value="submit" class="btn btn-lg btn-warning btn-submit" id="submitBtn">Submit</button>
            </div>
        </div>


    </form>

    </body>

</html>