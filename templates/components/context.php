<?php
function getContext($data)
{
    $options = [
        "I came across {$data['company']} and wanted to explore opportunities.",
        "I was exploring companies and found {$data['company']} interesting.",
        "I'm reaching out regarding opportunities at {$data['company']}."
    ];
    return $options[array_rand($options)];
}
