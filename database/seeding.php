<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "news";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dummy post data
$titles = [
    "Breaking News: Major Political Shakeup!",
    "Tech Innovations of the Year Revealed",
    "New Study Highlights Health Benefits of Coffee",
    "Sports Update: Local Team Clinches Victory",
    "Environment Alert: Rising Sea Levels",
    "Lifestyle Tips for a Healthier You",
    "Finance Report: Markets Surge Amid Optimism",
    "Scientists Discover New Species in Rainforest",
    "Athlete Sets New Record in Marathon",
    "Political Debate Draws Crowds Nationwide",
    "Tech Giants Unveil Next-Gen Devices",
    "Wellness Guide: Managing Stress Effectively",
    "Sports Rivalry Heats Up Ahead of Finals",
    "Climate Change Initiatives Gain Momentum",
    "Financial Strategies for Young Professionals",
    "Health Experts Warn of New Virus Strain",
    "Exploring the Future of Electric Vehicles",
    "Fitness Routine to Kickstart Your Day",
    "Economic Challenges Facing Small Businesses",
    "Conservation Efforts Boost Endangered Species"
];

// Inserting dummy posts
for ($i = 0; $i < 20; $i++) {
    $title = $titles[array_rand($titles)];
    $content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec vehicula sapien. Proin ac nibh vitae velit consectetur tincidunt.";
    $status = 'published';
    $category_id = 1;
    $user_id = 1;

    $sql = "INSERT INTO posts (title, content, status, category_id, user_id) VALUES ('$title', '$content', '$status', $category_id, $user_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Post '$title' added successfully<br>";
        echo '<a href="home"> GO HOME </a>';
    } else {
        echo "Error adding post: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
