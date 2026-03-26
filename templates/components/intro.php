<?php
function getIntro()
{
    $intros = [
        "I hope you're doing well.",
        "Hope you're having a great day.",
        "Hope this message finds you well."
    ];
    return $intros[array_rand($intros)];
}
