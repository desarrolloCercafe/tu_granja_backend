<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>

            @import url("https://fonts.googleapis.com/css?family=Bungee");
            body {
                background: #1b1b1b;
                color: white;
                font-family: "Bungee", cursive;
                margin-top: 50px;
                text-align: center;
            }
            a {
                color: #2aa7cc;
                text-decoration: none;
            }
            a:hover {
                color: white;
            }
            svg {
                width: 50vw;
            }
            .lightblue {
                fill: #444;
            }
            .eye {
                cx: calc(115px + 30px * var(--mouse-x));
                cy: calc(50px + 30px * var(--mouse-y));
            }
            #eye-wrap {
                overflow: hidden;
            }
            .error-text {
                font-size: 120px;
            }
            .alarm {
                animation: alarmOn 0.5s infinite;
            }

            @keyframes alarmOn {
                to {
                    fill: darkred;
                }
            }

            /*html {*/
            /*    background-color: #000121;*/
            /*    font-family: 'Roboto', sans-serif;*/

            /*}*/
            /*.maincontainer {*/
            /*    position: relative;*/
            /*    top: -50px;*/
            /*    transform: scale(0.8);*/
            /*    background: url("https://www.blissfullemon.com/wp-content/uploads/2018/09/HauntedHouseBackground.png");*/
            /*    background-repeat: no-repeat;*/
            /*    background-position: center;*/
            /*    background-size: 700px 600px;*/
            /*    width: 800px;*/
            /*    height: 600px;*/
            /*    margin: 0px auto;*/
            /*    display: grid;*/
            /*}*/

            /*.foregroundimg {*/
            /*    position: relative;*/
            /*    width: 100%;*/
            /*    top: -230px;*/
            /*    z-index: 5;*/
            /*}*/

            /*.errorcode {*/
            /*    position: relative;*/
            /*    top: -200px;*/
            /*    font-family: 'Creepster', cursive;*/
            /*    color: white;*/
            /*    text-align: center;*/
            /*    font-size: 6em;*/
            /*    letter-spacing: 0.1em;*/
            /*}*/

            /*.errortext {*/
            /*    position: relative;*/
            /*    top: -260px;*/
            /*    color: #FBD130;*/
            /*    text-align: center;*/
            /*    text-transform: uppercase;*/
            /*    font-size: 1.8em;*/
            /*}*/

            /*.bat {*/
            /*    opacity: 0;*/
            /*    position: relative;*/
            /*    transform-origin: center;*/
            /*    z-index: 3;*/
            /*}*/

            /*.bat:nth-child(1) {*/
            /*    top: 380px;*/
            /*    left: 120px;*/
            /*    transform: scale(0.5);*/
            /*    animation: 13s 1s flyBat1 infinite linear;*/
            /*}*/

            /*.bat:nth-child(2) {*/
            /*    top: 280px;*/
            /*    left: 80px;*/
            /*    transform: scale(0.3);*/
            /*    animation: 8s 4s flyBat2 infinite linear;*/
            /*}*/

            /*.bat:nth-child(3) {*/
            /*    top: 200px;*/
            /*    left: 150px;*/
            /*    transform: scale(0.4);*/
            /*    animation: 12s 2s flyBat3 infinite linear;*/
            /*}*/

            /*.body {*/
            /*    position: relative;*/
            /*    width: 50px;*/
            /*    top: 12px;*/
            /*}*/

            /*.wing {*/
            /*    width: 150px;*/
            /*    position: relative;*/
            /*    transform-origin: right center;*/
            /*}*/

            /*.leftwing {*/
            /*    left: 30px;*/
            /*    animation: 0.8s flapLeft infinite ease-in-out;*/
            /*}*/

            /*.rightwing {*/
            /*    left: -180px;*/
            /*    transform: scaleX(-1);*/
            /*    animation: 0.8s flapRight infinite ease-in-out;*/
            /*}*/

            /*@keyframes flapLeft {*/
            /*    0% { transform: rotateZ(0); }*/
            /*    50% { transform: rotateZ(10deg) rotateY(40deg); }*/
            /*    100% { transform: rotateZ(0); }*/
            /*}*/

            /*@keyframes flapRight {*/
            /*    0% { transform: scaleX(-1) rotateZ(0); }*/
            /*    50% { transform: scaleX(-1) rotateZ(10deg) rotateY(40deg); }*/
            /*    100% { transform: scaleX(-1) rotateZ(0); }*/
            /*}*/

            /*@keyframes flyBat1 {*/
            /*    0% { opacity: 1; transform: scale(0.5)}*/
            /*    25% { opacity: 1; transform: scale(0.5) translate(-400px, -330px) }*/
            /*    50% { opacity: 1; transform: scale(0.5) translate(400px, -800px) }*/
            /*    75% { opacity: 1; transform: scale(0.5) translate(600px, 100px) }*/
            /*    100% { opacity: 1; transform: scale(0.5) translate(100px, 300px) }*/
            /*}*/

            /*@keyframes flyBat2 {*/
            /*    0% { opacity: 1; transform: scale(0.3)}*/
            /*    25% { opacity: 1; transform: scale(0.3) translate(200px, -330px) }*/
            /*    50% { opacity: 1; transform: scale(0.3) translate(-300px, -800px) }*/
            /*    75% { opacity: 1; transform: scale(0.3) translate(-400px, 100px) }*/
            /*    100% { opacity: 1; transform: scale(0.3) translate(100px, 300px) }*/
            /*}*/

            /*@keyframes flyBat3 {*/
            /*    0% { opacity: 1; transform: scale(0.4)}*/
            /*    25% { opacity: 1; transform: scale(0.4) translate(-350px, -330px) }*/
            /*    50% { opacity: 1; transform: scale(0.4) translate(400px, -800px) }*/
            /*    75% { opacity: 1; transform: scale(0.4) translate(-600px, 100px) }*/
            /*    100% { opacity: 1; transform: scale(0.4) translate(100px, 300px) }*/
            /*}*/

            /*@media only screen and (max-width: 850px) {*/
            /*  .maincontainer {*/
            /*    transform: scale(0.6);*/
            /*    width: 600px;*/
            /*    height: 400px;*/
            /*    background-size: 600px 400px;*/
            /*  }*/

            /*  .errortext {*/
            /*    font-size: 1em;*/
            /*  }*/
            /*}*/
        </style>
    </head>
    <body>
    <svg xmlns="http://www.w3.org/2000/svg" id="robot-error" viewBox="0 0 260 118.9">
        <defs>
            <clipPath id="white-clip"><circle id="white-eye" fill="#cacaca" cx="130" cy="65" r="20" /> </clipPath>
            <text id="text-s" class="error-text" y="106"> 403 </text>
        </defs>
        <path class="alarm" fill="#e62326" d="M120.9 19.6V9.1c0-5 4.1-9.1 9.1-9.1h0c5 0 9.1 4.1 9.1 9.1v10.6" />
        <use xlink:href="#text-s" x="-0.5px" y="-1px" fill="black"></use>
        <use xlink:href="#text-s" fill="#2b2b2b"></use>
        <g id="robot">
            <g id="eye-wrap">
                <use xlink:href="#white-eye"></use>
                <circle id="eyef" class="eye" clip-path="url(#white-clip)" fill="#000" stroke="#2aa7cc" stroke-width="2" stroke-miterlimit="10" cx="130" cy="65" r="11" />
                <ellipse id="white-eye" fill="#2b2b2b" cx="130" cy="40" rx="18" ry="12" />
            </g>
            <circle class="lightblue" cx="105" cy="32" r="2.5" id="tornillo" />
            <use xlink:href="#tornillo" x="50"></use>
            <use xlink:href="#tornillo" x="50" y="60"></use>
            <use xlink:href="#tornillo" y="60"></use>
        </g>
    </svg>
    <h1>You are not allowed to enter here</h1>

