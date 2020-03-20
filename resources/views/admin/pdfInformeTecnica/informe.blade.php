<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Hello, world!</title>

    <style>
    
    *{
      font-family: Arial, Helvetica, sans-serif;
    }

    .header{
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
    }
    
    .content{
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }

    </style>

  </head>
  <body>

    <header class="header">
      <div>
        <img src="{{ public_path('images/logo_rojo.png') }}" class="img-fluid"  alt="none" width="300px" height="140px">
      </div>
      <div style="margin-left: 325px;">
        <h1 style="font-size: 35px;">Informe de Visita Técnica</h1>
      </div>
    </header>

    <section>
      <div>
        <section style="background-color: rgb(231, 1, 1);">
          <p style="color: white; font-size: 30px; font-weight: bold; padding: 10px;">Información Inicial:</p>
        </section>

        <section>
          <section class="content">
              <div style="border-right: 1px solid black; width: 45%; ">
                  <span><strong>Granja:</strong>Campeon</span>
                  <span><strong>Asociado:</strong>Sebastian Barreneche</span>
                  <span><strong>Técnico:</strong>Cesar</span>
                  <span><strong>Tipo de Producción:</strong>ceba</span>
                </div>
      
                <div style="border-left: 1px solid black; width: 45%;">
                  <span><strong>Lugar:</strong>Pereira</span>
                  <span><strong>Fuente:</strong>Acueducto</span>
                  <span><strong>Suministro:</strong>Chupo</span>
                  <span><strong>Fecha:</strong>2019-10-25</span>
                </div>
          </section>
        </section>

      </div>
      <div>

      </div>
    </section>

  </body>
</html>