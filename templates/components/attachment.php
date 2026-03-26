<?php

function getAttachmentLine()
{
    $options = [
        "I have attached my resume for your review.",
        "Please find my resume attached for your consideration.",
        "I've attached my resume for your reference.",
        "Kindly find my resume attached."
    ];

    return $options[array_rand($options)];
}