<?php

function getSkills()
{
    $options = [
        "I have experience in Node.js, React, and full-stack development.",
        "My experience includes MERN stack and scalable web applications.",
        "I've worked on frontend and backend systems focusing on performance."
    ];
    return $options[array_rand($options)];
}
