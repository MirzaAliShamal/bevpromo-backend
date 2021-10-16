<html lang="en">

<head>
    <style>
        .fullscreen {
            position: fixed;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            /* background: rgba(51, 51, 51, 0.7); */
            z-index: 10;
            zoom: 75%;

        }

        .button {
            border-radius: 50px;
            border: none;
            color: #ffffff;
            text-align: center;
            font-size: 20px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            padding: 20px;
            width: 200px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }

        .btn1 {
            background: linear-gradient(to right, #14b6d7, #88bb85);
        }

        .btn2 {
            background: linear-gradient(to right, #36b7e8, #9a84b5);
        }

        .btn3 {
            background: linear-gradient(to right, #ede452, #ffd18b);
            font-size: 14px;
            padding: 14px;
            width: 160px;
        }

        .btn4 {
            background: linear-gradient(to right, #e86759, #f7bb89);
        }

        .btn5 {
            background: linear-gradient(to right, #e86759, #cc94bf);
        }

        .btn6 {
            background: linear-gradient(to right, #5db68b, #a9d194);
            width: 210px;
        }

        .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        .button span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        .button:hover span {
            padding-right: 25px;
        }

        .button:hover span:after {
            opacity: 1;
            right: 0;
        }

        .box {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande',
                'Lucida Sans', Arial, sans-serif;
            font-size: 2rem;
            top: -10%;
            position: absolute;
            z-index: 1;

            padding: 12px 20px;
            background: white;
        }

        .b1 {
            left: 28%;
            color: #06923d;
        }

        .b2 {
            left: 28%;
            color: #293182;
        }

        .b3 {
            left: 23%;
            color: #fcd611;
        }

        .b4 {
            left: 30%;
            color: #e45d16;
        }

        .b5 {
            left: 20%;
            color: #74357c;
        }

        .b6 {
            left: 19%;
            color: #4ca159;
        }

        .row.alignment {
            text-align: center;
            margin: 0 auto;
            display: inline-block;
            vertical-align: middle;
            float: none;
        }

        .page-title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 5rem;
            color: grey;
        }
    </style>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="/assets/global/plugins/bootstrap/css/bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="page-header-fixed page-header-fixed-mobile page-footer-fixed1">
    <!-- BEGIN CONTENT -->
    @yield('content')
    <!-- END CONTENT -->
</body>

</html>