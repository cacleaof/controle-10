<!doctype html>
<html>
        <style>
             html, body {
                background-color: #fff;
                color: #12370f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            #retangulo {
            width: 300px;
            height: 150px;
            background-color: blue;
            border: 5px solid black;
                }
            #rcorners {
                border-radius: 25px;
                color: #be9e44;
                background-color: #1f5f1a;
                padding: 70px; 
                justify-content: center;
                margin-left: 5%;
                margin-right: 5%;
                border: 2px solid black;
                font-size: 35px;
                font-family: arial;
            }
            #contato {
                border-radius: 15px;
                color: white;
                justify-content: center;
                background-color: #be9e44;
                padding: 15px; 
                margin-left: 85%;
                margin-right: 15px;
                border: 4px solid black;
                font-size: 25px;
                font-family: arial;
            }

            #conversar {
                border-radius: 15px;
                color: white;
                background-color: #be9e44;
                padding: 15px; 
                justify-content: center;
                margin-left: 1%;
                margin-right: 75%;
                margin-top: 5%;
                border: 4px solid black;
                font-size: 30px;
                font-family: arial;
                align-items: center;
            }

            .content {
                margin-left: 30%;
                color: #be9e44;
                font-size: 30px;
                font-family: arial;
            }
            .piscante {
                animation: piscar 1s infinite;
            }

            @keyframes piscar {
            0% { border-color: transparent;}
            50% { border-color: black;}
            100% { border-color: transparent;}
            }

            #pagina {
                color: black;
                background-color: #12370f;
                padding: 100px; 
                justify-content: center;
                margin-left: 1px;
                margin-right: 1px;
                border: 2px solid black;
            }

            #linha-horizontal {
                width: 300px;
                border: 1px solid white;
                
            }
        </style>
    <body>
        <div id="pagina" >
            <div id="contato" style="text-align: center;"> Contato</div>
            <div class="content">A Raízes  <span>Produtos</span></div>
            <p></p>
            <div id="linha-horizontal"></div>
            <div><img src="{{asset('/images/raizes_logo.png')}}" style="width: 300px;/* text-align: center; */margin-left: 0%;margin-right: auto;"></div>
            <div id="rcorners">
                <div>Transformar através do <span style="color:white;";>Microcrédito</span> o mundo dos pequenos empreendedores 
                sem acesso ao mercado tradicional do crédito.</div>
            </div>
            <p></p>
            <div id="conversar" style="text-align: center;">Vamos Conversar</div>
        </div>
        <script>
        var elemento = document.getElementById("contato");
        elemento.addEventListener("mouseover", function() { elemento.classList.add('piscante'); });
        elemento.addEventListener("mouseout", function() { elemento.classList.remove('piscante'); });
        var e_conv = document.getElementById("conversar");
        e_conv.addEventListener("mouseover", function() { e_conv.classList.add('piscante'); });
        e_conv.addEventListener("mouseout", function() { e_conv.classList.remove('piscante'); });
        </script>
    </body>
</html>









