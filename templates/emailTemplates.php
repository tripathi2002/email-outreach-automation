<?php

// 🎯 Get Subject
function getSubject($data, $type = 'fullstack')
{

    $subjects = [
        "Application for Full Stack Developer at {$data['company']}",
        "Full Stack Developer Opportunity - {$data['company']}",
        "Interested in Full Stack Role at {$data['company']}",
        "Application: Full Stack Developer Position"
    ];

    return $subjects[array_rand($subjects)];
}


// 🎯 Get Intro Line
function getIntro()
{
    $intros = [
        "I hope you're doing well.",
        "Hope you're having a great day.",
        "Hope this message finds you well."
    ];

    return $intros[array_rand($intros)];
}

// 🎯 Template Variations (Full Stack)
function fullStackTemplates($data) {

    $name = $data['name'];
    $company = $data['company'];
    $intro = getIntro();

    $templates = [

        "Hi {$name},

{$intro}

I came across {$company} and wanted to apply for a Full Stack Developer role.

I have hands-on experience in Node.js, Angular, and building scalable web applications.

I would love to contribute and be part of your team.

Regards,  
Vibhu Tripathi",


        "Hi {$name},

{$intro}

I am reaching out regarding potential Full Stack Developer opportunities at {$company}.

With experience in MEAN stack and modern web technologies, I focus on building efficient and maintainable solutions.

Would be happy to connect and discuss further.

Regards,  
Vibhu Tripathi",


        "Hi {$name},

{$intro}

I recently explored {$company} and found it very interesting.

I am a Full Stack Developer with experience in Node.js, Angular, and backend APIs, and I am currently looking for new opportunities.

Looking forward to hearing from you.

Regards,  
Vibhu Tripathi",


        "Hi {$name},

{$intro}

I wanted to check if there are any Full Stack Developer openings at {$company}.

I have worked on multiple frontend and backend projects, focusing on performance and scalability.

Would love to connect.

Regards,  
Vibhu Tripathi"
    ];

    return $templates[array_rand($templates)];
}


// 🎯 Main Template Controller
function getEmailTemplate($data, $type = 'fullstack') {

    switch ($type) {
        case 'fullstack':
            return fullStackTemplates($data);

        // future expansion
        // case 'frontend':
        //     return frontendTemplates($data);

        // case 'backend':
        //     return backendTemplates($data);

        default:
            return fullStackTemplates($data);
    }
}