{{--    <div class="maincontainer">--}}
{{--        <div class="bat">--}}
{{--            <img class="wing leftwing"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-wing.png">--}}
{{--            <img class="body"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-body.png" alt="bat">--}}
{{--            <img class="wing rightwing"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-wing.png">--}}
{{--        </div>--}}
{{--        <div class="bat">--}}
{{--            <img class="wing leftwing"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-wing.png">--}}
{{--            <img class="body"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-body.png" alt="bat">--}}
{{--            <img class="wing rightwing"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-wing.png">--}}
{{--        </div>--}}
{{--        <div class="bat">--}}
{{--            <img class="wing leftwing"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-wing.png">--}}
{{--            <img class="body"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-body.png" alt="bat">--}}
{{--            <img class="wing rightwing"--}}
{{--                 src="https://www.blissfullemon.com/wp-content/uploads/2018/09/bat-wing.png">--}}
{{--        </div>--}}
{{--        <img class="foregroundimg" src="https://www.blissfullemon.com/wp-content/uploads/2018/09/HauntedHouseForeground.png" alt="haunted house">--}}

{{--    </div>--}}
{{--    <h1 class="errorcode">ERROR 403</h1>--}}
{{--    <div class="errortext">This area is forbidden. Turn back now!</div>--}}


    <script>
        var root = document.documentElement;
        var eyef = document.getElementById('eyef');
        var cx = document.getElementById("eyef").getAttribute("cx");
        var cy = document.getElementById("eyef").getAttribute("cy");

        document.addEventListener("mousemove", evt => {
            let x = evt.clientX / innerWidth;
            let y = evt.clientY / innerHeight;

            root.style.setProperty("--mouse-x", x);
            root.style.setProperty("--mouse-y", y);

            cx = 115 + 30 * x;
            cy = 50 + 30 * y;
            eyef.setAttribute("cx", cx);
            eyef.setAttribute("cy", cy);

        });

        document.addEventListener("touchmove", touchHandler => {
            let x = touchHandler.touches[0].clientX / innerWidth;
            let y = touchHandler.touches[0].clientY / innerHeight;

            root.style.setProperty("--mouse-x", x);
            root.style.setProperty("--mouse-y", y);
        });
    </script>

    </body>
</html>
