
<!DOCTYPE html>
<html>
    <head>
        <title>SIP.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 300;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 30px;
                margin-bottom: 40px;
                color: red;
                font-weight: 500;
            }
            .image {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 100%;
            }
            a:link {
               text-decoration: none;
            }
            a:hover {
              text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div>
                  <a href="https://www.smartinpays.com"><img class="image" src={{ asset('/assets/images/please_verification.jpg') }} /></a>
                </div>
            </div>
        </div>
    </body>
</html>
