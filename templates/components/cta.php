<?php
function getCTA()
{
    $options = [
        "I'd love to connect and discuss further.",
        "Would be happy to explore opportunities with your team.",
        "Looking forward to your response."
    ];
    return $options[array_rand($options)];
}