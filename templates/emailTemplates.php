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
function fullStackTemplates($data)
{

    $name = $data['name'];
    $company = $data['company'];
    $intro = getIntro();

    $templates = [

        "Hi {$name},

{$intro}

I came across {$company} and wanted to apply for a Full Stack Developer role.

I have hands-on experience in Node.js, Angular, and building scalable web applications.

Please find my cv attached for your reference. I would love to contribute and be part of your team.

Regards,  
Vibhu Tripathi,
7081229558",


        "Hi {$name},

{$intro}

I am reaching out regarding potential Full Stack Developer opportunities at {$company}.

With experience in MEAN stack and modern web technologies, I focus on building efficient and maintainable solutions.

Please find my cv attached for your reference. Would be happy to connect and discuss further.

Regards,  
Vibhu Tripathi,
7081229558",


        "Hi {$name},

{$intro}

I recently explored {$company} and found it very interesting.

I am a Full Stack Developer with experience in Node.js, Angular, and backend APIs, and I am currently looking for new opportunities.

Please find my cv attached for your reference. Looking forward to hearing from you.

Regards,  
Vibhu Tripathi,
7081229558",


        "Hi {$name},

{$intro}

I wanted to check if there are any Full Stack Developer openings at {$company}.

I have worked on multiple frontend and backend projects, focusing on performance and scalability.
Please find my cv attached for your reference. Kindly let me know if any further information is required.

Would love to connect.

Regards,  
Vibhu Tripathi,
7081229558",

        "Hi {$name},

{$intro}

I am writing to express my interest in the Full Stack Developer position. I have around 2 years of experience in full-stack development, working with technologies such as Node.js, React, MongoDB, and REST APIs.

I have experience building scalable web applications, developing reusable frontend components, designing backend APIs, and integrating databases to create efficient and production-ready systems. I focus on writing clean, maintainable code and delivering reliable solutions.

I would welcome the opportunity to discuss how my skills and experience can contribute to your team. I am available to join immediately.

Please find my cv attached for your reference. Kindly let me know if any further information is required.

Regards,
Vibhu Tripathi,
7081229558"
    ];

    return $templates[array_rand($templates)];
}


// 🎯 Main Template Controller
function getEmailTemplate($data, $type = 'fullstack')
{

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
