<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body>

    <span></span>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        var ip = '213.181.76.16'
        var access_key = 'd212f216a75bf964d6eb8e24f67f1983';

        // get the API result via jQuery.ajax
        $.ajax({
            url: 'https://ipapi.co/' + ip + "/json",
            dataType: 'json',
            success: function (json) {

                // output the "capital" object inside "location"
                $("span").text(json.city);
                alert(json.city);

            }
        });
    </script>
</body>
</html>