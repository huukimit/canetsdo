<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Canets - Active account</title>
    <style type="text/css">
        *{
            margin: 0 auto;
        }
        table{
            padding: 20px 10px;
            border: #c9c9c9 solid 1px;
            width: 600px;
        }
        tr td{
            padding: 20px;
        }
        thead{
            background: #21d2ff;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <table>
        <thead>
            <td align="center"><h3>Canets - Active account</h3></td>
        </thead>
        <tr>
            <td>
                <span>
                    <b>Xin chao {{$fullname}}</b><br/>
                    Click link to active account : {{$link}}
                </span>
            </td>
        </tr>
    </table>

</body>
</html>
