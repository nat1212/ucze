<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SN</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        </style>

<style>
        {
            margin:0;
            padding:0;
            box-sizing: border-box;
        }

        body{
           display:flex;
           align-items:center;
           justify-content:center;
            background: #a9a8aa;
            min-height: 100vh;
            overflow:hidden;
            margin:0;
                padding:0;
                font-family: 'Geologica', sans-serif;
        }
        section{
            position: absolute;
            width:100%;
            height:100%;
            display:flex;
            justify-content: center;
            align-items: center;
            transform-style: preserve-3d;
            transform:perspective(700px);
        }
        .box
        {
            position: absolute;
            transform-style: preserve-3d;
            top: 125px;
        }
        .box .cube
        {
            position:relative;
            width:200px;
            height:200px;
            transform-style:preserve-3d;
            animation: animateCube 20s linear infinite;
        }
        @keyframes animateCube{
            0%
            {
                transform: rotateY(0deg);
            }
            100%
            {
                transform: rotateY(360deg);
            }
        }

        .box .cube div{
            position: absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            transform-style:preserve-3d;
        }

        .box .cube div span{
            position: absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background: radial-gradient(#4682B4, #4682B4, #1E90FF);
            transform: rotateY(calc(90deg * var(--i))) translateZ(100px);
        }

        .box .cube div span::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('images/logo.png');
            background-size: cover;
            background-position: center;
            opacity: 0.5; 
        }

        .box .cube .top
        {
            position: absolute;
            top:0;
            left:0;
            width:200px;
            height:200px;
            background:#4682B4;
            transform: rotateX(90deg) translateZ(100px);
            display:flex;
            justify-content: center;
            align-items: center;
        }
        .box .cube .bottom
        {
            position: absolute;
            bottom:0;
            left:0;
            width:200px;
            height:200px;
            background:#4682B4;
            transform: rotateX(-90deg) translateZ(100px);
            display:flex;
            justify-content: center;
            align-items: center;
        }

        .box .cube .top::before
        {
            content:'';
            position: absolute;
            width:600px;
            height:600px;
            background:#4682B4;
            filter:blur(50px);
            transform: translateZ(-550px);
        }

        .Z {
        color: black;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        margin: 10px; 
        z-index: 2;
        margin-top:60%;
        width:150px;
        transition: background-color 0.3s;
        border-radius:5px;
        
    }
    .SG {
        color: black;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        z-index: 2;
        margin-top:80%;
        width:250px;
        transition: background-color 0.3s;
        border-radius:5px;
    
    }

    .Z:hover {
        background-color: #1E90FF;
    }

    .SG:hover {
        background-color: #1E90FF;
    }
        h1{
                font-size:80px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
                > span{
                    position: relative;
                    display:inline-block;
                    color: #1E90FF;
                    height:1.5em;
                    vertical-align:bottom;
                    overflow: hidden;
                   
                }
                .animateWords {
                        display:block;
                        animation:
                        animateWords 20s infinite ease;
                    }
            }

            @keyframes animateWords{
                0%{
                    transform: translateY(0%)
                }
                25%{
                    transform: translateY(-100%)
                }
                50%{
                    transform: translateY(-200%)
                }
                75%{
                    transform: translateY(-300%)
                }
                100%{
                    transform: translateY(-400%)
                }
            }

            @media screen and (max-width: 850px) {
    section {
        flex-direction: column;
        margin-bottom: 20px;
    }

    h1{
        margin-left:40px;
        font-size:40px;
    }
    .Z {
        margin-top: 60%;
        border-radius:5px;
    }

    .SG {
        
        margin-top: 80%;
        border-radius:5px;
    }
}
    </style>
    </head>


        
    <body>
       <section>
        <div class = "box">
        <div class = "cube">
        <div>
            <div class = "top"></div>
            <span style = "--i:0;"></span>
            <span style = "--i:1;"></span>
            <span style = "--i:2;"></span>
            <span style = "--i:3;"></span>
            <div class = "bottom"></div>
        </div>
        </div>
        </div>
        <h1>Wydarzenia na uczelni
                        <span>
                            <span class="animateWords">Dołącz teraz!</span>
                            <span class="animateWords">Zarejestruj się</span>
                            <span class="animateWords">Zaloguj się</span>
                            <span class="animateWords">Odkryj co się dzieje</span>
                            <span class="animateWords">Dołącz teraz!</span>
                        </span>
                    </h1>
                  
       </section>
       <div style="display: flex; justify-content: center;">
    @if (Route::has('login'))
        <div class="hidden fixed sm:block">
            @auth
               <button  class="SG"  onclick="redirectToST()">Strona Główna</button>
            @else
            <button class="Z"  onclick="redirectToZ()">Zaloguj się</button>

                @if (Route::has('register'))
                <button  class="Z"  onclick="redirectToR()">Zarejestruj się</button>
                @endif
            @endauth
        </div>
    @endif
</div>
    </body>

    
<script>


function redirectToST() {
    window.location.href ="{{ url('/home') }}";
}

function redirectToZ() {
    window.location.href ="{{ route('login') }}";
}

function redirectToR() {
    window.location.href ="{{ route('register') }}";
}



</script>
</html>
