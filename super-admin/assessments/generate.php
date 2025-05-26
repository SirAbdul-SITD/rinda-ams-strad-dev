<?php
// Function to generate random question
function generateQuestion() {
    $questions = [
        "What is the capital of [country]?",
        "How many sides does a [shape] have?",
        "Who wrote [book]?",
        "What is the chemical symbol for [element]?",
        "What is the square root of [number]?",
        "Who discovered [discovery]?",
        "What is the scientific name of [animal]?",
        "What is the formula for [compound]?",
        "What is the main function of [organ]?",
        "How many planets are there in our solar system?"
    ];
    
    // Replace placeholders with random data
    $question = $questions[array_rand($questions)];
    $question = str_replace("[country]", generateRandomCountry(), $question);
    $question = str_replace("[shape]", generateRandomShape(), $question);
    $question = str_replace("[book]", generateRandomBook(), $question);
    $question = str_replace("[element]", generateRandomElement(), $question);
    $question = str_replace("[number]", mt_rand(1, 100), $question);
    $question = str_replace("[discovery]", generateRandomDiscovery(), $question);
    $question = str_replace("[animal]", generateRandomAnimal(), $question);
    $question = str_replace("[compound]", generateRandomCompound(), $question);
    $question = str_replace("[organ]", generateRandomOrgan(), $question);
    
    return $question;
}

// Function to generate random answer
function generateAnswer() {
    $answers = [
        "Option A",
        "Option B",
        "Option C",
        "Option D",
        "None of the above"
    ];
    return $answers[array_rand($answers)];
}

// Function to generate a random country name
function generateRandomCountry() {
    $countries = ["USA", "UK", "Canada", "Australia", "India", "China", "Brazil", "Germany", "France", "Japan"];
    return $countries[array_rand($countries)];
}

// Function to generate a random shape name
function generateRandomShape() {
    $shapes = ["triangle", "rectangle", "circle", "square", "pentagon", "hexagon", "octagon", "ellipse", "parallelogram", "trapezoid"];
    return $shapes[array_rand($shapes)];
}

// Function to generate a random book title
function generateRandomBook() {
    $books = ["Harry Potter", "Lord of the Rings", "To Kill a Mockingbird", "Pride and Prejudice", "The Catcher in the Rye", "1984", "The Great Gatsby", "Animal Farm", "The Hobbit", "Brave New World"];
    return $books[array_rand($books)];
}

// Function to generate a random element symbol
function generateRandomElement() {
    $elements = ["H", "He", "Li", "Be", "B", "C", "N", "O", "F", "Ne"];
    return $elements[array_rand($elements)];
}

// Function to generate a random scientific discovery
function generateRandomDiscovery() {
    $discoveries = ["Penicillin", "DNA", "Gravity", "Electricity", "Relativity", "Evolution", "Atomic theory", "Radioactivity", "Cell theory", "Big Bang theory"];
    return $discoveries[array_rand($discoveries)];
}

// Function to generate a random animal name
function generateRandomAnimal() {
    $animals = ["Lion", "Tiger", "Elephant", "Giraffe", "Kangaroo", "Panda", "Hippopotamus", "Zebra", "Rhino", "Cheetah"];
    return $animals[array_rand($animals)];
}

// Function to generate a random compound name
function generateRandomCompound() {
    $compounds = ["Water", "Carbon dioxide", "Salt", "Glucose", "Ethanol", "Ammonia", "Chlorine", "Methane", "Sulfuric acid", "Hydrochloric acid"];
    return $compounds[array_rand($compounds)];
}

// Function to generate a random organ name
function generateRandomOrgan() {
    $organs = ["Heart", "Brain", "Lung", "Liver", "Kidney", "Stomach", "Intestine", "Pancreas", "Spleen", "Bladder"];
    return $organs[array_rand($organs)];
}

// Generate and output questions and answers
$subjects = ["Mathematics", "English", "Science", "Social Studies", "Art", "Music", "Physical Education", "History", "Geography", "Computer Science"];

echo "<table class='table table-borderless table-hover'>";
echo "<thead><tr><th>#</th><th>Question</th><th>Answer</th><th>Subject</th></tr></thead>";
echo "<tbody>";

foreach ($subjects as $subject) {
    for ($i = 1; $i <= 5; $i++) {
        echo "<tr>";
        echo "<td>{$i}</td>";
        echo "<td>" . generateQuestion() . "</td>";
        echo "<td>" . generateAnswer() . "</td>";
        echo "<td>{$subject}</td>";
        echo "</tr>";
    }
}

echo "</tbody></table>";
?>
