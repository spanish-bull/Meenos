<script>

        function generate_star_rating(rate, name_of_id,){
            var entier = Math.trunc(rate);
            var decimal = rate - entier;

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
            for (var i = 1; i< 5 - entier; i++){
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

<script>
    $('.modal-review__rating-order-wrap > span').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parent().attr('data-rating-value', $(this).data('rating-value'));
    });
</script><?php
/**
 * Created by PhpStorm.
 * User: whhhynd
 * Date: 12/02/19
 * Time: 16:21
 */