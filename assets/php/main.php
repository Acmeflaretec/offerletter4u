<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $location = $_POST["location"];
    $presentSalary = $_POST["presentSalary"];
    $expectedSalary = $_POST["expectedSalary"];
    $salesExperience = $_POST["salesExperience"];
    $insuranceExperience = $_POST["insuranceExperience"];

    $cvFile = $_FILES["cv"];

    // Prepare the email body
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Preferred Location: $location\n";
    $body .= "Present Salary: $presentSalary\n";
    $body .= "Expected Salary: $expectedSalary\n";
    $body .= "Sales Experience: $salesExperience\n";
    $body .= "Insurance Experience: $insuranceExperience\n";

    // Prepare the email headers
    $to = "ananthumanoj999@gmail.com";
    $subject = "Job Application";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Attach the CV file
    $attachmentPath = $cvFile["tmp_name"];
    $attachmentName = $cvFile["name"];
    $attachmentType = $cvFile["type"];

    if (!empty($attachmentPath)) {
        $attachment = chunk_split(base64_encode(file_get_contents($attachmentPath)));
        $headers .= "Content-Type: $attachmentType;\n\tboundary=\"_BOUNDARY_\"\n\n";
        $body = "--_BOUNDARY_\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\n";
        $body .= "Content-Transfer-Encoding: 8bit\n\n";
        $body .= $body . "\n\n";
        $body .= "--_BOUNDARY_\n";
        $body .= "Content-Type: $attachmentType; name=\"$attachmentName\"\n";
        $body .= "Content-Transfer-Encoding: base64\n";
        $body .= "Content-Disposition: attachment; filename=\"$attachmentName\"\n\n";
        $body .= $attachment . "\n";
        $body .= "--_BOUNDARY_--\n";
    }

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "Email sent successfully.";
    } else {
        echo "Failed to send email.";
    }
}
?>