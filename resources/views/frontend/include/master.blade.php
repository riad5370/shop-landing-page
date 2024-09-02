<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('frontend')}}/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>

<body>
    @include('frontend.include.header')

    @yield('body')

    @include('frontend.include.footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    <script>
        // Assuming you have at least 12 cards in total
        const cards = document.querySelectorAll('.product-list .card');
        let currentIndex = 0;
        const itemsToShow = 6; // Number of cards to show on each button click

        function showCards() {
            for (let i = currentIndex; i < currentIndex + itemsToShow; i++) {
                if (i < cards.length) {
                    cards[i].classList.add('show');
                }
            }
            currentIndex += itemsToShow;

            // Hide the button if all cards are displayed
            if (currentIndex >= cards.length) {
                document.querySelector('.loadmore-btn').style.display = 'none';
            }
        }

        // Initially show the first set of cards
        showCards();

        // Add event listener to the Load More button
        document.querySelector('.loadmore-btn').addEventListener('click', showCards);
    </script>
    <script>
        $(document).ready(function() {

            $(".buttonplus").click(function() {
                var inputElement = $(this).parent().find("input");
                var total = inputElement.val();
                inputElement.val(++total);
            });
            $(".buttonminus").click(function() {
                var total = $(this).parent().find("input").val();
                $(this).parent().find("input").val(total - 1 < 0 ? 0 : --total); // Shorter version of if statment

                console.log($(this).val());
            });


            $("input").on("change paste keyup", function() {
                console.log($(this).parent().siblings("#total-price2").attr('data-price'));
                console.log($(this).val());


                var nitem = $(this).val(),
                    pitem = $(this).parent().siblings(".product").attr('data-price'),
                    result = parseFloat(nitem) * parseFloat(pitem);
                console.log(result);
            })
        });
    </script>
    <script>
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>
    @stack('js')

</body>

</html>