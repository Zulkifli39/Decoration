<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Footer Example</title>

    <!-- Menambahkan Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">

    <style>
      body, html {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #f4f4f4;
        color: #333;
      }

      footer {
        color: #fff;
        padding: 20px 10px;
        text-align: center;
      }

      footer hr {
        border: 0;
        height: 1px;
        background-color: #000;
        margin-bottom: 20px;
        width: 100%;
      }

      footer i {
        font-size: 0.9rem;
        color: #000;
      }

      /* Responsive Adjustment */
      @media (max-width: 768px) {
        footer i {
          font-size: 0.85rem;
        }

        footer hr {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <!-- Footer -->
    <footer>
      <hr />
      <i>Dibuat oleh Nama Anda | Sistem Reservasi | &copy;2025</i>
    </footer>
  </body>
</html>
