<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <h1>Hello, world!</h1>
    <button id="stop-button" class="btn btn-danger">Stop</button>
    <button id="start-button" class="btn btn-success">Start</button>
    <button id="wd-button" class="btn btn-success">Withdraw All</button>
    <span id="result-span" class="badge badge-primary"></span>

    <div class="form-group">
        <label for="input-value">Input:</label>
        <input type="text" class="form-control" id="input-value">
    </div>

</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script>
    let intervalId;

    $("#stop-button").click(function() {
        $("#result-span").text("Stopped");
    });

    $("#start-button").click(function() {
       getData()
    });

    $("#wd-button").click(function() {
        withdrawAll()
    });

    function withdrawAll() {
        $.ajax({
            url: "{{url("")}}/trade/withdraw/all,
            success: function(result) {
                $("#result-span").html(result);
            }
        });
    }

    function getData() {
        let inputValue = $("#input-value").val();
        $.ajax({
            url: "{{url("")}}/trade/NICL-W/automate/beautify/offer/" + inputValue,
            success: function(result) {
                $("#result-span").html(result);
            }
        });
    }
</script>

</body>
</html>
