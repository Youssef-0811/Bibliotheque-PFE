
<style>
        .wrapper {
            position: relative;
            width: 500px;
            height: 300px;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 1rem;
            background-color: rgb(255, 255, 255);
            box-shadow: 0 0 8px #089da1;
            background-repeat: no-repeat;
            background-size: cover;
            margin-left: auto;
            margin-right: auto;
            border-radius: 20px;
            z-index: 0;
        }

        .wrapper img {
     width: 250px;
    height: 320px;
    margin-top:0.5rem;
    margin-left:26.4% ;
    border-radius: 1rem;
        }

        input {
            appearance: none;
            z-index: 100;
            margin-right: 1rem;
            width: 1rem;
            height: 1rem;
            background: dodgerblue;
            border-radius: 50%;
            cursor: pointer;
        }

        input:last-of-type {
            margin: 0;
        }

        input:focus {
            outline: none;
        }

        input:checked {
            background: hotpink;
        }

        input+* {
            position: absolute;
            display: block;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            transform: translateX(100%);
            transition: transform ease-in-out 400ms;
            border-radius: 5px;
            overflow: hidden;
        }

        input+*[aria-label]:before {
            content: attr(aria-label);
            display: block;
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            font-size: 1.5rem;
            color: white;
            z-index: 1;
            padding: .5rem;
            background-color: rgba(0, 0, 0, 0.5);
        }

        input:checked+* {
            transform: translateX(0);
            z-index: 1;
        }

        input+*+*:not(input[type=radio]) {
            display: none;
        }
        
    </style>

        <input type="radio" name="image-slide" id="radio1" checked="checked">
        <picture class="sss">
            <img src="images/OIP (2).jpeg">
        </picture>

        <input type="radio" name="image-slide" id="radio2">
        <picture class="sss">
            <img src="images/OIP (6).jpeg" alt="">
        </picture>

        <input type="radio" name="image-slide" id="radio3">
        <picture class="sss">
            <a href="">
                <img src="images/OIP (3).jpeg" alt="">
            </a>
        </picture>

        <input type="radio" name="image-slide" id="radio4">
        <picture class="sss">
            <img src="images/book2.jpg" alt="">
        </picture>


    <script>
        let currentIndex = 0;
        const radios = document.querySelectorAll('input[name="image-slide"]');
        const totalSlides = radios.length;

        function showNextSlide() {
            radios[currentIndex].checked = false;
            currentIndex = (currentIndex + 1) % totalSlides;
            radios[currentIndex].checked = true;
        }

        // Change slide every 3 seconds
        setInterval(showNextSlide, 3000);
    </script>
