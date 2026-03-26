<?php

function getSubject($data)
{

    $subjects = [
        "Application for Full Stack Developer at {$data['company']}",
        "Full Stack Developer Opportunity - {$data['company']}",
        "Interested in Full Stack Role at {$data['company']}",
        "Application: Full Stack Developer Position"
    ];

    return $subjects[array_rand($subjects)];
}
