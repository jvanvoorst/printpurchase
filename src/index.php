<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Print Purchase on Demand</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>

    <body>

    <!-- Force IE to not use compatibility mode even on intranet -->
    <?php header('X-UA-Compatible: IE=edge'); ?>

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
            <h1 class="banner-text">University Libraries</h1>
        </div>
    </header>

    <div class="container">
        <p class="lead">The University Libraries does not own this book. By completing this form you are requesting that the Libraries purchase this book for the collection. There is no charge for this service.</p>
    </div>

    <form class="container">

        <!-- Patron ====================================================== -->
        <h2 class="h2">Patron <small>Please verify your info</small></h2>
        <!-- First name Last name -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="firstName">First Name</label>
                <input title="First Name" type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $givenName; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $sn; ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- Department Major -->
                <div class="form-group">
                        <label for="department">Department/Major</label>
                        <input type="text" class="form-control" name="department" id="department" value="<?php echo $homeDepartment; ?>" required>
                </div>
                <!-- Email Address -->
                <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $mail; ?>" required>
                </div>
            </div>
            <!-- Affiliation -->
            <div class="col-md-6">
                <fieldset class="radio-group">
                    <legend class="radio-legend">Affiliation</legend>
                    <div class="radio">
                        <label for="undergrad">
                            <input id="undergrad" type="radio" value="undergrad" name="affiliation" required>
                            Undergraduate
                        </label>
                    </div>
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
            <div class="form-group col-md-6">
                <label for="title">Title</label>
                <textarea rows="2" class="form-control" id="title" name="title" readonly></textarea> 
            </div>
            <!-- Author -->
            <div class="form-group col-md-6">
                <label for="author">Author/Publisher</label>
                <textarea class="form-control" id="author" name="author" readonly></textarea>
            </div>
        </div>

        <div class="row">
            <!-- ISBN -->
            <div class="form-group col-md-6">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" readonly>
            </div>
        </div>

        <!-- Delivery ==================================================== -->
        <h2 class="h2">Estimated Delivery Time</h2>
        <!-- Delivery Time (modified from what Coutts sends back) -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="deliveryTimePatron">(business days)</label>
                <div id="deliveryTimeEst">
                    <img alt="loading" src="img/spin.svg">
                </div>
            </div>
        </div>
        <!-- hidden input for the real delivery time returned from Coutts -->
        <div class="form-group" hidden>
            <label for="deliveryTime">Delivery Time (real)</label>
            <input type="text" class="form-control" id="deliveryTime" name="deliveryTime" readonly>
        </div>
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

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-91549104-1', 'auto');
        ga('send', 'pageview');
    </script>

    </body>

</html>