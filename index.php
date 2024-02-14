<!DOCTYPE html>
<html>
<head>
<title>Мой сайт</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>
<body>
<h1>Конвертер валют</h1>

<?php
include("connection/Connection.php");
include("ParsingXML.php");

$conn = null;

try {
    $conn = Connection::get()->connect();
    echo"<script>";
    echo "console.log('A connection to the PostgreSQL database server has been established successfully.')";
    echo"</script>";
} catch (\PDOException $e) {
    $format = "A connection to the PostrgreSQL database server has been failed %s";
    
    $log = sprintf("console.log('%s')", sprintf($format, $e->getMessage()));

    echo "<script>" . $log . "</script>";

    $conn = null;
}

//echo phpinfo();

$url = 'https://www.cbr.ru/scripts/XML_daily.asp';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);

$response = curl_exec($ch);

if($conn){
    $parsing = new ParsingXML($response, $conn);

    $parsing->parse();
}

curl_close($ch);

if ($response === false) {
    echo 'Bad response';
}
else {
    echo"<script>" . "console.log('response is fine')" . "</script>";
}

$stmt = $conn->query("SELECT name FROM valute;");

$valutesNames = $stmt->fetchAll();

$sorted = array();

for ($i = 0; $i < count($valutesNames); $i++) {
    $sorted[] = $valutesNames[$i]['name'];
}

sort($sorted);
?>

<form action="">
    <div class="form-group">
        <input type="text" id="input">
        <select name="currency_from" id="currentSelect">
            <?php for ($i = 0; $i < count($valutesNames); ++$i): ?>
                <option value=<?php echo "" . $i . ""; ?>><?php echo $sorted[$i] ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div><p id="value">0</p></div>
    <select name="currency_to" id="nextSelect">
    <?php for ($i = 0; $i < count($valutesNames); ++$i): ?>
            <option value=<?php echo "" . $i . ""; ?>><?php echo $sorted[$i] ?></option>
        <?php endfor; ?>
    </select>
</form>

<script type="module">
    import { ajaxFunction } from './ajaxFunction.js';
    import { functionSuccess } from './ajaxFunction.js';

    var isNumber = function(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    $("document").ready(function(){
        $("#input").on("oninput", input.oninput = function() {
            var currentSelect = document.getElementById("currentSelect");
            var currentSelectValue = currentSelect.options[currentSelect.selectedIndex].text;
            var nextSelect = document.getElementById("nextSelect");
            var nextSelectValue = currentSelect.options[nextSelect.selectedIndex].text;

            if(input.value !== ""){
                if(isNumber(input.value)){
                    ajaxFunction(input.value, currentSelectValue, nextSelectValue);
                }
                else{
                    value.innerHTML = "Not a number";
                }
            }
            else{
                value.innerHTML = 0;
            }
        });
    });
</script>
<script type="module">
    import { ajaxFunction } from './ajaxFunction.js';
    import { functionSuccess } from './ajaxFunction.js';

    var isNumber = function(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    $("document").ready(function(){
        $("#currentSelect").change(function() {
            var currentSelect = document.getElementById("currentSelect");
            var currentSelectValue = currentSelect.options[currentSelect.selectedIndex].text;
            var nextSelect = document.getElementById("nextSelect");
            var nextSelectValue = currentSelect.options[nextSelect.selectedIndex].text;

            console.log(currentSelectValue);
            console.log(nextSelectValue);

            if(input.value !== ""){
                if(isNumber(input.value)){
                    ajaxFunction(input.value, currentSelectValue, nextSelectValue);
                }
                else{
                    input.value = "Not a number";
                }
            }
        });
    });
</script>
<script type="module">
    import { ajaxFunction } from './ajaxFunction.js';
    import { functionSuccess } from './ajaxFunction.js';

    var isNumber = function(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    $("document").ready(function(){
        $("#nextSelect").change(function() {
            var currentSelect = document.getElementById("currentSelect");
            var currentSelectValue = currentSelect.options[currentSelect.selectedIndex].text;
            var nextSelect = document.getElementById("nextSelect");
            var nextSelectValue = currentSelect.options[nextSelect.selectedIndex].text;

            console.log(currentSelectValue);
            console.log(nextSelectValue);

            if(input.value !== ""){
                if(isNumber(input.value)){
                    ajaxFunction(input.value, currentSelectValue, nextSelectValue);
                }
                else{
                    input.value = "Not a number";
                }
            }
        });
    });
</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script> -->
</body>
</html>
