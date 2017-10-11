<?php
  // Вывод критической ошибки
  function ShowException($msg, $head = 'RUNTIME ERROR') {
      echo '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
          <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Error</title>
                <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
                <style>
                   #blockError {
                      width: 440px; padding: 2px 5px; position: absolute; left: 50%; top: 50%;
                      margin: 0 0 0 -220px; text-align: center; border: 1px solid #ccc;
                      font: 24px Arial, Helvetica, sans-serif; border-radius: 15px;
                   }
                </style>
            </head>
            <body>
                <div id="blockError">
                		<p style="margin: 10px 0;">',$head,'</p>
                		<p style="margin: 10px 0; color: #6a6a6a; font-size: 14px">',$msg,'</p>
                </div>
                <script>window.setTimeout("window.location.href = \'/login\';", 5000);</script>
            </body>
          </html>';
      exit();
  }
?>