<?php
require "components/subject.php";
require "components/greeting.php";
require "components/intro.php";
require "components/context.php";
require "components/skills.php";
require "components/attachment.php";
require "components/cta.php";
require "components/closing.php";

function buildEmail($data) {

    return implode("\n\n", [
        getGreeting($data),
        getIntro(),
        getContext($data),
        getSkills(),
        getAttachmentLine(),
        getCTA(),
        getClosing()
    ]);
}