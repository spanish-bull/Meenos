<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script>

        function generate_star_rating(rate,max_rate, name_of_id,){
            var entier = Math.trunc(rate);
            var decimal = rate - entier;

            var max_rate= max_rate;

            var content = "";
            for (var i = 1; i<= entier; i++){
                content = content+"<i class='fas fa-star' style='color:#c8071a'></i>"
            }
            if (entier < max_rate){
                if (decimal <0.25){
                    content = content+"<i class='far fa-star' style='color:grey'></i>"
                }
                if (decimal <0.75 && decimal >= 0.25){
                    content = content+"<i class='fas fa-star-half-alt' style='color:#c8071a'></i>"
                }
                if (decimal >= 0.75){
                    content = content+"<i class='fas fa-star' style='color:#c8071a'></i>"
                }
            }
            for (var i = 1; i< max_rate - entier; i++){
                content = content+"<i class='far fa-star' style='color:grey'></i>"
            }
            document.getElementById(name_of_id).innerHTML=content;

        }
        //replace 5 par param notation (pour plus tard)

        //Ajout du nombre d'etoile pour le vote//
        function add_form_star(max_rate){
            var content = "";
            for (var i=1; i<=max_rate; i++){
                content = content+"<span data-rating-value='"+i+"' onclick='javascript:update_vote(id_conf, id_user, "+i+")'></span>"
            }
            document.getElementById("form_test").innerHTML=content;
        }
    </script>
    <!-- Style pour les hover_star-->
    <style>
        /* Initial state */
        form.modal-review__rating-order-wrap > span {
            display: block; float: left;
            height: 30px; width: 40px;
            background-image: url("data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20width='80'%20height='30'%3E%3Cpath%20d='M17.5,12.5h-8.5l6.8,5-2.6,8.1,6.8-5,6.8,5-2.6-8.1,6.8-5h-8.5l-2.6-8.1z'%20fill='%23c0c0c0'%20stroke='%23c0c0c0'/%3E%3Cpath%20d='M57.5,12.5h-8.5l6.8,5-2.6,8.1,6.8-5,6.8,5-2.6-8.1,6.8-5h-8.5l-2.6-8.1z'%20fill='%23c8071a'%20stroke='%23c8071a'/%3E%3C/svg%3E");
            background-position: 0px 0px;    /* gray star */
        }

        /* Persistent state */
        form.modal-review__rating-order-wrap[data-rating-value] > span {
            background-position: -40px 0px;  /* gold star */
        }
        form.modal-review__rating-order-wrap > span.active ~ span {
            background-position: 0px 0px;    /* gray star */
        }

        /* Hover state */
        form.modal-review__rating-order-wrap[class]:hover > span {
            background-position: -40px 0px;  /* gold star */
        }
        form.modal-review__rating-order-wrap[class] > span:hover ~ span {
            background-position: 0px 0px;    /* gray star */
        }

    </style>
</head>
<body>
<main>
    <!-- affichage des résultats-->
    <div id="test"></div>
    <!-- formulaire de vote-->
    <form id ="form_test" class="modal-review__rating-order-wrap">
    </form>
</main>
</body>
<script>
    generate_star_rating(5.2, 10, "test");
    add_form_star(10);
    $('.modal-review__rating-order-wrap > span').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parent().attr('data-rating-value', $(this).data('rating-value'));
    });
</script
</html> <?php
/**
 * Created by PhpStorm.
 * User: whhhynd
 * Date: 12/02/19
 * Time: 16:21
 */